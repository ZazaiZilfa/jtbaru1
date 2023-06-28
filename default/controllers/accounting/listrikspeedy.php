<?php
$dls = query("SELECT * FROM listrikspeedy ORDER BY id DESC LIMIT 1")[0]; 
$dlst = substr($dls['tanggal'],5,2);

$tanggal = date ('Y-m-d');
if ($dlst!=$month) {
	$dlsinput = query("SELECT * FROM lsd WHERE status = '1' ");

	foreach ($dlsinput as $row) {
		$tanggal = date ('Y-m-d');
		$kategori = $row['kategori_id'];
		$nomer = $row['nomer'];
		$status = 0;

		//query tambah member
    $query = "INSERT INTO listrikspeedy 
                VALUES 
                ('','$tanggal','$kategori','$nomer','','','','$status')
            ";
    mysqli_query($conn, $query);
	}
}

if( isset($_POST["tp"]) ) {
	$tampilkanbulan = $_POST["bulan"];
    $tahun = $_POST["tahun"];
    
	$ls = query("SELECT * FROM listrikspeedy WHERE month(tanggal) = '$tampilkanbulan'  AND year(tanggal) ='$tahun' ORDER BY id DESC");

	$jumlahi = "SELECT SUM(jumlah) AS total_i FROM listrikspeedy WHERE month(tanggal) = '$tampilkanbulan' AND year(tanggal) ='$tahun' "; //perintah untuk menjumlahkan
	$hasili = mysqli_query($conn, $jumlahi) ;//melakukan query dengan varibel $jumlahkan
	$inp = mysqli_fetch_array($hasili); //menyimpan hasil query ke variabel $t
	$totali = $inp['total_i'];
}else{
	$ls = query("SELECT * FROM listrikspeedy WHERE month(tanggal) = '$month' AND year(tanggal) ='$year' ORDER BY id DESC");

	$jumlahi = "SELECT SUM(jumlah) AS total_i FROM listrikspeedy WHERE month(tanggal) = '$month' AND year(tanggal) ='$year' "; //perintah untuk menjumlahkan
	$hasili = mysqli_query($conn, $jumlahi) ;//melakukan query dengan varibel $jumlahkan
	$inp = mysqli_fetch_array($hasili); //menyimpan hasil query ke variabel $t
	$totali = $inp['total_i'];
}