<?php
require '../../include/fungsi.php';
require '../../include/fungsi_indotgl.php';

session_start();
date_default_timezone_set('Asia/Jakarta');
$date = new DateTime();

if (isset($_POST['deleteformin'])) {
    $kodeoutlet = $_POST['kodeoutlet'];
    $no_form = $_POST['deleteformin'];

    $no_formpo = query("SELECT Form_po FROM form_in01 WHERE No_form = '$no_form' AND kodeoutlet = '$kodeoutlet'")[0]['Form_po'];
    $isSuccess = mysqli_query($conn, "DELETE FROM form_in01 WHERE No_form = '$no_form' AND kodeoutlet = '$kodeoutlet'");

    if ($isSuccess) {
        $items = query("SELECT * FROM item_in01 WHERE No_form = '$no_form' AND kodeoutlet = '$kodeoutlet'");

        foreach ($items as $key => $item) {
            $kodebarang = $item['kodebahan'];
            $quantity = $item['qty'];
            $itemId = $item['id'];

            $cekstok = query("SELECT stok FROM barang01 WHERE kodebarang = '$kodebarang' AND kodeoutlet = '$kodeoutlet'")[0]['stok'];
            $cekHarga = query("SELECT hargafix FROM item_in01 WHERE kodebahan = '$kodebarang' AND kodeoutlet = '$kodeoutlet' AND id NOT IN ($itemId) ORDER BY hargafix DESC LIMIT 1");
            $newstok = $cekstok - $quantity;

            if ($cekHarga == NULL) {
                mysqli_query($conn, "UPDATE barang01 SET stok = '$newstok' WHERE kodebarang = '$kodebarang'");
            } else {
                $newHarga = $cekHarga[0]['hargafix'];
                mysqli_query($conn, "UPDATE barang01 SET stok = '$newstok', hargabeli = '$newHarga' WHERE kodebarang = '$kodebarang'");
            }
        }

        mysqli_query($conn, "DELETE FROM item_in01 WHERE No_form = '$no_form' AND kodeoutlet = '$kodeoutlet'");
        mysqli_query($conn, "UPDATE form_po01 SET status_ot='1' WHERE No_form='$no_formpo' AND kodeoutlet = '$kodeoutlet'");
        echo 3;
    } else {
        echo 1;
    }
}
