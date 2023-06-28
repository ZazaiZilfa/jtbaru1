<?php 
$kp = $_GET["kp"];
$detpro = query("SELECT * FROM proyekjt WHERE noproyek = '$kp' ")[0];

$jumlahi = "SELECT SUM(input) AS total_i FROM pembayaranpmr WHERE kodeproyek ='$kp'"; //perintah untuk menjumlahkan
$hasili = mysqli_query($conn, $jumlahi) ;//melakukan query dengan varibel $jumlahkan
$inp = mysqli_fetch_array($hasili); //menyimpan hasil query ke variabel $t
$totali = $inp['total_i'];

$jumlahp = "SELECT SUM(output) AS total_p FROM pembayaranpmr  WHERE kodeproyek ='$kp'"; //perintah untuk menjumlahkan
$hasilp = mysqli_query($conn, $jumlahp) ;//melakukan query dengan varibel $jumlahkan
$inpp = mysqli_fetch_array($hasilp); //menyimpan hasil query ke variabel $t
$totalp = $inpp['total_p'];

$dp = query("SELECT * FROM kasbesar WHERE kodeproyek = '$kp' ORDER BY tanggal DESC, id DESC");