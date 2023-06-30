<?php
require '../../include/fungsi.php';
require '../../include/fungsi_indotgl.php';

session_start();
date_default_timezone_set('Asia/Jakarta');
$date = new DateTime();

if (isset($_POST["update-supplier"])) {

    $namasupplier = $_POST['unama'];
    $id = $_POST['update-supplier'];


    // $id = $_POST['updatemenu'];
    // $menu = $_POST['unama'];
    // $url = $_POST['uurl'];

    $query = "UPDATE supplier01 SET
                 namasupplier = '$namasupplier',
                 nohp = '$nohpsupplier',
                 alamatsupplier = '$alamatsupplier',
                 kodebank ='$bank',
                 norek ='$norek',
                 ppn ='$ppn'
         WHERE kodesupplier = '$id'
  ";

    $masuk_data = mysqli_query($conn, $query);
    if ($masuk_data) {
        echo 3;
        // echo $bank;
        // echo $norek;
    } else {
        echo 1;
    }
} else if (isset($_POST['update-unit'])) {

    $nama = $_POST['unama'];
    $id = $_POST['update-unit'];

    $query = "UPDATE unit01 SET namaunit = '$nama' WHERE kodeunit ='$id'";
    $masuk_data = mysqli_query($conn, $query);
    if ($masuk_data) {
        echo 3;
    } else {
        echo 1;
    }
} else if (isset($_POST['update-kategoribarang'])) {

    $nama = $_POST['unama'];
    $id = $_POST['update-kategoribarang'];

    $query = "UPDATE kategoribarang02 SET namakategoribarang = '$nama' WHERE kodekategoribarang ='$id'";
    $masuk_data = mysqli_query($conn, $query);
    if ($masuk_data) {
        echo 3;
    } else {
        echo 1;
    }
} else if (isset($_POST['update-skbarang'])) {

    $nama = $_POST['unama'];
    $id = $_POST['update-skbarang'];

    $query = "UPDATE subkatbarang01 SET namasubkatbarang = '$nama' WHERE kodesubkatbarang ='$id'";
    $masuk_data = mysqli_query($conn, $query);
    if ($masuk_data) {
        echo 3;
    } else {
        echo 1;
    }
} else if (isset($_POST["updatebarang"])) {

    $ukategoribarang = $_POST['ukategoribarang'];
    // $usubkategoribarang = $_POST['usubkategoribarang'];
    $unamabarang = $_POST['unamabarang'];
    $uhargabeli = $_POST['uhargabeli'];
    $uunitbeli = $_POST['uunitbeli'];
    $ustok = $_POST['ustok'];
    $uhargajual1 = $_POST['uhargajual1'];
    $uhargajual2 = $_POST['uhargajual2'];
    // $uunitjual = $_POST['uunitjual'];
    $uminstok = $_POST['uminstok'];
    $kode = $_POST['kodebarang'];
    // $ukodeitem = $_POST['kodeitem2'];
    // $ukodebarcode = $_POST['kodebarcode2'];
    $umerk = $_POST['merk2'];
    $urak = $_POST['rak2'];
    $udept = $_POST['dept2'];
    $usupplier = $_POST['supplier2'];
    $uketerangan = $_POST['keterangan2'];

    // -- subkatbarang = '$usubkategoribarang',
    // -- unitjual = '$uunitjual',
    // -- kodeitem = '$ukodeitem',
    // -- kodebarcode = '$ukodebarcode',

    $query = "UPDATE barang01 SET
    kategoribarang = '$ukategoribarang',
    namabarang = '$unamabarang',
    hargabeli = '$uhargabeli',
    unitbeli = '$uunitbeli',
    stok = '$ustok',
    hargajual1 = '$uhargajual1',
    hargajual2 = '$uhargajual2',
    merk = '$umerk',
    rak = '$urak',
    dept = '$udept',
    supplier = '$usupplier',
    keterangan = '$uketerangan',
    minstok = '$uminstok'
             WHERE kodebarang = '$kode'
      ";

    $masuk_data = mysqli_query($conn, $query);
    if ($masuk_data) {
        echo 3;
        // echo $bank;
        // echo $norek;
    } else {
        echo 1;
    }
} else if (isset($_POST["update-customer"])) {

    $level = $_POST['ulevel'];
    $namacustomer = $_POST['unama'];
    $nohpcustomer = $_POST['unohp'];
    $nikcustomer = $_POST['unik'];
    $alamatcustomer = $_POST['ualamat'];
    $sales = $_POST['usales'];
    $statuscustomer = $_POST['ustatuss'];
    $id = $_POST['update-customer'];

    // $id = $_POST['updatemenu'];
    // $menu = $_POST['unama'];
    // $url = $_POST['uurl'];

    $query = "UPDATE customer01 SET
                     namacustomer = '$namacustomer',
                     nohpcustomer = '$nohpcustomer',
                     nikcustomer = '$nikcustomer',
                     alamatcustomer = '$alamatcustomer',
                     sales = '$sales',
                     level = '$level',
                     status = '$statuscustomer'
             WHERE kodecustomer = '$id'
      ";

    $masuk_data = mysqli_query($conn, $query);
    if ($masuk_data) {
        echo 3;
        // echo $bank;
        // echo $norek;
    } else {
        echo 1;
    }
}
