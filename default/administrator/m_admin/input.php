<?php

session_start();
require '../../include/fungsi.php';
date_default_timezone_set('Asia/Jakarta');
$date = new DateTime();

if (isset($_POST['inputmenu'])) {

    $menu = $_POST['nmenu'];
    $url = $_POST['nurl'];

    $cekdata = mysqli_query($conn, "SELECT * FROM user_menu WHERE menu = '$menu'");


    if (mysqli_num_rows($cekdata) > 0) {
        echo 1;
    } else {
        $cekurl = mysqli_query($conn, "SELECT * FROM user_menu WHERE url = '$url'");
        if (mysqli_num_rows($cekurl) > 0) {
            echo 2;
        } else {
            $query = "INSERT INTO user_menu SET 
                   menu ='$menu',
                   url  = '$url'
                 ";
            $masuk_data = mysqli_query($conn, $query);
            if ($masuk_data) {
                echo 4;
            } else {

                echo 3;
            }
        }
    }
}
