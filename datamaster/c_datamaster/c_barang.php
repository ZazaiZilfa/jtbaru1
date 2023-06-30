<?php

$kodeoutlet = $_SESSION['kodeoutlet'];
$databarang = query("SELECT * FROM barang01 WHERE kodeoutlet='$kodeoutlet' ORDER BY kategoribarang ASC, subkatbarang ASC, namabarang ASC");
$barang = query("SELECT * FROM barang01 WHERE kodeoutlet='$kodeoutlet' ORDER BY id DESC");
$supplier = query("SELECT * FROM supplier01 WHERE kodeoutlet='$kodeoutlet' ORDER BY id DESC");

// var_dump($outstok);die;
$kategoribarang = query("SELECT * FROM kategoribarang02 ORDER BY id ASC");
$subkatbarang = query("SELECT * FROM subkatbarang01 ORDER BY id ASC");
$unit = query("SELECT * FROM unit01 ORDER BY namaunit ASC");
