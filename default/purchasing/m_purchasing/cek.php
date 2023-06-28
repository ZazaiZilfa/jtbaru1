<?php
// $namaoutlet = $_SESSION['outlet'];
//  $kodeoutlet = query("SELECT kodeoutlet FROM companypanel WHERE nama = '$namaoutlet'")[0]['kodeoutlet'];
$kodeoutlet2 = $_SESSION['kodeoutlet'];
// var_dump($kodeoutlet2);
// die;
if (isset($_POST['status'])) {
    $No_form = $_POST['No_form'];
    if (isset($_POST['sot'])) {
        $sot = $_POST['sot'] + 1;
        mysqli_query($conn, "UPDATE $tabel
        SET status_ot='$sot'
        WHERE kodeoutlet = '$kodeoutlet2' AND No_form = '$No_form'");
    } elseif (isset($_POST['sck'])) {
        $sck = $_POST['sck'] + 1;
        mysqli_query($conn, "UPDATE $tabel
        SET status_ck='$sck' 
        WHERE kodeoutlet = '$kodeoutlet2' and No_form = '$No_form'");
    }
}
if (isset($_POST['status2'])) {
    $No_form = $_POST['No_form'];

    $status = $_POST['status'] + 1;
    mysqli_query($conn, "UPDATE $tabel
        SET status='$status'
        WHERE kodeoutlet = '$kodeoutlet2' and  No_form = '$No_form'");
}
if (isset($_POST['update-storebarang'])) {
    $No_form = $_POST['No_form'];

    $barang = query("SELECT * FROM item_po01 WHERE  kodeoutlet = '$kodeoutlet2' and No_form = '$No_form'");
    $dt_input =  $tglindo;
    $date = $tglindo2;


    $ambil_noform = query("SELECT id,No_form,kodeoutlet FROM form_out where kodeoutlet = '$kodeoutlet2' and No_form like 'FOU$date%' ORDER BY No_form DESC");
    $pecah_po = substr($ambil_noform["0"]['No_form'], 0, 9);
    $pecah_po_b = substr($ambil_noform["0"]['No_form'], 9);


    if ($pecah_po == "FOU$date") {
        $pecah_po_b += 1;
        $pecah_po_b = sprintf("%03d", $pecah_po_b);
        $No_formfou = 'FOU' . $date . $pecah_po_b;
    } else {
        $No_formfou = 'FOU' . $date . '001';
    }



    foreach ($barang as $row) {

        $kode =  $row['kodebahan'];
        $jml = $row['qty'];
        $harga = $row['harga'];
        $unit = $row['unit'];
        $subtotal = $row['subtotal'];


        // $cstok= query("SELECT stok 
        //     FROM barang 
        //     WHERE kodebarang = '$kode'")[0][stok];

        // $tot = $cstok - $jml;

        // mysqli_query($conn, "UPDATE barang SET 
        //     stok= '$tot' 
        //     WHERE kodebarang='$kode'");


        // var_dump($form_po);  

        mysqli_query($conn, "insert into item_out set
        No_form    = '$No_formfou',
        kodebahan      = '$kode',
        kodeoutlet      = '$kodeoutlet2',
        qty = '$jml',
        harga ='$harga',
        unit ='$unit',
        subtotal = '$subtotal'");
    }

    // $form_po = query("SELECT * FROM form_po WHERE kodeoutlet = '$kodeoutlet' and No_form = '$No_form'")[0];
    // $kodeoutlet = $form_po['kodeoutlet'];

    mysqli_query($conn, "insert into form_out set
    No_form    = '$No_formfou',
    Form_po = '$No_form',
    kodeoutlet      = '$kodeoutlet2',
    kodesupplier = 'SUP000',
    date ='$dt_input',
    status_ck = '0',
    status_ot = '0'
");


    // die;

}
