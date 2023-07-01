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
} else if (isset($_POST['inputsubmenu'])) {

    $mparent = $_POST['mparent'];
    $menu = $_POST['nmenu'];
    $url = $_POST['nurl'];


    $cekdata = mysqli_query($conn, "SELECT * FROM user_sub_menu WHERE title = '$menu'");

    if (mysqli_num_rows($cekdata) > 0) {
        echo 1;
    } else {
        $cekurl = mysqli_query($conn, "SELECT * FROM user_sub_menu WHERE url = '$url'");
        if (mysqli_num_rows($cekurl) > 0) {
            echo 2;
        } else {
            $query = "INSERT INTO user_sub_menu 
                        VALUES 
                        ('','$mparent','$menu','$url','','','')
                     ";
            $masuk_data = mysqli_query($conn, $query);
            if ($masuk_data) {
                echo 4;
            } else {
                echo 3;
            }
        }
    }
} else if (isset($_POST['tambah-user'])) {


    $name = $_POST['name'];
    $email = $_POST['email'];
    $outlet = $_POST['outlet'];
    $role_id = $_POST['role_id'];
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_DEFAULT);
    $tanggal = date('now');

    $cekemail = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
    $ceknama = mysqli_query($conn, "SELECT * FROM user WHERE name = '$name'");

    if (mysqli_fetch_assoc($cekemail)) {
        echo 1;
        return false;
    }
    if (mysqli_fetch_assoc($ceknama)) {
        echo 4;
        return false;
    }
    $query = "INSERT INTO user SET 
                   name ='$name',
                   email  = '$email',
                   image = 'default.jpg',
                   password = '$password',
                   outlet = '$outlet',
                   role_id = '$role_id',
                   is_active = '1',
                   date_created = '$tanggal'
                 ";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo 3;
    } else {
        echo 2;
    }
}
