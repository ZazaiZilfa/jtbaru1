<?php
$kodeoutlet = $_SESSION['kodeoutlet'];
// $kodeoutlet = $_SESSION['role_id'];
$bank = query("SELECT * FROM namabank ORDER BY namabank ASC");
if ($kodeoutlet != "OUT000") {
    $kodesupplierr = query("SELECT s.id, kodeoutlet, kodesupplier, namasupplier, nohp, alamatsupplier, s.kodebank, norek, namabank, ppn FROM supplier01 as s JOIN namabank as nb ON s.kodebank = nb.kodebank WHERE s.kodeoutlet = '$kodeoutlet' ORDER BY s.id DESC ");
} else {
    $kodesupplierr = query("SELECT s.id, kodeoutlet, kodesupplier, namasupplier, nohp, alamatsupplier, s.kodebank, norek, namabank, ppn FROM supplier01 as s JOIN namabank as nb ON s.kodebank = nb.kodebank ORDER BY s.id DESC ");
}
