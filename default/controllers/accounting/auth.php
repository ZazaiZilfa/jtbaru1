<?php 
session_start();
$s = $_SESSION['email'];
// //cek cookie
// if (isset($_COOKIE['email'])) {
//     if ($_COOKIE['email'] == 'true') {
//         $_SESSION['email'] = true;
//     }
// }
    $u = query("SELECT * FROM user WHERE email = '$s'")[0];
    $ur = $u["role_id"];
    $username = $u["name"];
    $urole = query("SELECT * FROM user_role WHERE id = '$ur'")[0];
    $userlevel = $urole["role"];

if (!isset($_SESSION['email'])) {
    header("location:../index"); // jika belum login, maka dikembalikan ke index
    exit; 
}elseif ($ur>2) {
    header("location:../forbidden"); // cek role id, maka diarahkan ke forbidden
    exit; 
}

$month = date ('m');
$year = date ('Y');

if ($month=="01") {
	$monthname = "Januari";
}elseif($month=="02") {
	$monthname = "Febuari";
}elseif($month=="03") {
	$monthname = "Maret";
}elseif($month=="04") {
	$monthname = "April";
}elseif($month=="05") {
	$monthname = "Mei";
}elseif($month=="06") {
	$monthname = "Juni";
}elseif($month=="07") {
	$monthname = "Juli";
}elseif($month=="08") {
	$monthname = "Agustur";
}elseif($month=="09") {
	$monthname = "September";
}elseif($month=="10") {
	$monthname = "Oktober";
}elseif($month=="11") {
	$monthname = "November";
}elseif($month=="12") {
	$monthname = "Desember";
}
?>