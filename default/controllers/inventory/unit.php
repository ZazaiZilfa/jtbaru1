<?php 
$beliunit = query("SELECT * FROM beliunit ORDER BY id DESC ");
$pembelianunit = query("SELECT * FROM pembelianunit ORDER BY id DESC ");
$kodesupplierr = query("SELECT * FROM supplier ORDER BY namasupplier ASC ");
$kodeunitt = query("SELECT * FROM unit ORDER BY namaunit ASC ");
$kodeunit = query("SELECT * FROM unit ORDER BY id DESC LIMIT 1")[0];
$kodes = substr($kodeunit['kodeunit'],3);

$kodemerkk = query("SELECT * FROM merk ORDER BY id DESC ");

