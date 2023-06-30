<?php
$kodeoutlet = $_SESSION['kodeoutlet'];
// $kodeoutlet = $_SESSION['role_id'];
if (isset($_POST['filter-date'])) {
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
    $check = query("SELECT COUNT(status_ck AND status_ot) AS informasi FROM form_po01 WHERE status_ck = 0 AND status_ot = 0 and kodeoutlet = '$kodeoutlet' and date 
    LIKE '$tahun-$bulan%'")[0];
    $c_admin = query("SELECT COUNT(status_ck AND status_ot) AS informasi FROM form_po01 WHERE status_ck = 0 AND status_ot = 1 and kodeoutlet = '$kodeoutlet' and date 
    LIKE '$tahun-$bulan%'")[0];
    $c_manager = query("SELECT COUNT(status_ck AND status_ot) AS informasi FROM form_po01 WHERE status_ck = 1 AND status_ot = 1 and kodeoutlet = '$kodeoutlet' and date 
    LIKE '$tahun-$bulan%'")[0];
    $delivery = query("SELECT COUNT(status_ck AND status_ot) AS informasi FROM form_po01 WHERE status_ck = 2 AND status_ot = 1 and kodeoutlet = '$kodeoutlet' and date 
    LIKE '$tahun-$bulan%'")[0];
    $delivered = query("SELECT COUNT(status_ck AND status_ot) AS informasi FROM form_po01 WHERE status_ck = 2 AND status_ot = 2 and kodeoutlet = '$kodeoutlet' and date 
    LIKE '$tahun-$bulan%'")[0];
} else if (isset($_POST['filter-specific-date'])) {
    $tgl = $_POST['specific-date'];
    $newTgl = explode("/", $tgl);
    $tanggal = $newTgl[2] . '-' . $newTgl[0] . '-' . $newTgl[1];

    $check = query("SELECT COUNT(status_ck AND status_ot) AS informasi FROM form_po01 WHERE status_ck = 0 AND status_ot = 0 and kodeoutlet = '$kodeoutlet' and date 
    LIKE '$tanggal%'")[0];
    $c_admin = query("SELECT COUNT(status_ck AND status_ot) AS informasi FROM form_po01 WHERE status_ck = 0 AND status_ot = 1 and kodeoutlet = '$kodeoutlet' and date 
    LIKE '$tanggal%'")[0];
    $c_manager = query("SELECT COUNT(status_ck AND status_ot) AS informasi FROM form_po01 WHERE status_ck = 1 AND status_ot = 1 and kodeoutlet = '$kodeoutlet' and date 
    LIKE '$tanggal%'")[0];
    $delivery = query("SELECT COUNT(status_ck AND status_ot) AS informasi FROM form_po01 WHERE status_ck = 2 AND status_ot = 1 and kodeoutlet = '$kodeoutlet' and date 
    LIKE '$tanggal%'")[0];
    $delivered = query("SELECT COUNT(status_ck AND status_ot) AS informasi FROM form_po01 WHERE status_ck = 2 AND status_ot = 2 and kodeoutlet = '$kodeoutlet' and date 
    LIKE '$tanggal%'")[0];
} else {
    $check = query("SELECT COUNT(status_ck AND status_ot) AS informasi FROM form_po01 WHERE status_ck = 0 AND status_ot = 0 and kodeoutlet = '$kodeoutlet' and date 
    LIKE '$year-$month%'")[0];
    $c_admin = query("SELECT COUNT(status_ck AND status_ot) AS informasi FROM form_po01 WHERE status_ck = 0 AND status_ot = 1 and kodeoutlet = '$kodeoutlet' and date 
    LIKE '$year-$month%'")[0];
    $c_manager = query("SELECT COUNT(status_ck AND status_ot) AS informasi FROM form_po01 WHERE status_ck = 1 AND status_ot = 1 and kodeoutlet = '$kodeoutlet' and date 
    LIKE '$year-$month%'")[0];
    $delivery = query("SELECT COUNT(status_ck AND status_ot) AS informasi FROM form_po01 WHERE status_ck = 2 AND status_ot = 1 and kodeoutlet = '$kodeoutlet' and date 
    LIKE '$year-$month%'")[0];
    $delivered = query("SELECT COUNT(status_ck AND status_ot) AS informasi FROM form_po01 WHERE status_ck = 2 AND status_ot = 2 and kodeoutlet = '$kodeoutlet' and date 
    LIKE '$year-$month%'")[0];
}
