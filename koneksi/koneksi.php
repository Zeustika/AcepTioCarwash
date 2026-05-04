<?php
    $user = 'root';
    $pass = '';

    $koneksi = new PDO("mysql:host=localhost;port=33099;dbname=Tiocarwash", $user, $pass);

    global $url;
    $url = "https://cancel-ingredients-bird-discusses.trycloudflare.com/aceptio/";

    $sql_web = "SELECT * FROM infoweb WHERE id = 1";
    $row_web = $koneksi->prepare($sql_web);
    $row_web->execute();
    global $info_web;
    $info_web = $row_web->fetch(PDO::FETCH_OBJ);

    error_reporting(0);		
?>
