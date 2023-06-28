<?php 

$kodeakune = query("SELECT * FROM kodeakun WHERE kodeakun2='52' AND kodeakun3!='526' ORDER BY id ASC");
$kodeakunp = query("SELECT * FROM kodeakun WHERE kodeakun3='433' ORDER BY id ASC");

if( isset($_POST["tp"]) ) {
    $tampilkanbulan = $_POST["bulan"];
    $tahun = $_POST["tahun"];

    if ($tampilkanbulan==="Bulan") {
        header("location:kaskecil");
    }

    $kary = query("SELECT * FROM karyawan ORDER BY id ASC");
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
    $kary = query("SELECT * FROM karyawan ORDER BY id ASC");
    $kaskecil = query("SELECT * FROM kas WHERE month(tanggal)='$month' AND year(tanggal) ='$year' ORDER BY id DESC");
    $kas = query("SELECT * FROM kas ORDER BY id DESC LIMIT 1")[0];
    $saldokas = $kas["saldo"];

    date_default_timezone_set('Asia/Jakarta'); $date = new DateTime();
    $butl = substr($date->format('Y-m-d'),5,2);
    $thl = substr($date->format('Y-m-d'),2,2);

    if ($butl==='01') {
        $tkk = '12';
    }elseif($butl==='02'){
        $tkk = '01';
    }elseif($butl==='03'){
        $tkk = '02';
    }elseif($butl==='04'){
        $tkk = '03';
    }elseif($butl==='05'){
        $tkk = '04';
    }elseif($butl==='06'){
        $tkk = '05';
    }elseif($butl==='07'){
        $tkk = '06';
    }elseif($butl==='08'){
        $tkk = '07';
    }elseif($butl==='09'){
        $tkk = '08';
    }elseif($butl==='10'){
        $tkk = '09';
    }elseif($butl==='11'){
        $tkk = '10';
    }elseif($butl==='12'){
        $tkk = '11';
    }

     //$tkk = (int)$butl-1;
        $kass = query("SELECT * FROM kas WHERE month(tanggal) ='$tkk' ORDER BY id DESC LIMIT 1")[0];
        $saldokass = $kass["saldo"];

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