<?php 



if( isset($_POST["tp"]) ) {
    $tampilkanbulan = $_POST["bulan"];
    $tahun = $_POST["tahun"];

    if ($tampilkanbulan==="Bulan") {
        header("location:kaskecil");
    }

    $pembayaran = query("SELECT * FROM kasbesar WHERE kodekas ='KBMP' AND month(tanggal) = '$tampilkanbulan' AND year(tanggal) ='$tahun' ORDER BY tanggal DESC, id DESC");
    $kaskecil = query("SELECT * FROM kas WHERE month(tanggal) ='$tampilkanbulan' AND year(tanggal) ='$tahun' ORDER BY id DESC");
    $kas = query("SELECT * FROM kas WHERE month(tanggal) ='$tampilkanbulan' AND year(tanggal) ='$tahun' ORDER BY id DESC LIMIT 1")[0];
    $saldokas = $kas["saldo"];

    date_default_timezone_set('Asia/Jakarta'); $date = new DateTime();
    $butl = substr($date->format('Y-m-d'),5,2);
    $thl = substr($date->format('Y-m-d'),2,2);

    $jumlahi = "SELECT SUM(input) AS total_i FROM kas WHERE month(tanggal) ='$tampilkanbulan' AND year(tanggal) ='$tahun'"; //perintah untuk menjumlahkan
    $hasili = mysqli_query($conn, $jumlahi) ;//melakukan query dengan varibel $jumlahkan
    $inp = mysqli_fetch_array($hasili); //menyimpan hasil query ke variabel $t
    $totali = $inp['total_i'];

    $jumlaho = "SELECT SUM(output) AS total_o FROM kas WHERE month(tanggal) ='$tampilkanbulan' AND year(tanggal) ='$tahun'"; //perintah untuk menjumlahkan
    $hasilo = mysqli_query($conn, $jumlaho) ;//melakukan query dengan varibel $jumlahkan
    $out = mysqli_fetch_array($hasilo); //menyimpan hasil query ke variabel $t
    $totalo = $out['total_o'];

    if ($tampilkanbulan!=$butl) {
        $jumlahsaldo = $totali-$totalo;
    }else{
        $tk = (int)$tampilkanbulan-1;
        $kas = query("SELECT * FROM kas WHERE month(tanggal) ='$tk' ORDER BY id DESC LIMIT 1")[0];
        $saldokas = $kas["saldo"];
        $jumlahsaldo = $saldokas+($totali-$totalo);
    }
    
}else{
    $pembayaran = query("SELECT * FROM kasbesar WHERE kodekas ='KBMM' ORDER BY tanggal DESC, id DESC");
    $kaskecil = query("SELECT * FROM kas WHERE month(tanggal)='04' AND year(tanggal) ='2019' ORDER BY id DESC");
    $kas = query("SELECT * FROM kas ORDER BY id DESC LIMIT 1")[0];
    $saldokas = $kas["saldo"];

    

    $jumlahi = "SELECT SUM(input) AS total_i FROM kas WHERE month(tanggal) ='$butl' AND year(tanggal) ='$year'"; //perintah untuk menjumlahkan
    $hasili = mysqli_query($conn, $jumlahi) ;//melakukan query dengan varibel $jumlahkan
    $inp = mysqli_fetch_array($hasili); //menyimpan hasil query ke variabel $t
    $totali = $saldokass+$inp['total_i'];

    $jumlaho = "SELECT SUM(output) AS total_o FROM kas WHERE month(tanggal) ='$butl' AND year(tanggal) ='$year'"; //perintah untuk menjumlahkan
    $hasilo = mysqli_query($conn, $jumlaho) ;//melakukan query dengan varibel $jumlahkan
    $out = mysqli_fetch_array($hasilo); //menyimpan hasil query ke variabel $t
    $totalo = $out['total_o'];

       
        

    $jumlahsaldo = $totali-$totalo;
}