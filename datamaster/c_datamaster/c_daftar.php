<?php

session_start();
if (isset($_SESSION["name"])) {
    header("location: dashboard");
    exit;
}

require 'include/fungsi.php';


//cek apakah tombol submit sudah di tekan atau belum
if (isset($_POST["sign"])) {
    $email = htmlspecialchars($_POST["email"]);
    $username = strtolower(stripcslashes($_POST["name"]));
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $userlevel = htmlspecialchars($_POST["role_id"]);
    $date = time();
    // $_POST['date'] = $date;


    //cek  email sudah ada atau belum
    $cekemail = mysqli_query($conn, "SELECT email FROM user WHERE email = '$email'");
    if (mysqli_fetch_assoc($cekemail)) {
        echo "<script>
                alert('email sudah terdaftar');
                document.location.href = 'register';
            </script>";
        return false;
    }

    //cek username sudah ada atau belum
    $cekusername = mysqli_query($conn, "SELECT name FROM user WHERE name = '$username'");
    if (mysqli_fetch_assoc($cekusername)) {
        echo "<script>
                alert('username sudah terdaftar');
                document.location.href = 'register';
            </script>";
        return false;
    }

    //enskripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //query tambah member
    $query = "INSERT INTO user 
                VALUES 
                ('','$username','$email','default.jpg','$password','$userlevel','1','$date')
            ";
    mysqli_query($conn, $query);



    //cek apakh data berhasil di tambahkan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>                
                document.location.href = 'index';           
            </script>
            ";
    } else {
        echo "
            <script>                
                document.location.href = 'register';                
            </script>
            ";
    }
}
