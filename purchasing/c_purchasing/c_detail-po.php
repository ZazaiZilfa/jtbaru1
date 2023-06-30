<?php
$kodeoutlet = $_SESSION['kodeoutlet'];
$No_form = $_GET['No_form'];
$cekkodesupplier = query("SELECT kodesupplier FROM form_po01 WHERE No_form = '$No_form'")[0];

$cekStatusPO = query("SELECT * FROM form_po01 WHERE No_form = '$No_form' AND kodeoutlet = '$kodeoutlet'")[0];

if ($cekStatusPO['status_ck'] == 2 && $cekStatusPO['status_ot'] == 2) {
    $cekFormIn = query("SELECT No_form FROM form_in01 WHERE Form_po = '$No_form' AND kodeoutlet = '$kodeoutlet'")[0]['No_form'];
    if ($cekkodesupplier['kodesupplier'] == "SUP000") {
        $item_po = query("SELECT item_in01.*, b.namabarang, u.namaunit FROM item_in01
        JOIN barang01 b ON item_in01.kodebahan = b.kodebarang
        JOIN unit01 u ON item_in01.unit = u.kodeunit
        WHERE item_in01.No_form = '$cekFormIn' AND b.kodeoutlet = '$kodeoutlet' AND item_in01.kodeoutlet = '$kodeoutlet' ORDER BY item_in01.id");
    } else {
        $item_po = query("SELECT item_in01.*, b.namabarang, u.namaunit FROM item_in01
        JOIN barang01 b ON item_in01.kodebahan = b.kodebarang
        JOIN unit01 u ON item_in01.unit = u.kodeunit
        WHERE item_in01.No_form = '$cekFormIn' AND b.kodeoutlet = '$kodeoutlet' AND item_in01.kodeoutlet = '$kodeoutlet' ORDER BY item_in01.id");
    }
} else {
    if ($cekkodesupplier['kodesupplier'] == "SUP000") {
        $item_po = query("SELECT ip.*, b.namabarang, u.namaunit FROM item_po01 ip
        JOIN barang01 b ON ip.kodebahan = b.kodebarang
        JOIN unit01 u ON ip.unit = u.kodeunit
        WHERE ip.No_form = '$No_form' AND ip.kodeoutlet = '$kodeoutlet' AND b.kodeoutlet = 'OUT002' ORDER BY ip.id");
    } else {
        $item_po = query("SELECT ip.*, b.namabarang, u.namaunit FROM item_po01 ip
        JOIN barang01 b ON ip.kodebahan = b.kodebarang
        JOIN unit01 u ON ip.unit = u.kodeunit
        WHERE ip.No_form = '$No_form' AND b.kodeoutlet = '$kodeoutlet' AND ip.kodeoutlet = '$kodeoutlet' ORDER BY ip.id");
    }
}


if ($cekStatusPO['status_ck'] == 2 && $cekStatusPO['status_ot'] == 2) {
    $detail = query("SELECT *
    FROM form_in01
    JOIN supplier01 ON form_in01.kodesupplier = supplier01.kodesupplier
    WHERE form_in01.Form_po = '$No_form' AND form_in01.kodeoutlet = '$kodeoutlet'")[0];
} else {
    $detail = query("SELECT *
    FROM form_po01
    JOIN supplier01 ON form_po01.kodesupplier = supplier01.kodesupplier 
    WHERE No_form = '$No_form' AND form_po01.kodeoutlet = '$kodeoutlet'  ")[0];
}



// $sot = $detail['status_ot'];
// $sck = $detail['status_ck'];

// $status = $detail['status'];
$sot = $detail['status_ot'];
$sck = $detail['status_ck'];

if ($cekStatusPO['status_ck'] == 2 && $cekStatusPO['status_ot'] == 2) {
    $cekPrice = query("SELECT ppn, total FROM form_in01 WHERE Form_po = '$No_form' AND kodeoutlet = '$kodeoutlet'")[0];
    $grand_total = $cekPrice['total'];
    $ppn = $cekPrice['ppn'];
} else {
    $total =  query("SELECT sum(subtotal) as total FROM item_po01 WHERE No_form = '$No_form' AND kodeoutlet = '$kodeoutlet'")[0];
    $ppn = $total['total'] * $globalPPN / 100;
    $grand_total =  $total['total'];
}
// var_dump($grand_total);
// die;