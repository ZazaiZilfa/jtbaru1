<?php
require '../include/fungsi.php';

if (isset($_POST['login'])) {
    //var_dump($_POST);
    $email = $_POST['email'];
    $password = $_POST['password'];
    $kodeoutlet = $_POST['kodeoutlet'];

    $ceklogin = mysqli_query($conn, "SELECT * FROM user WHERE email ='$email' ");


    //cek password
    if (mysqli_num_rows($ceklogin) === 1) {

        // $_SESSION['email'] = $email;
        //cek password
        $row = mysqli_fetch_assoc($ceklogin);
        if (password_verify($password, $row["password"])) {

            $datauser = query("SELECT * FROM user WHERE email = '$email' ")[0];
            $userlevel = $datauser['role_id'];
            $useroutlet = $datauser['outlet'];
            // $jabatan = $datauser['jabatan'];

            if ($userlevel != 0) {
                if ($kodeoutlet != $useroutlet) {
                    echo 4;
                } else {
                    session_start();
                    $_SESSION['email'] = $email;
                    $_SESSION['role_id'] = $datauser['role_id'];
                    // $_SESSION['jabatan'] = $datauser['jabatan'];
                    // $dataoutlet = query("SELECT * FROM companypanel WHERE kodeoutlet = '$kodeoutlet' ")[0];
                    // $_SESSION['outlet'] = $dataoutlet['nama'];
                    $_SESSION['kodeoutlet'] = $kodeoutlet;

                    if ($datauser['role_id'] == "2" || $datauser['role_id'] == "3") {
                        echo 6;
                    } else {
                        echo 3;
                    }
                }
            } else {
                session_start();
                $_SESSION['email'] = $email;
                $_SESSION['role_id'] = $datauser['role_id'];
                // $_SESSION['jabatan'] = $datauser['jabatan'];
                // $dataoutlet = query("SELECT * FROM companypanel WHERE kodeoutlet = '$kodeoutlet' ")[0];
                // $_SESSION['outlet'] = $dataoutlet['nama'];
                $_SESSION['kodeoutlet'] = $kodeoutlet;
                // mysqli_query($conn, "UPDATE admin SET last_login = now() + interval 7 hour WHERE email = '$email'");
                echo 3;
            }
        } else {
            echo 2;
        }
    } else {
        echo 1;
    }
}
