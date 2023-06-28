<?php
session_start();
require '../include/fungsi.php';
date_default_timezone_set('Asia/Jakarta');
$date = new DateTime();

if (isset($_POST['tambah-user'])) {


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
