<?php
$kodeoutlet = $_SESSION['kodeoutlet'];
if (isset($_POST['kodeoutlet'])) {
    $kdl = $_POST['kodeoutlet'];
    // $bln = $_POST['bulan'];
    if ($kdl == "00") {
        $kdoutlet = "$tabel.kodeoutlet = '$kodeoutlet'";
    } else {
        $kdoutlet = "$tabel.kodeoutlet = '$kdl'";
    }
}
if ($kodeoutlet == "OUT001" or $kodeoutlet == "OUT000") {
    // var_dump($_POST['tahun'] . $_POST['bulan']);
    // die();
    if (isset($_POST['filter-date'])) {
        $bulan = $_POST['bulan'];
        $tahun = $_POST['tahun'];

        $data = query("SELECT *  
        FROM $tabel
        JOIN $tabel_join
        ON $tabel.kode$kode = $tabel_join.kode$kode
        WHERE $kdoutlet AND date 
        LIKE '$tahun-$bulan%'
        ORDER BY $tabel.date DESC, $tabel.No_form DESC
        ");
    } else {
        $data = query("SELECT *
        FROM $tabel
        JOIN $tabel_join
        ON $tabel.kode$kode = $tabel_join.kode$kode
        WHERE date 
        LIKE '$year-$month%'
        ORDER BY $tabel.date DESC, $tabel.No_form DESC");
    }
} else {
    if (isset($_POST['filter-date'])) {

        $bulan = $_POST['bulan'];
        $tahun = $_POST['tahun'];
        if ($_POST['bulan'] == "00") {
            $data = query("SELECT *  
            FROM $tabel
            JOIN $tabel_join
            ON $tabel.kode$kode = $tabel_join.kode$kode
            WHERE $kdoutlet AND $tabel_join.kodeoutlet = '$kodeoutlet' 
            ORDER BY $tabel.date DESC, $tabel.No_form DESC");
        } else {
            $data = query("SELECT *  
            FROM $tabel
            JOIN $tabel_join
            ON $tabel.kode$kode = $tabel_join.kode$kode
            WHERE $kdoutlet AND date 
            LIKE '$tahun-$bulan%' AND $tabel_join.kodeoutlet = '$kodeoutlet' 
            ORDER BY $tabel.date DESC, $tabel.No_form DESC");
        }
    } else if (isset($_POST['filter-specific-date'])) {
        $tgl = $_POST['specific-date'];
        $newTgl = explode("/", $tgl);
        $tanggal = $newTgl[2] . '-' . $newTgl[0] . '-' . $newTgl[1];

        $data = query("SELECT * FROM $tabel
                JOIN $tabel_join
                ON $tabel.kode$kode = $tabel_join.kode$kode
                WHERE $kdoutlet AND date 
                LIKE '$tanggal%' AND $tabel_join.kodeoutlet = '$kodeoutlet' 
                ORDER BY $tabel.date DESC, $tabel.No_form DESC");
    } else {
        if ($tabel_join == 'companypanel') {
            $data = query("SELECT $tabel.*, $tabel_join.nama
            FROM $tabel
            JOIN $tabel_join
            ON $tabel.kode$kode = $tabel_join.kode$kode
            ORDER BY $tabel.date DESC, $tabel.No_form DESC");
        } else {
            $dateTodays = date("Y-m-d");
            $dateThreeDays = date("Y-m-d", strtotime('-3 days'));
            // BETWEEN '$dateThreeDays' AND

            $data = query("SELECT $tabel.*, $tabel_join.namasupplier
            FROM $tabel
            JOIN $tabel_join
            ON $tabel.kode$kode = $tabel_join.kode$kode
            WHERE $tabel.date = '$dateTodays' AND $tabel_join.kodeoutlet = '$kodeoutlet' 
            AND $tabel.kodeoutlet = '$kodeoutlet'
            ORDER BY $tabel.date DESC, $tabel.No_form DESC");
        }
    }
}
