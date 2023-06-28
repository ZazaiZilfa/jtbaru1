<?php
require '../../include/fungsi.php';
require '../../include/fungsi_indotgl.php';

session_start();
date_default_timezone_set('Asia/Jakarta');
$date = new DateTime();

if (isset($_POST['deleteformpo'])) {
    $kodeoutlet = $_POST['kodeoutlet'];
    $no_form = $_POST['deleteformpo'];
    $isSuccess = mysqli_query($conn, "DELETE FROM form_po01 WHERE No_form = '$no_form' AND kodeoutlet = '$kodeoutlet'");
    $isSuccess = mysqli_query($conn, "DELETE FROM item_po01 WHERE No_form = '$no_form' AND kodeoutlet = '$kodeoutlet'");

    echo ($isSuccess) ? 3 : 1;
} else if (isset($_POST['delete_id'])) {
    // if (isset($_POST['deletebank'])) {
    $tabel = $_POST['tabel'];
    $id = $_POST['delete_id'];
    $hapus_data = mysqli_query($conn, "DELETE FROM $tabel WHERE id = $id");
    if ($hapus_data) {
        echo 3;
    } else {
        echo 2;
    }
}
