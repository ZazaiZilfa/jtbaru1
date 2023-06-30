<?php
session_start();
require '../../include/fungsi.php';
$keyword = $_POST["keyword_form-po"];
$kodeoutlet = $_SESSION['kodeoutlet'];


if (isset($keyword)) {

    $bahan = query("SELECT * FROM barang01 as b
    JOIN unit01 as u
    ON b.unitbeli = u.kodeunit
    -- WHERE kodeoutlet = '$kodeoutlet' AND (namabahan LIKE '%" . $keyword . "%' OR kodebahan like '%" . $keyword . "%')
    -- WHERE b.kodeoutlet = '$kodeoutlet' AND (b.namabarang LIKE '%" . $keyword . "%' AND b.kategoribarang != 'KAB001' )
    WHERE b.kodeoutlet = '$kodeoutlet' AND (b.namabarang LIKE '%" . $keyword . "%')
    ORDER BY b.id DESC ");
    echo json_encode($bahan);
}
