<?php 
$kp = $_GET["km"];
$kodemaint = substr($kp,0,3);
$kodebulan = substr($kp,3,4);
$kodetransaksi = substr($kp,7,3);
$detpro = query("SELECT * FROM maintenance WHERE kodemaint = '$kodemaint' AND kodebulan = '$kodebulan' AND kodetr = '$kodetransaksi' ")[0];

$jumlahi = "SELECT SUM(input) AS total_i FROM pembayaranpmr WHERE kodeproyek ='$kp'"; //perintah untuk menjumlahkan
$hasili = mysqli_query($conn, $jumlahi) ;//melakukan query dengan varibel $jumlahkan
$inp = mysqli_fetch_array($hasili); //menyimpan hasil query ke variabel $t
$totali = $inp['total_i'];

$jumlahp = "SELECT SUM(output) AS total_p FROM pembayaranpmr  WHERE kodeproyek ='$kp'"; //perintah untuk menjumlahkan
$hasilp = mysqli_query($conn, $jumlahp) ;//melakukan query dengan varibel $jumlahkan
$inpp = mysqli_fetch_array($hasilp); //menyimpan hasil query ke variabel $t
$totalp = $inpp['total_p'];

$dp = query("SELECT * FROM pembayaranpmr WHERE kodeproyek = '$kp' ORDER BY tanggal DESC, id DESC");