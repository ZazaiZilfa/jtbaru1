<?php
session_start();
require '../../include/fungsi.php';
date_default_timezone_set('Asia/Jakarta');
$date = new DateTime();

if (isset($_POST['inputformpo'])) {

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
    // $jatuhtempo = $_POST['jatuhtempo'];

    // isi noform

    $ambil_noform = query("SELECT id,No_form,kodeoutlet FROM form_po01 where kodeoutlet = '$kodeoutlet' and No_form like 'FPO$date%' ORDER BY No_form DESC");
    $pecah_po = substr($ambil_noform["0"]['No_form'], 0, 9);
    $pecah_po_b = substr($ambil_noform["0"]['No_form'], 9);


    if ($pecah_po == "FPO$date") {
        $pecah_po_b += 1;
        $pecah_po_b = sprintf("%03d", $pecah_po_b);
        $No_form = 'FPO' . $date . $pecah_po_b;
    } else {
        $No_form = 'FPO' . $date . '001';
    }

    // input ke tabel form po

    foreach ($namabarang as $key => $nambar) {
        $formatHarga = str_replace(',', '.', $harga[$key]);
        mysqli_query($conn, "insert into item_po01 set
            No_form    = '$No_form',
            kodeoutlet = '$kodeoutlet',
            kodebahan  = '$kodebahan[$key]',
            qty = '$jumlah[$key]',
            harga = '$formatHarga',
            unit ='$unitbeli[$key]',
            subtotal = '$subtotal[$key]'
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


    mysqli_query($conn, "insert into form_po01 set
                No_form    = '$No_form',
                kodeoutlet      = '$kodeoutlet',
                kodesupplier = '$kodesupplier',
                date ='$dt_input',
                pembayaran = '$pembayaran',
                metodepembayaran = '$metodepembayaran',
                status_ck = '2',
                status_ot = '1',
                jatuhtempo = '$jatuhtempo',
                whois = '$usernameSession',
                whois_update = '',
                created_at = now() + interval 7 hour
            ");

    $result = mysqli_affected_rows($conn);

    //kembali ke halaman sebelumnya
    $_SESSION["msg"] = "$result";
    // header("Location: form-po.php?msg=" . urlencode('1'));

    header("location: ../form-po.php");
} elseif (isset($_POST['inputformin'])) {

    $nopo = $_POST['noform'];
    $nofaktur = $_POST['nofaktur'];
    $kodebahan = $_POST['kodebahan'];
    $harga = $_POST['harga'];
    $qty = $_POST['qty'];
    $disc = $_POST['disc'];
    $unit = $_POST['unit'];
    $subtotal = $_POST['subtotal'];
    $kodesupplier = $_POST['kodesupplier'];
    $diskon1 = $_POST['diskon1'];
    $diskon2 = $_POST['diskon2'];
    $diskon3 = $_POST['diskon3'];
    $total_keseluruhan = str_replace('.', '', $_POST['total_keseluruhan']);
    $ppn = str_replace('.', '', $_POST['ppn']);
    $changePrice = $_POST['changeprice'];

    $tgl_tempo = $_POST['tgl_tempo'];
    $tanggal_manual = $_POST['tanggal_manual'];

    $kodeoutlets = $_SESSION['kodeoutlet'];

    $checkPO = query("SELECT Form_po FROM form_in01 WHERE Form_po = '$nopo' ORDER BY id DESC");

    if (COUNT($checkPO) == 0) {

        if ($tgl_tempo == null) {
            if ($tanggal_manual == null) {
                //TANGGAL AUTO
                $tgl_tempo = date('Y-m-d');
            } else {
                //TANGGAL MANUAL
                $tm = explode("/", $tanggal_manual);
                $tgl_tempo = $tm[2] . '-' . $tm[0] . '-' . $tm[1];
            }

            $jatuhtempo = date('Y-m-d', strtotime('+14 days', strtotime($tgl_tempo)));
        } else {
            $ttempo = explode("/", $tgl_tempo);
            $jatuhtempo = $ttempo[2] . '-' . $ttempo[1] . '-' . $ttempo[0];
        }

        foreach ($harga as $key => $h) {
            $fixedPrice = $subtotal[$key] / $qty[$key];
            $cekstok = query("SELECT hargabeli, hargajual1, hargajual2, stok FROM barang01 WHERE kodebarang = '$kodebahan[$key]' AND kodeoutlet = '$kodeoutlets'");
            $newstok = $cekstok[0]['stok'] + $qty[$key];

            $hbReal = $cekstok[0]['hargabeli'];
            $hj1Real = $cekstok[0]['hargajual1'];
            $hj2Real = $cekstok[0]['hargajual2'];

            $proc1 = round((($hj1Real - $hbReal) / $hbReal) * 100, 2);
            $proc2 = round((($hj2Real - $hbReal) / $hbReal) * 100, 2);

            $newHj1 = round(($fixedPrice * $proc1 / 100) + $fixedPrice);
            $newHj2 = round(($fixedPrice * $proc2 / 100) + $fixedPrice);

            if ($hbReal < $fixedPrice && $changePrice == 1) {
                mysqli_query($conn, "UPDATE barang01 SET hargabeli = '$fixedPrice', stok= '$newstok', hargajual1 = '$newHj1', hargajual2 = '$newHj2' WHERE kodebarang='$kodebahan[$key]'");
            } else {
                mysqli_query($conn, "UPDATE barang01 SET stok= '$newstok' WHERE kodebarang='$kodebahan[$key]'");
            }
        }

        // akhir cek

        // $namaoutlet = $_SESSION['outlet'];

        $kodeoutlet = $_SESSION['kodeoutlet'];

        //tanggal manual
        if ($tanggal_manual == null) {
            // tanggal auto
            $dt_input = date('Y-m-d');
            $date = date('ymd');
        } else {
            // tanggal manual
            $tm = explode("/", $tanggal_manual);
            $dt_input = $tm[2] . '-' . $tm[1] . '-' . $tm[0];
            $tm_kata = str_split($tm[2]);
            $date = $tm_kata[2] . $tm_kata[3] . $tm[0] . $tm[1];
        }

        //ambil noform 
        $ambil_noform = query("SELECT id, No_form, kodeoutlet FROM form_in01 where kodeoutlet = '$kodeoutlet' and No_form like 'FIN$date%' ORDER BY No_form DESC");
        $pecah_po = substr($ambil_noform[0]['No_form'], 0, 9);
        $pecah_po_b = substr($ambil_noform[0]['No_form'], 9);

        // var_dump($ambil_noform);

        if ($pecah_po == "FIN$date") {

            $pecah_po_b += 1;
            $pecah_po_b = sprintf("%03d", $pecah_po_b);
            $No_form = 'FIN' . $date . $pecah_po_b;
        } else {
            $No_form = 'FIN' . $date . '001';
        }
        // akhir ambil no form

        for ($i = 0; $i < count($kodebahan); $i++) {
            $fixedPrices = $subtotal[$i] / $qty[$i];

            mysqli_query($conn, "INSERT INTO item_in SET
             No_form = '$No_form' ,
             kodeoutlet = '$kodeoutlet',
             kodebahan = '$kodebahan[$i]', 
             qty = '$qty[$i]', 
             harga = '$harga[$i]', 
             disc = '$disc[$i]',
             subtotal = '$subtotal[$i]',
             unit = '$unit[$i]',
             hargafix = '$fixedPrices'
             ");
        }

        mysqli_query($conn, "insert into form_in01 set
                No_form    = '$No_form',
                Form_po = '$nopo',
                No_faktur = '$nofaktur',
                No_pajak = '',
                kodeoutlet = '$kodeoutlet',
                kodesupplier = '$kodesupplier',
                date ='$dt_input',
                jatuhtempo ='$jatuhtempo',
                status_ot = '2',
                status_ck = '2',
                diskon1 = '$diskon1',
                diskon2 = '$diskon2',
                diskon3 = '$diskon3',
                ppn = '$ppn',
                total = '$total_keseluruhan',
                whois = '$usernameSession',
                created_at = now() + interval 7 hour
            ");

        $result = mysqli_affected_rows($conn);

        if ($result) {
            mysqli_query($conn, "UPDATE form_po01 SET status_ot='2' WHERE No_form='$nopo'");
        }

        //kembali ke halaman sebelumnya
        $_SESSION["msg"] = "$result";
    }

    header("Location: ../index");
} elseif (isset($_POST['inputformin']) && $_POST['supplier_ppn'] == '1') {
    $type = $_POST['supplier_ppn'];

    $nopo = $_POST['noform'];
    $nofaktur = $_POST['nofaktur'];
    $kodebahan = $_POST['kodebahan'];
    $qty = $_POST['qty'];
    $disc = $_POST['disc'];
    $unit = $_POST['unit'];
    $kodesupplier = $_POST['kodesupplier'];
    $diskon1 = $_POST['diskon1'];
    $diskon2 = $_POST['diskon2'];
    $diskon3 = $_POST['diskon3'];
    $total_keseluruhan = str_replace('.', '', $_POST['total_keseluruhan']);
    $ppn = str_replace('.', '', $_POST['ppn']);
    $changePrice = $_POST['changeprice'];

    $tgl_tempo = $_POST['tgl_tempo'];
    $tanggal_manual = $_POST['tanggal_manual'];

    $kodeoutlets = $_SESSION['kodeoutlet'];

    if ($tgl_tempo == null) {
        if ($tanggal_manual == null) {
            //TANGGAL AUTO
            $tgl_tempo = date('Y-m-d');
        } else {
            //TANGGAL MANUAL
            $tm = explode("/", $tanggal_manual);
            $tgl_tempo = $tm[2] . '-' . $tm[0] . '-' . $tm[1];
        }

        $jatuhtempo = date('Y-m-d', strtotime('+14 days', strtotime($tgl_tempo)));
    } else {
        $ttempo = explode("/", $tgl_tempo);
        $jatuhtempo = $ttempo[2] . '-' . $ttempo[1] . '-' . $ttempo[0];
    }

    foreach ($disc as $key => $h) {
        $fixedPrice = round(($_POST['subtotal'][$key] / $qty[$key]) / $globalHPP);
        $cekstok = query("SELECT stok FROM barang01 WHERE kodebarang = '$kodebahan[$key]' AND kodeoutlet = '$kodeoutlets'");
        $cekharga =  query("SELECT hargabeli FROM barang01 WHERE kodebarang = '$kodebahan[$key]' AND kodeoutlet = '$kodeoutlets'")[0]['hargabeli'];
        $newstok = $cekstok[0]['stok'] + $qty[$key];
        if ($cekharga < $fixedPrice && $changePrice == 1) {
            mysqli_query($conn, "UPDATE barang01 SET hargabeli = '$fixedPrice', stok= '$newstok' WHERE kodebarang='$kodebahan[$key]'");
        } else {
            mysqli_query($conn, "UPDATE barang01 SET stok= '$newstok' WHERE kodebarang='$kodebahan[$key]'");
        }
    }

    // akhir cek

    // $namaoutlet = $_SESSION['outlet'];

    $kodeoutlet = $_SESSION['kodeoutlet'];

    //tanggal manual
    if ($tanggal_manual == null) {
        // tanggal auto
        $dt_input = date('Y-m-d');
        $date = date('ymd');
    } else {
        // tanggal manual
        $tm = explode("/", $tanggal_manual);
        $dt_input = $tm[2] . '-' . $tm[1] . '-' . $tm[0];
        $tm_kata = str_split($tm[2]);
        $date = $tm_kata[2] . $tm_kata[3] . $tm[0] . $tm[1];
    }

    //ambil noform 
    $ambil_noform = query("SELECT id, No_form, kodeoutlet FROM form_in01 where kodeoutlet = '$kodeoutlet' and No_form like 'FIN$date%' ORDER BY No_form DESC");
    $pecah_po = substr($ambil_noform[0]['No_form'], 0, 9);
    $pecah_po_b = substr($ambil_noform[0]['No_form'], 9);

    // var_dump($ambil_noform);

    if ($pecah_po == "FIN$date") {

        $pecah_po_b += 1;
        $pecah_po_b = sprintf("%03d", $pecah_po_b);
        $No_form = 'FIN' . $date . $pecah_po_b;
    } else {
        $No_form = 'FIN' . $date . '001';
    }
    // akhir ambil no form

    for ($i = 0; $i < count($kodebahan); $i++) {
        $harga = round($_POST['harga'][$i] / $globalHPP);
        $subtotal = round($_POST['subtotal'][$i] / $globalHPP);
        $fixedPrices = $subtotal / $qty[$i];

        mysqli_query($conn, "INSERT INTO item_in01 SET
         No_form = '$No_form' ,
         kodeoutlet = '$kodeoutlet',
         kodebahan = '$kodebahan[$i]', 
         qty = '$qty[$i]', 
         harga = '$harga', 
         disc = '$disc[$i]',
         subtotal = '$subtotal',
         unit = '$unit[$i]',
         hargafix = '$fixedPrices'
         ");
    }

    mysqli_query($conn, "insert into form_in01 set
            No_form    = '$No_form',
            Form_po = '$nopo',
            No_faktur = '$nofaktur',
            No_pajak = '',
            kodeoutlet = '$kodeoutlet',
            kodesupplier = '$kodesupplier',
            date ='$dt_input',
            jatuhtempo ='$jatuhtempo',
            status_ot = '2',
            status_ck = '2',
            diskon1 = '$diskon1',
            diskon2 = '$diskon2',
            diskon3 = '$diskon3',
            ppn = '$ppn',
            total = '$total_keseluruhan',
            whois = '$usernameSession',
            created_at = now() + interval 7 hour
        ");

    $result = mysqli_affected_rows($conn);

    if ($result) {
        mysqli_query($conn, "UPDATE form_po01 SET status_ot='2' WHERE No_form='$nopo'");
    }

    //kembali ke halaman sebelumnya
    $_SESSION["msg"] = "$result";
    header("Location: ../index");
}
