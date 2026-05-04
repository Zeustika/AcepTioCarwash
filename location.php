<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(0);
require 'koneksi/koneksi.php';

// Haversine formula implementation
function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    $earthRadius = 6378; // Earth's radius in kilometers

    $latDelta = deg2rad($lat2 - $lat1);
    $lonDelta = deg2rad($lon2 - $lon1);

    $lat1 = deg2rad($lat1);
    $lat2 = deg2rad($lat2);

    $a = sin($latDelta/2) * sin($latDelta/2) +
         cos($lat1) * cos($lat2) * 
         sin($lonDelta/2) * sin($lonDelta/2);
    
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    
    return round($earthRadius * $c, 2);
}

// Get real-time availability for washing points
function getWashingPointAvailability($koneksi, $washingPointId) {
    try {
        $sql = "SELECT 
                    COUNT(*) as current_bookings,
                    (SELECT capacity FROM tblwashingpoints WHERE id = :washingPointId) as capacity
                FROM tblcarwashbooking 
                WHERE carWashPoint = :washingPointId 
                AND washDate = CURDATE()
                AND status NOT IN ('Cancelled', 'Completed')";
        
        $query = $koneksi->prepare($sql);
        $query->bindParam(':washingPointId', $washingPointId, PDO::PARAM_INT);
        $query->execute();
        
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return [
            'available' => ($result['current_bookings'] < $result['capacity']),
            'current_bookings' => $result['current_bookings'],
            'capacity' => $result['capacity']
        ];
    } catch (PDOException $e) {
        return [
            'available' => true,
            'current_bookings' => 0,
            'capacity' => 5
        ];
    }
}

// Fixed washing points with coordinates
$washingPointsWithCoords = [
    [
        'id' => 1,
        'washingPointName' => 'Tio Carwash',
        'washingPointAddress' => 'Setiawargi',
        'lat' => -7.41681270,
        'lng' => 108.24450930,
        'contactNo' => '087783821979',
        'openingHours' => '8:00 AM - 9:00 PM',
        'capacity' => 20,
        'services' => ['Cuci Motor', 'Cuci Mobil', 'Cuci Truck']
    ],
];

// Get user-submitted washing points from database
$userWashingPoints = [];
if ($koneksi) {
    try {
        $sql = "SELECT * FROM user_washing_points WHERE status = 'approved'";
        $query = $koneksi->prepare($sql);
        $query->execute();
        $userWashingPoints = $query->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($userWashingPoints as &$point) {
            $availability = getWashingPointAvailability($koneksi, $point['id']);
            $point['availability'] = $availability;
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
    }
}

$allWashingPoints = array_merge($washingPointsWithCoords, $userWashingPoints);

include 'header.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Lokasi Car Wash - Rental Mobil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        /* Map Styles */
        #map {
            height: 600px;
            width: 100%;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            border: 1px solid #e0e0e0;
            overflow: hidden;
        }

        .map-container {
            position: relative;
            margin-bottom: 60px;
        }

        /* Search Box */
        .search-box {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 1000;
            background: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            width: 350px;
        }

        .search-box .input-group {
            border-radius: 8px;
            overflow: hidden;
        }

        .search-box .form-control {
            border: 2px solid #e0e0e0;
            padding: 12px 15px;
            font-size: 14px;
            border-right: none;
            font-weight: 500;
        }

        .search-box .form-control:focus {
            box-shadow: none;
            border-color: #C9A961;
        }

        .search-box .btn {
            border: 2px solid #C9A961;
            border-left: none;
            background: #C9A961;
            color: white;
            padding: 12px 20px;
        }

        .search-box .btn:hover {
            background: #B8985A;
            border-color: #B8985A;
        }

        /* Map Controls */
        .map-controls {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            gap: 10px;
            min-width: 160px;
        }

        .map-controls .btn {
            width: 100%;
            padding: 12px 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            border-radius: 8px;
            font-size: 14px;
        }

        .map-controls .btn-primary {
            background: #C9A961;
            border-color: #C9A961;
        }

        .map-controls .btn-primary:hover {
            background: #B8985A;
            border-color: #B8985A;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(201, 169, 97, 0.3);
        }

        .map-controls .btn-success {
            background: #1a1a1a;
            border-color: #1a1a1a;
        }

        .map-controls .btn-success:hover {
            background: #000000;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        /* Location Cards */
        .location-item {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
            height: 100%;
        }

        .location-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 32px rgba(201, 169, 97, 0.15);
            border-color: #C9A961;
        }

        .location-item .icon-wrapper {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #C9A961, #B8985A);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .location-item:hover .icon-wrapper {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 8px 20px rgba(201, 169, 97, 0.4);
        }

        .location-item .icon-wrapper i {
            font-size: 28px;
            color: white;
        }

        .location-text h3 {
            color: #1a1a1a;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 15px;
            letter-spacing: -0.02em;
        }

        .location-text p {
            margin-bottom: 12px;
            color: #666;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }

        .location-text p i {
            color: #C9A961;
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .distance-info {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
            color: #1a1a1a;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
        }

        .distance-info i {
            color: #C9A961;
            font-size: 18px;
        }

        .availability-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            margin-top: 10px;
        }

        .availability-badge.available {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .availability-badge.full {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        /* Popup Styles */
        .washing-point-popup {
            min-width: 300px;
            padding: 10px;
        }

        .washing-point-popup h5 {
            color: #1a1a1a;
            margin-bottom: 15px;
            font-size: 20px;
            font-weight: 700;
            border-bottom: 2px solid #C9A961;
            padding-bottom: 10px;
        }

        .washing-point-popup p {
            margin-bottom: 10px;
            color: #666;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }

        .washing-point-popup i {
            color: #C9A961;
            width: 18px;
            text-align: center;
        }

        /* Modal Styles */
        .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: white;
            border-radius: 16px 16px 0 0;
            padding: 1.5rem 2rem;
            border-bottom: 3px solid #C9A961;
        }

        .modal-header h5 {
            font-weight: 700;
            font-size: 20px;
        }

        .modal-header .close {
            color: white;
            opacity: 0.8;
            text-shadow: none;
        }

        .modal-header .close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-body .form-group label {
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
            font-size: 14px;
        }

        .modal-body .form-control {
            border: 2px solid #e0e0e0;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 14px;
        }

        .modal-body .form-control:focus {
            border-color: #C9A961;
            box-shadow: 0 0 0 0.2rem rgba(201, 169, 97, 0.15);
        }

        #modalMap {
            height: 300px;
            width: 100%;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
        }

        /* Section Title */
        .section-title {
            margin-bottom: 50px;
            text-align: center;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 15px;
            letter-spacing: -0.02em;
        }

        .section-title p {
            color: #666;
            font-size: 16px;
            max-width: 600px;
            margin: 0 auto;
        }

        /* User Location Marker */
        .user-location-marker {
            animation: pulse-marker 2s infinite;
        }

        @keyframes pulse-marker {
            0%, 100% { 
                transform: scale(1);
                opacity: 1;
            }
            50% { 
                transform: scale(1.2);
                opacity: 0.8;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .search-box {
                width: calc(100% - 40px);
                position: static;
                margin-bottom: 15px;
            }

            .map-controls {
                flex-direction: row;
                width: calc(100% - 40px);
                position: static;
                margin-bottom: 15px;
            }

            .map-controls .btn {
                flex: 1;
                font-size: 13px;
                padding: 10px;
            }

            #map {
                height: 450px;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .location-item {
                padding: 1.5rem;
            }
        }

        /* Loading Animation */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            border-radius: 16px;
        }

        .loading-overlay .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f0f0f0;
            border-top: 4px solid #C9A961;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body>
    <div class="container" style="margin-top: 3rem; margin-bottom: 4rem;">
        <!-- Page Header -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="section-title">
                    <h2>
                        <i class="fa fa-map-marker" style="color: #C9A961; margin-right: 15px;"></i>
                        Lokasi Car Wash
                    </h2>
                    <p>Temukan lokasi car wash terdekat dengan Anda dan nikmati layanan terbaik kami</p>
                    <div class="premium-line" style="max-width: 200px; margin: 1.5rem auto;"></div>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="row">
            <div class="col-12">
                <div class="map-container">
                    <!-- Search Box -->
                    <div class="search-box">
                        <div class="input-group">
                            <input type="text" 
                                   id="searchInput" 
                                   class="form-control" 
                                   placeholder="Cari lokasi..."
                                   onkeypress="if(event.keyCode==13) document.getElementById('searchButton').click();">
                            <button class="btn btn-primary" type="button" id="searchButton">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Map Controls -->
                    <div class="map-controls">
                        <button class="btn btn-primary" id="locateMe">
                            <i class="fa fa-crosshairs"></i> Lokasi Saya
                        </button>
                        <?php if (isset($_SESSION['USER']) && $_SESSION['USER']['level'] == 'admin'): ?>
                        <button class="btn btn-success" id="addWashingPoint" data-toggle="modal" data-target="#addWashingPointModal">
                            <i class="fa fa-plus"></i> Tambah Lokasi
                        </button>
                        <?php endif; ?>
                    </div>

                    <!-- Map -->
                    <div id="map"></div>
                </div>
            </div>
        </div>

        <!-- Locations List -->
        <div class="row">
            <div class="col-12 mb-4">
                <h3 class="font-weight-bold" style="color: #1a1a1a; font-size: 1.75rem; letter-spacing: -0.02em;">
                    <i class="fa fa-list-ul mr-2" style="color: #C9A961;"></i>
                    Daftar Lokasi Car Wash
                </h3>
                <div class="premium-line" style="max-width: 100px; margin: 1rem 0 2rem 0;"></div>
            </div>
        </div>

        <div class="row">
            <?php foreach ($allWashingPoints as $point): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="location-item">
                    <div class="icon-wrapper">
                        <i class="fa fa-map-marker"></i>
                    </div>
                    <div class="location-text">
                        <h3><?php echo htmlspecialchars($point['washingPointName']); ?></h3>
                        <p>
                            <i class="fa fa-map-marker"></i>
                            <?php echo htmlspecialchars($point['washingPointAddress']); ?>
                        </p>
                        <p>
                            <i class="fa fa-phone"></i>
                            <a href="tel:<?php echo htmlspecialchars($point['contactNo']); ?>" style="color: #666; text-decoration: none;">
                                <?php echo htmlspecialchars($point['contactNo']); ?>
                            </a>
                        </p>
                        <p>
                            <i class="fa fa-clock-o"></i>
                            <?php echo htmlspecialchars($point['openingHours']); ?>
                        </p>
                        
                        <?php if (isset($point['capacity'])): ?>
                        <span class="availability-badge available">
                            <i class="fa fa-wrench mr-1"></i>
                            Kapasitas: <?php echo $point['capacity']; ?> unit
                        </span>
                        <?php endif; ?>
                        
                        <div class="distance-info" id="distance-<?php echo $point['id']; ?>">
                            <i class="fa fa-location-arrow"></i>
                            <span>Klik "Lokasi Saya" untuk melihat jarak</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Info Box -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0" style="background: rgba(201, 169, 97, 0.05); border-left: 4px solid #C9A961 !important;">
                    <div class="card-body" style="padding: 1.5rem 2rem;">
                        <h6 class="mb-2 font-weight-bold" style="color: #1a1a1a;">
                            <i class="fa fa-info-circle mr-2" style="color: #C9A961;"></i>
                            Tips Mencari Lokasi
                        </h6>
                        <ul class="mb-0" style="font-size: 14px; color: #666; padding-left: 1.5rem;">
                            <li class="mb-1">Klik tombol "Lokasi Saya" untuk melihat jarak dari posisi Anda</li>
                            <li class="mb-1">Gunakan fitur pencarian untuk menemukan lokasi spesifik</li>
                            <li class="mb-1">Klik marker di peta untuk melihat detail informasi lokasi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['USER']) && $_SESSION['USER']['level'] == 'admin'): ?>
    <!-- Add New Washing Point Modal -->
    <div class="modal fade" id="addWashingPointModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-plus-circle mr-2"></i>
                        Tambah Lokasi Car Wash
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addWashingPointForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        <i class="fa fa-building mr-2" style="color: #C9A961;"></i>
                                        Nama Lokasi
                                    </label>
                                    <input type="text" class="form-control" name="name" placeholder="Contoh: Tio Carwash" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        <i class="fa fa-phone mr-2" style="color: #C9A961;"></i>
                                        Nomor Kontak
                                    </label>
                                    <input type="tel" class="form-control" name="contact" placeholder="08xxxxxxxxxx" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>
                                <i class="fa fa-map-marker mr-2" style="color: #C9A961;"></i>
                                Alamat Lengkap
                            </label>
                            <textarea class="form-control" name="address" rows="2" placeholder="Masukkan alamat lengkap" required></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        <i class="fa fa-clock-o mr-2" style="color: #C9A961;"></i>
                                        Jam Operasional
                                    </label>
                                    <input type="text" class="form-control" name="hours" placeholder="Contoh: 8:00 AM - 9:00 PM" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        <i class="fa fa-wrench mr-2" style="color: #C9A961;"></i>
                                        Kapasitas (Unit)
                                    </label>
                                    <input type="number" class="form-control" name="capacity" placeholder="5" min="1" value="5" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>
                                <i class="fa fa-map mr-2" style="color: #C9A961;"></i>
                                Pilih Lokasi di Peta
                            </label>
                            <small class="d-block text-muted mb-2">Klik pada peta untuk menentukan koordinat lokasi</small>
                            <div id="modalMap"></div>
                            <input type="text" class="form-control mt-2" id="selectedLocation" readonly placeholder="Klik pada peta untuk memilih lokasi">
                            <input type="hidden" name="latitude" id="selectedLat">
                            <input type="hidden" name="longitude" id="selectedLng">
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f0f0f0; padding: 1.5rem 2rem;">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" style="padding: 0.75rem 1.5rem; font-weight: 600;">
                        <i class="fa fa-times mr-2"></i>
                        Batal
                    </button>
                    <button type="button" class="btn btn-primary" id="submitWashingPoint" style="padding: 0.75rem 1.5rem; font-weight: 600;">
                        <i class="fa fa-save mr-2"></i>
                        Simpan Lokasi
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        // Initialize map
        const map = L.map('map').setView([-7.41681270, 108.24450930], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Custom marker icon
        const customIcon = L.divIcon({
            className: 'custom-marker',
            html: '<i class="fa fa-map-marker" style="color: #C9A961; font-size: 36px; text-shadow: 0 2px 4px rgba(0,0,0,0.3);"></i>',
            iconSize: [30, 42],
            iconAnchor: [15, 42],
            popupAnchor: [0, -42]
        });

        // Washing points data
        const washingPoints = <?php echo json_encode($allWashingPoints); ?>;
        const markers = [];

        washingPoints.forEach(point => {
            const marker = L.marker([point.lat, point.lng], { icon: customIcon }).addTo(map);
            markers.push(marker);
            
            const popupContent = `
                <div class="washing-point-popup">
                    <h5>${point.washingPointName}</h5>
                    <p><i class="fa fa-map-marker"></i> ${point.washingPointAddress}</p>
                    <p><i class="fa fa-phone"></i> <a href="tel:${point.contactNo}">${point.contactNo}</a></p>
                    <p><i class="fa fa-clock-o"></i> ${point.openingHours}</p>
                    ${point.capacity ? `<p><i class="fa fa-wrench"></i> Kapasitas: ${point.capacity} unit</p>` : ''}
                </div>
            `;
            
            marker.bindPopup(popupContent);
        });

        if (markers.length > 0) {
            const group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.1));
        }

        let userLocation = null;
        let userMarker = null;

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6378;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
                      Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }

        function updateDistances() {
            if (!userLocation) return;
            
            washingPoints.forEach((point) => {
                const distance = calculateDistance(
                    userLocation.lat,
                    userLocation.lng,
                    point.lat,
                    point.lng
                );
                
                const distanceElement = document.getElementById(`distance-${point.id}`);
                if (distanceElement) {
                    distanceElement.innerHTML = `<i class="fa fa-route"></i> Jarak: ${distance.toFixed(2)} km dari lokasi Anda`;
                }
            });
        }

        document.getElementById('locateMe').addEventListener('click', () => {
            const btn = document.getElementById('locateMe');
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Mencari...';
            btn.disabled = true;

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                    
                        map.setView([userLocation.lat, userLocation.lng], 14);
                    
                        // Remove old user marker if exists
                        if (userMarker) map.removeLayer(userMarker);
                        
                        // Add new user marker with custom icon
                        userMarker = L.marker([userLocation.lat, userLocation.lng], {
                            icon: L.divIcon({
                                className: 'user-location-marker',
                                html: '<i class="fa fa-user-circle" style="color: #007bff; font-size: 36px; text-shadow: 0 2px 4px rgba(0,0,0,0.3);"></i>',
                                iconSize: [36, 36],
                                iconAnchor: [18, 18]
                            })
                        }).addTo(map);
                        
                        userMarker.bindPopup(`
                            <div class="washing-point-popup">
                                <h5><i class="fa fa-map-marker mr-2"></i>Lokasi Anda</h5>
                                <p>Lat: ${userLocation.lat.toFixed(6)}</p>
                                <p>Lng: ${userLocation.lng.toFixed(6)}</p>
                            </div>
                        `);
                    
                        updateDistances();
                        
                        btn.innerHTML = originalHTML;
                        btn.disabled = false;
                        
                        // Show success notification
                        showNotification('Lokasi berhasil ditemukan!', 'success');
                    },
                    (error) => {
                        btn.innerHTML = originalHTML;
                        btn.disabled = false;
                        
                        let errorMessage = 'Tidak dapat menemukan lokasi Anda. ';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += 'Izin akses lokasi ditolak.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage += 'Informasi lokasi tidak tersedia.';
                                break;
                            case error.TIMEOUT:
                                errorMessage += 'Waktu pencarian lokasi habis.';
                                break;
                        }
                        showNotification(errorMessage, 'error');
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                btn.innerHTML = originalHTML;
                btn.disabled = false;
                showNotification('Geolocation tidak didukung oleh browser Anda', 'error');
            }
        });

        document.getElementById('searchButton').addEventListener('click', () => {
            const searchInput = document.getElementById('searchInput').value.trim();
            
            if (!searchInput) {
                showNotification('Silakan masukkan lokasi yang ingin dicari', 'warning');
                return;
            }

            const btn = document.getElementById('searchButton');
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
            btn.disabled = true;

            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(searchInput)}`)
                .then(response => response.json())
                .then(data => {
                    btn.innerHTML = originalHTML;
                    btn.disabled = false;
                    
                    if (data.length > 0) {
                        const { lat, lon } = data[0];
                        map.setView([lat, lon], 14);
                        
                        userLocation = { lat: parseFloat(lat), lng: parseFloat(lon) };
                        
                        // Remove old marker and add new one
                        if (userMarker) map.removeLayer(userMarker);
                        userMarker = L.marker([lat, lon], {
                            icon: L.divIcon({
                                className: 'search-location-marker',
                                html: '<i class="fa fa-search" style="color: #C9A961; font-size: 32px; text-shadow: 0 2px 4px rgba(0,0,0,0.3);"></i>',
                                iconSize: [32, 32],
                                iconAnchor: [16, 16]
                            })
                        }).addTo(map);
                        
                        userMarker.bindPopup(`
                            <div class="washing-point-popup">
                                <h5><i class="fa fa-search mr-2"></i>${searchInput}</h5>
                                <p>Hasil pencarian</p>
                            </div>
                        `).openPopup();
                        
                        updateDistances();
                        showNotification('Lokasi ditemukan!', 'success');
                    } else {
                        showNotification('Lokasi tidak ditemukan. Coba kata kunci lain.', 'warning');
                    }
                })
                .catch(error => {
                    btn.innerHTML = originalHTML;
                    btn.disabled = false;
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan saat mencari lokasi', 'error');
                });
        });

        // Notification function
        function showNotification(message, type = 'info') {
            const colors = {
                'success': '#28a745',
                'error': '#dc3545',
                'warning': '#ffc107',
                'info': '#007bff'
            };

            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${colors[type]};
                color: white;
                padding: 15px 25px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.2);
                z-index: 9999;
                font-weight: 600;
                animation: slideInRight 0.3s ease;
            `;
            notification.innerHTML = `<i class="fa fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'times-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} mr-2"></i>${message}`;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        <?php if (isset($_SESSION['USER']) && $_SESSION['USER']['level'] == 'admin'): ?>
        let modalMap;
        let modalMarker;

        $('#addWashingPointModal').on('shown.bs.modal', function () {
            if (!modalMap) {
                modalMap = L.map('modalMap').setView([-7.41681270, 108.24450930], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(modalMap);
                
                modalMap.on('click', function(e) {
                    const lat = e.latlng.lat.toFixed(8);
                    const lng = e.latlng.lng.toFixed(8);
                    $('#selectedLocation').val(`${lat}, ${lng}`);
                    $('#selectedLat').val(lat);
                    $('#selectedLng').val(lng);
                    
                    if (modalMarker) {
                        modalMarker.setLatLng(e.latlng);
                    } else {
                        modalMarker = L.marker(e.latlng, {
                            icon: L.divIcon({
                                className: 'modal-marker',
                                html: '<i class="fa fa-map-marker" style="color: #C9A961; font-size: 36px;"></i>',
                                iconSize: [30, 42],
                                iconAnchor: [15, 42]
                            })
                        }).addTo(modalMap);
                    }
                });
            }
            setTimeout(function() {
                modalMap.invalidateSize();
            }, 10);
        });

        $('#addWashingPointModal').on('hidden.bs.modal', function () {
            if (modalMarker && modalMap) {
                modalMap.removeLayer(modalMarker);
                modalMarker = null;
            }
            $('#addWashingPointForm')[0].reset();
            $('#selectedLocation').val('');
            $('#selectedLat').val('');
            $('#selectedLng').val('');
        });

        document.getElementById('submitWashingPoint').addEventListener('click', () => {
            const form = document.getElementById('addWashingPointForm');
            
            // Validate form
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const lat = $('#selectedLat').val();
            const lng = $('#selectedLng').val();
            
            if (!lat || !lng) {
                showNotification('Silakan pilih lokasi di peta terlebih dahulu', 'warning');
                return;
            }

            const btn = document.getElementById('submitWashingPoint');
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i> Menyimpan...';
            btn.disabled = true;
            
            const formData = new FormData(form);
            
            fetch('koneksi/add_washing_point.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                btn.innerHTML = originalHTML;
                btn.disabled = false;
                
                if (data.success) {
                    showNotification('Lokasi berhasil ditambahkan!', 'success');
                    $('#addWashingPointModal').modal('hide');
                    
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showNotification('Error: ' + (data.message || 'Gagal menambahkan lokasi'), 'error');
                }
            })
            .catch(error => {
                btn.innerHTML = originalHTML;
                btn.disabled = false;
                console.error('Error:', error);
                showNotification('Terjadi kesalahan saat menambahkan lokasi', 'error');
            });
        });
        <?php endif; ?>

        // Animation styles
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(400px);
                    opacity: 0;
                }
            }

            .leaflet-popup-content-wrapper {
                border-radius: 12px;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            }

            .leaflet-popup-tip {
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }
        `;
        document.head.appendChild(style);
    </script>

<?php include 'footer.php'; ?>
</body>
</html>