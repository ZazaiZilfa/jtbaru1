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
 //    if ($ur!=1) {
	//     header("location:../forbidden"); // cek role id, maka diarahkan ke forbidden
	//     exit; 
	// }
}

$month = date ('m');
$year = date ('Y');
?>