<?php
session_start();

// //cek cookie
// if (isset($_COOKIE['email'])) {
//  if ($_COOKIE['email'] == 'true') {
//      $_SESSION['email'] = true;
//  }
// }
require 'include/fungsi.php';
if (isset($_SESSION["email"])) {
    $user = query("SELECT * FROM user WHERE email ='$email' ")[0];
    if ($user['role_id'] === "1" || $user['role_id'] === "0") {
        echo $company['kodeoutlet'];
        header("location: dashboard");
    } elseif ($user['role_id'] === "2") {
        header("location: office/proyek");
        echo $company['kodeoutlet'];
    } else {
        header("location: office/proyek");
        echo $company['kodeoutlet'];
    }
    exit;
}



//cek apakah tombol submit sudah di tekan atau belum
if (isset($_POST["masuk"])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = query("SELECT * FROM user WHERE email ='$email' ")[0];
    $ceklogin = mysqli_query($conn, "SELECT * FROM user WHERE email ='$email' ");


    //cek password
    if (mysqli_num_rows($ceklogin) === 1) {

        // $_SESSION['email'] = $email;
        //cek password
        $row = mysqli_fetch_assoc($ceklogin);
        if (password_verify($password, $row["password"])) {
            $_SESSION['email'] = $email;

            // //cek remember me
            // if (isset($_POST['remember']) ) {
            //  //buat cookie
            //  setcookie('email','true', time()+360);

            // }
            if ($user['role_id'] == 1) {
                header("location: dashboard");
                echo $company['kodeoutlet'];
            } elseif ($user['role_id'] == 2) {
                header("location: office/proyek");
                echo $company['kodeoutlet'];
            } else {
                header("location: office/proyek");
                echo $company['kodeoutlet'];
            }
            exit;
        }
    }
    $error = true;
}
