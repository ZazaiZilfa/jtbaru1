<?php 
//fungsi input proposal
function inputproposal(){

	global $conn;
	$tl = htmlspecialchars($_POST["tanggal"]);
    $ttl = $tl;
    $tatl = substr($ttl,3,2);
    $bul = substr($ttl,0,2);
    $tahtl = substr($ttl,6,4);
    $tang = $tahtl.'-'.$bul.'-'.$tatl;
    $tanggalpro = date('Y-m-d',strtotime($tang));
    $tanggalpjt = date('Y-m-d',strtotime($tang));

    date_default_timezone_set('Asia/Jakarta'); $date = new DateTime();
    $butl = substr($date->format('Y-m-d'),5,2);
    $thl = substr($date->format('Y-m-d'),2,2);
    $kodeproyek = "PRO";
    $t = substr($ttl,8,2);
    $kodebulan = $thl.$butl;

    $kas = "SELECT * FROM proyekjt WHERE kodeproyek ='PRO' AND month(tanggalpro) ='$bul' ORDER BY id DESC LIMIT 1";
    $hasilq = mysqli_query($conn, $kas) ;//melakukan query dengan varibel $jumlahkan
    $ktr = mysqli_fetch_array($hasilq); //menyimpan hasil query ke variabel $t
    //$totalp = $ktr['total_p'];
    if ($ktr['kodebulan']!=$thl.$butl) {
        $newkodetr = "001";

    }else{
        $lastkode = "SELECT * FROM proyekjt WHERE kodeproyek ='PRO' AND month(tanggalpro) ='$bul' ORDER BY id DESC LIMIT 1";
        $hasilq = mysqli_query($conn, $lastkode) ;//melakukan query dengan varibel $jumlahkan
        $ktr = mysqli_fetch_array($hasilq); //menyimpan hasil query ke variabel $t
        $lk =$ktr['kodetr'] ;
        $noUrut = (int) $ktr['kodetr'];
        $noUrut++;    
        $newkodetr = sprintf("%03s", $noUrut);
    }
   

    //$novoucher = htmlspecialchars($_POST["nv"]);
    $namaklien = htmlspecialchars($_POST["namaklien"]);
    $outlet = htmlspecialchars($_POST["outlet"]);
    $tempat = htmlspecialchars($_POST["tempat"]);
    $pekerjaan = htmlspecialchars($_POST["pekerjaan"]);
    $nilaiproyek = htmlspecialchars($_POST["nilaiproyek"]);
    $saldo = 0;


    //query insert data
    $query = "INSERT INTO proyekjt 
                VALUES 
                ('','$tanggalpro','$tanggalpjt','$kodeproyek','$kodebulan','$newkodetr','$namaklien','$outlet','$tempat','$pekerjaan','$nilaiproyek','$saldo')
            ";
    mysqli_query($conn, $query);
    
    
    
}


?>
