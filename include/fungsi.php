<?php

//koneksi database
$conn = mysqli_connect('localhost', 'root', '', 'javatechnic_jt');
// $conn = mysqli_connect('javatechnic.co.id','javatechnic_jtcoid','1qjlkTA.Bbf@', 'javatechnic_jt');
// if (!$conn) {
//     die("Koneksi gagal: " . mysqli_connect_error());
// }
// echo "Koneksi berhasil";
// mysqli_close($conn);

function query($query)
{
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$rows[] = $row;
	}
	return $rows;
}

function queryy($queryy)
{
	global $conn;
	$resultt = mysqli_query($conn, $queryy);
	$rowss = [];
	while ($roww = mysqli_fetch_assoc($resultt)) {
		$rowss[] = $roww;
	}
	return $rowss;
}

// function postfoto ($ft) {

// 	// ambil data dari tiap elemen form
// 	global $conn;

// 	global $conn;
// 	$tangg = ($_POST["tang"]);
//     $tang = date('Y-m-d',strtotime($tangg));
//     $jam = ($_POST["jam"]);
//     $judul = htmlspecialchars($pp["judul"]);
//     $kategori = htmlspecialchars($pp["kategori"]);    
//     $kontent = $pp["kontent"];

//     $gambar = upload();
//     if (!$gambar) {
//         return false;
//     }



//query insert data
//      $query = "UPDATE admin SET 

// 	    foto = '$gambar'                
// 	    WHERE id = $id
// 	    ";
//     mysqli_query($conn, $query);

//     return mysqli_affected_rows($conn);

// }

function upload()
{
	$namaFile = $_FILES['gambar']['name'];
	$ukuranFile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];

	// cek apakah tidak ada gambar yang di upload
	if ($error === 4) {
		echo "<script>
				alert('gambar belum di pilih')
			</script>";
		return false;
	}

	//cek ekstensi file gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
		echo "<script>
				alert('yang di upload bukan gambar')
			</script>";
		return false;
	}

	//cek ukuran gambar
	if ($ukuranFile > 2000000) {
		echo "<script> 
				alert('ukuran gambar terlalu besar')
			</script>";
		return false;
	}

	//generate nama gambar
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;

	move_uploaded_file($tmpName, 'images/' . $namaFileBaru);

	return $namaFileBaru;
}

function uploadnota()
{
	$namaFile = $_FILES['gambar']['name'];
	$ukuranFile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];

	// cek apakah tidak ada gambar yang di upload
	if ($error === 4) {
		echo "<script>
				alert('gambar belum di pilih')
				document.location.href = '../accounting/listrikspeedy';
			</script>";
		return false;
	}

	//cek ekstensi file gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
		echo "<script>
				alert('yang di upload bukan gambar')
				document.location.href = '../accounting/listrikspeedy';
			</script>";
		return false;
	}

	//cek ukuran gambar
	if ($ukuranFile > 2000000) {
		echo "<script> 
				alert('ukuran gambar terlalu besar')
				document.location.href = '../accounting/listrikspeedy';
			</script>";
		return false;
	}

	//generate nama gambar
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;

	move_uploaded_file($tmpName, '../images/nota/' . $namaFileBaru);

	return $namaFileBaru;
}


function hapuskaryawan($id)
{
	// ambil data dari tiap elemen form
	global $conn;

	mysqli_query($conn, "DELETE FROM karyawan WHERE id = $id");

	return mysqli_affected_rows($conn);
}

function hapuskas($id)
{
	// ambil data dari tiap elemen form
	global $conn;

	mysqli_query($conn, "DELETE FROM kas WHERE id = $id");

	return mysqli_affected_rows($conn);
}

function hapuskasbesar($id)
{
	// ambil data dari tiap elemen form
	global $conn;

	mysqli_query($conn, "DELETE FROM kasbesar WHERE id = $id");

	return mysqli_affected_rows($conn);
}

function hapusmaintenance($id)
{
	// ambil data dari tiap elemen form
	global $conn;

	mysqli_query($conn, "DELETE FROM maintenance WHERE id = $id");

	return mysqli_affected_rows($conn);
}
function hapusproyekjt($id)
{
	// ambil data dari tiap elemen form
	global $conn;

	mysqli_query($conn, "DELETE FROM proyekjt WHERE id = $id");

	return mysqli_affected_rows($conn);
}

function hapuspengeluarantetap($id)
{
	// ambil data dari tiap elemen form
	global $conn;

	mysqli_query($conn, "DELETE FROM pengeluarantetap WHERE id = $id");

	return mysqli_affected_rows($conn);
}

function hapussuplier($id)
{
	// ambil data dari tiap elemen form
	global $conn;

	mysqli_query($conn, "DELETE FROM supplier WHERE id = $id");

	return mysqli_affected_rows($conn);
}

function hapususer($id)
{
	// ambil data dari tiap elemen form
	global $conn;

	mysqli_query($conn, "DELETE FROM user WHERE id = $id");

	return mysqli_affected_rows($conn);
}

function hapusmenu($id)
{
	// ambil data dari tiap elemen form
	global $conn;

	mysqli_query($conn, "DELETE FROM user_menu WHERE id = $id");

	return mysqli_affected_rows($conn);
}
function hapusunit($id)
{
	// ambil data dari tiap elemen form
	global $conn;
	$nof = query("SELECT * FROM beliunit WHERE id = '$id'  ")[0];
	$nf = $nof['nofaktur'];
	$queryReport = "SELECT * FROM pembelianunit WHERE nofaktur = '$nf' ";
	$sqlReport = mysqli_query($conn, $queryReport);

	while ($dtReport = mysqli_fetch_array($sqlReport)) {
		$idd = $dtReport["id"];
		mysqli_query($conn, "DELETE FROM pembelianunit WHERE id = $idd");
	}

	mysqli_query($conn, "DELETE FROM beliunit WHERE id = $id");

	return mysqli_affected_rows($conn);
}
function hapusmarketing($id)
{
	// ambil data dari tiap elemen form
	global $conn;

	mysqli_query($conn, "DELETE FROM marketing WHERE id = $id");

	return mysqli_affected_rows($conn);
}
function hapusproposal($id)
{
	// ambil data dari tiap elemen form
	global $conn;

	mysqli_query($conn, "DELETE FROM proposal WHERE id = $id");

	return mysqli_affected_rows($conn);
}
function hapusproyek($id)
{
	// ambil data dari tiap elemen form
	global $conn;

	mysqli_query($conn, "DELETE FROM proyek WHERE id = $id");

	return mysqli_affected_rows($conn);
}
function hapuspembayaran($id)
{
	// ambil data dari tiap elemen form
	global $conn;

	mysqli_query($conn, "DELETE FROM pembayaranpmr WHERE id = $id");

	return mysqli_affected_rows($conn);
}
$company = query("SELECT * FROM companypanel01 WHERE baseurl = 'jt' ")[0];
$year = date('Y');
$month = date('m');

$condition = query("SELECT status FROM kondisi01 WHERE 1 ORDER BY id ASC");
$kondisi = $condition[0];
$statusWA = $condition[1]['status'];
$statusSunday = $condition[2]['status'];
$globalPPN = $condition[3]['status'];
$globalHPP = ($globalPPN / 100) + 1;
$statusStokEdit = $condition[5]['status'];
