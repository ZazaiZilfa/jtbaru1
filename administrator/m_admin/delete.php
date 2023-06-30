<?php

require '../../include/fungsi.php';
require '../../include/fungsi_indotgl.php';

session_start();
date_default_timezone_set('Asia/Jakarta');
$date = new DateTime();


if (isset($_POST['delete_id'])) {
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
