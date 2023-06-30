<?php
session_start();
require '../include/fungsi.php';
date_default_timezone_set('Asia/Jakarta');
$date = new DateTime();

if (isset($_POST['inputsupplier'])) {

    $cekdata = mysqli_query($conn, "SELECT * FROM supplier01 ");
    //cek ada data?
    if (mysqli_num_rows($cekdata) > 0) {
        $kodesupplier = query("SELECT * FROM supplier01 ORDER BY id DESC LIMIT 1")[0];
        $kodes = substr($kodesupplier['kodesupplier'], 3);
        $noUrut = (int) $kodes;
        $noUrut++;
        $newkodetr = sprintf("%03s", $noUrut);
    } else {
        $newkodetr = "001";
    }

    $kode = "SUP";
    $kp = $kode . $newkodetr;
    $nsupplier = htmlspecialchars($_POST["nsupplier"]);
    $kodeoutlet = htmlspecialchars($_POST["kodeoutlet"]);
    $alamat = htmlspecialchars($_POST["alamat"]);
    $bank = htmlspecialchars($_POST["bank"]);
    $nohp = htmlspecialchars($_POST["nohp"]);
    $norek = htmlspecialchars($_POST["norek"]);
    $ppn = htmlspecialchars($_POST["ppn"]);

    $ceknama = mysqli_query($conn, "SELECT * FROM supplier01 WHERE namasupplier ='$nsupplier' and kodeoutlet ='$kodeoutlet' ");

    if (mysqli_fetch_assoc($ceknama)) {
        echo 4;
        return false;
    }

    //query insert data
    $query = "INSERT INTO supplier01 
                VALUES 
                ('','$kodeoutlet','$kp','$nsupplier','$nohp','$alamat','$bank','$norek','$ppn')
            ";

    $masuk_data = mysqli_query($conn, $query);
    if ($masuk_data) {

        echo 3;
    } else {
        echo 1;
    }
} elseif (isset($_POST['inputunit'])) {

    $cekdata = mysqli_query($conn, "SELECT * FROM unit01 ");
    //cek ada data?
    if (mysqli_num_rows($cekdata) > 0) {
        $kodeunit = query("SELECT * FROM unit01 ORDER BY id DESC LIMIT 1")[0];
        $kodes = substr($kodeunit['kodeunit'], 3);
        $noUrut = (int) $kodes;
        $noUrut++;
        $newkodetr = sprintf("%03s", $noUrut);
    } else {
        $newkodetr = "001";
    }

    $kode = "SAT";
    $kp = $kode . $newkodetr;
    $nunit = htmlspecialchars($_POST["nunit"]);

    $ceknama = mysqli_query($conn, "SELECT * FROM unit01 WHERE namaunit ='$nunit'");

    if (mysqli_fetch_assoc($ceknama)) {
        echo 4;
        return false;
    }

    //query insert data
    $query = "INSERT INTO unit01 
                VALUES 
                ('','$kp','$nunit')
            ";

    $masuk_data = mysqli_query($conn, $query);
    if ($masuk_data) {

        echo 3;
    } else {
        echo 1;
    }
} elseif (isset($_POST['inputkategoribarang'])) {

    $cekdata = mysqli_query($conn, "SELECT * FROM kategoribarang02 ");
    //cek ada data?
    if (mysqli_num_rows($cekdata) > 0) {
        $kodekategoribarang = query("SELECT * FROM kategoribarang02 ORDER BY id DESC LIMIT 1")[0];
        $kodes = substr($kodekategoribarang['kodekategoribarang'], 3);
        $noUrut = (int) $kodes;
        $noUrut++;
        $newkodetr = sprintf("%03s", $noUrut);
    } else {
        $newkodetr = "001";
    }

    $kode = "KAB";
    $kp = $kode . $newkodetr;
    $nkategoribarang = htmlspecialchars($_POST["nkategoribarang"]);

    $ceknama = mysqli_query($conn, "SELECT * FROM kategoribarang02 WHERE namakategoribarang ='$nkategoribarang'");

    if (mysqli_fetch_assoc($ceknama)) {
        echo 4;
        return false;
    }

    //query insert data
    $query = "INSERT INTO kategoribarang02 
                VALUES 
                ('','$kp','$nkategoribarang')
            ";

    $masuk_data = mysqli_query($conn, $query);
    if ($masuk_data) {

        echo 3;
    } else {
        echo 1;
    }
} elseif (isset($_POST['inputsubkatbarang'])) {
    $nkategoribarang = $_POST['nkategoribarang'];
    $nsubkatbarang = htmlspecialchars($_POST['nsubkatbarang']);

    $kategoribarang = query("SELECT * FROM kategoribarang02 WHERE kodekategoribarang ='$nkategoribarang'")[0];
    $kodekat = strtoupper(substr($kategoribarang['namakategoribarang'], 0, 1));
    $kode = "CK" . $kodekat;
    $kodecek = $kode . "%";

    $cekdata = mysqli_query($conn, "SELECT * FROM subkatbarang01 WHERE kodesubkatbarang LIKE '$kodecek'");

    if (mysqli_num_rows($cekdata) > 0) {
        $kodesubkategoribarang = query("SELECT * FROM subkatbarang01 WHERE kodesubkatbarang LIKE '$kodecek' ORDER BY id DESC LIMIT 1")[0];
        $kodes = substr($kodesubkategoribarang['kodesubkatbarang'], 3);
        $noUrut = (int) $kodes;
        $noUrut++;
        $newkodetr = sprintf("%03s", $noUrut);
    } else {
        $newkodetr = "001";
    }

    $ksb = $kode . $newkodetr;

    $ceknama = mysqli_query($conn, "SELECT * FROM subkatbarang01 WHERE namasubkatbarang = '$nsubkatbarang'");
    if (mysqli_fetch_assoc($ceknama)) {
        echo 4;
        return false;
    }

    $query = "INSERT INTO subkatbarang01 VALUE ('', '$nkategoribarang', '$ksb', '$nsubkatbarang')";
    $masuk_data = mysqli_query($conn, $query);
    if ($masuk_data) {
        echo 3;
    } else {
        echo 1;
    }
} else if (isset($_POST['inputbarang'])) {

    // $data = [
    //     'kodeoutlet'       => $_POST['kodeoutlet'],
    //     'kategoribarang'       => $_POST['kategoribarang'],
    //     'subkategoribarang'       => $_POST['subkategoribarang'],
    //     'nbarang'       => $_POST['nbarang'],
    //     'hargabeli'       => $_POST['hargabeli'],
    //     'nunit'       => $_POST['nunit'],
    //     'stok'       => $_POST['stok'],
    //     'hargajual1'       => $_POST['hargajual1'],
    //     'hargajual2'       => $_POST['hargajual2'],
    //     'nunitjual'       => $_POST['nunitjual'],
    //     'minstok'       => $_POST['minstok']
    // ];
    // print_r($_POST);die;
    $kodeoutlet       = $_POST['kodeoutlet'];
    $kategoribarang       = $_POST['kategoribarang'];
    $subkategoribarang       = $_POST['subkategoribarang'];
    $nbarang       = $_POST['nbarang'];
    $hargabeli       = $_POST['hargabeli'];
    $nunit       = $_POST['nunit'];
    $stok       = $_POST['stok'];
    $hargajual1       = $_POST['hargajual1'];
    $hargajual2       = $_POST['hargajual2'];
    $nunitjual       = $_POST['nunitjual'];
    $minstok       = $_POST['minstok'];
    $status       = $_POST['status'];
    $kodeitem       = $_POST['kodeitem1'];
    $kodebarcode       = $_POST['kodebarcode1'];
    $merk       = $_POST['merk1'];
    $dept       = $_POST['dept1'];
    $supplier       = $_POST['supplier1'];
    $rak       = $_POST['rak1'];
    $keterangan       = $_POST['keterangan1'];

    // echo $status;die;
    $cekdata = mysqli_query($conn, "SELECT * FROM barang01 ");
    //cek ada data?
    if (mysqli_num_rows($cekdata) > 0) {
        $kodeproduk = query("SELECT * FROM barang01 WHERE kodeoutlet = '$kodeoutlet' ORDER BY id DESC LIMIT 1")[0];
        $kodes = substr($kodeproduk['kodebarang'], 3);
        $noUrut = (int) $kodes;
        $noUrut++;
        $newkodetr = sprintf("%03s", $noUrut);
    } else {
        $newkodetr = "001";
    }

    $kode = "BAR";
    $kb = $kode . $newkodetr;

    $query = "INSERT INTO barang01 SET 
    kodeoutlet = '$kodeoutlet',
    kodeitem = '$kodeitem',
    kodebarcode = '$kodebarcode',
    kategoribarang = '$kategoribarang',
    subkatbarang = '$subkategoribarang',
    kodebarang = '$kb',
    namabarang = '$nbarang',
    merk = '$merk',
    hargabeli = '$hargabeli',
    unitbeli = '$nunit',
    stok = '$stok',
    hargajual1 = '$hargajual1',
    hargajual2 = '$hargajual2',
    unitjual = '$nunitjual',
    minstok = '$minstok',
    status = '$status',
    rak = '$rak',
    dept = '$dept',
    supplier = '$supplier',
    keterangan = '$keterangan'";

    $masuk_data = mysqli_query($conn, $query);
    // var_dump($query);die;
    if ($masuk_data) {
        echo 3;
    } else {
        echo 1;
    }
} else if (isset($_POST['inputcustomer'])) {

    $cekdata = mysqli_query($conn, "SELECT * FROM customer01 ");
    //cek ada data?
    if (mysqli_num_rows($cekdata) > 0) {
        $kodecustomer = query("SELECT * FROM customer01 ORDER BY id DESC LIMIT 1")[0];
        $kodes = substr($kodecustomer['kodecustomer'], 3);
        $noUrut = (int) $kodes;
        $noUrut++;
        $newkodetr = sprintf("%03s", $noUrut);
    } else {
        $newkodetr = "001";
    }

    $kode = "CUS";
    $kp = $kode . $newkodetr;
    $kodeoutlet = htmlspecialchars($_POST["kodeoutlet"]);
    $ncustomer = strtolower(htmlspecialchars(preg_replace("/[^A-Za-z0-9\-\s]/", "", mysqli_real_escape_string($conn, $_POST["ncustomer"]))));
    $nohp = htmlspecialchars($_POST["nohp"]);
    $nik = htmlspecialchars($_POST["nik"]);
    $alamat = htmlspecialchars($_POST["alamat"]);
    $sales = htmlspecialchars($_POST["sales"]);
    $statuss = htmlspecialchars($_POST["statuss"]);
    $level = htmlspecialchars($_POST["level"]);

    $ceknama = mysqli_query($conn, "SELECT * FROM customer01 WHERE namacustomer ='$ncustomer' and kodeoutlet ='$kodeoutlet' ");

    if (mysqli_fetch_assoc($ceknama)) {
        echo 4;
        return false;
    }

    //query insert data
    $query = "INSERT INTO customer01
                    VALUES 
                    ('','$kodeoutlet','$kp','$ncustomer','$nohp','$nik','$alamat','$sales','$statuss','$level')
                ";

    $masuk_data = mysqli_query($conn, $query);
    if ($masuk_data) {
        echo 3;
    } else {
        echo 1;
    }
}
