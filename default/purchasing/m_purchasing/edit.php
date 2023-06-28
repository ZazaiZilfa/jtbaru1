<?php

require '../../include/fungsi.php';
require '../../include/fungsi_indotgl.php';

session_start();
date_default_timezone_set('Asia/Jakarta');
$date = new DateTime();

if (isset($_POST['editformpo'])) {
    $noform = $_POST['noform'];
    $namabarang       = $_POST['namabarang'];
    $kodebahan       = $_POST['kodebarang'];
    $harga         = $_POST['harga'];
    $jumlah     = $_POST['jumlah'];
    $unitbeli     = $_POST['unitbeli'];
    $subtotal    = $_POST['subtotal'];
    $kodesupplier    = $_POST['supplier'];
    $total_keseluruhan    = $_POST['total_keseluruhan'];
    $kodeoutlet = $_SESSION['kodeoutlet'];
    $pembayaran       = $_POST['pembayaran'];
    $metodepembayaran = $_POST['metodepembayaran'];

    $tanggal_manual = $_POST['tanggal_manual'];

    if ($tanggal_manual == null) {
        //tanggal auto
        $dt_input = date('Y-m-d');
        $date = date('ymd');
        //$dt_input = '2021-09-15';
        //$date = '210915';
    } else {
        // tanggal manual
        $tm = explode("/", $tanggal_manual);
        $dt_input = $tm[2] . '-' . $tm[1] . '-' . $tm[0];
        $tm_kata = str_split($tm[2]);
        $date = $tm_kata[2] . $tm_kata[3] . $tm[1] . $tm[0];
    }

    $jatuhtempo = date('Y-m-d', strtotime('+14 days', strtotime($dt_input)));

    // input ke tabel form po
    // $cekItems = query("SELECT * FROM item_po WHERE kodeoutlet = '$kodeoutlet' AND No_form = '$noform'");
    // foreach ($cekItems as $keys => $items) {
    mysqli_query($conn, "DELETE FROM item_po01 WHERE No_form = '$noform' AND kodeoutlet = '$kodeoutlet'");
    // }

    foreach ($namabarang as $key => $nambar) {
        mysqli_query($conn, "insert into item_po01 set
            No_form    = '$noform',
            kodeoutlet = '$kodeoutlet',
            kodebahan  = '$kodebahan[$key]',
            qty = '$jumlah[$key]',
            harga ='$harga[$key]',
            subtotal = '$subtotal[$key]',
            unit ='$unitbeli[$key]'
        ");
    }

    // if ($pembayaran == 'hutang') {
    //     $queryHutang = "INSERT INTO hutang set
    //     No_form    = '',
    //     Form_po    = '$No_form',
    //     kodeoutlet = '$kodeoutlet',
    //     kodesupplier = '$kodesupplier',
    //     date = '$dt_input',
    //     input = '$total_keseluruhan',
    //     output = '0',
    //     status_ot = '1',
    //     status_ck = '2',
    //     jatuhtempo = '$jatuhtempo'";

    //     $isSuccess = mysqli_query($conn, $queryHutang);
    // }


    mysqli_query($conn, "UPDATE form_po01 SET kodesupplier = '$kodesupplier', date = '$dt_input', pembayaran = '$pembayaran', metodepembayaran = '$metodepembayaran', jatuhtempo = '$jatuhtempo', whois_update = '$usernameSession', updated_at = now() + interval 7 hour WHERE No_form = '$noform' AND kodeoutlet = '$kodeoutlet'");

    $result = mysqli_affected_rows($conn);

    //kembali ke halaman sebelumnya
    $_SESSION["msg"] = "$result";
    // header("Location: form-po.php?msg=" . urlencode('1'));

    header("location: ../index.php");
}
