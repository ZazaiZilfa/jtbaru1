<?php


if (isset($_POST["keyword_bahan_masuk"])) {
    $keyword = $_POST["keyword_bahan_masuk"];
    $kodeoutlet = $_SESSION['kodeoutlet'];

    $cekkodesupplier = query("SELECT kodesupplier FROM form_po01 WHERE No_form = '$keyword'")[0];

    if ($cekkodesupplier['kodesupplier'] == "SUP000") {
        $item_po = query("SELECT * FROM item_po01 as ip JOIN barang01 as b ON ip.kodebahan = b.kodebarang JOIN unit01 as u ON ip.unit = u.kodeunit  WHERE  ip.No_form = '$keyword' AND b.kodeoutlet = 'OUT002' AND ip.kodeoutlet = '$kodeoutlet' ORDER BY ip.id");
    } else {
        $item_po = query("SELECT * FROM item_po01 as ip JOIN barang01 as b ON ip.kodebahan = b.kodebarang JOIN unit01 as u ON ip.unit = u.kodeunit  WHERE  ip.No_form = '$keyword' AND b.kodeoutlet = '$kodeoutlet' AND ip.kodeoutlet = '$kodeoutlet' ORDER BY ip.id");
    }

    // $item_po = query("SELECT * FROM item_po as ip
    //     JOIN barang as b ON ip.kodebahan = b.kodebarang
    //     JOIN unit as u ON ip.unit = u.kodeunit 
    //     WHERE  ip.No_form = '$keyword' AND b.kodeoutlet = '$kodeoutlet' AND ip.kodeoutlet = '$kodeoutlet'
    // ORDER BY ip.id DESC ");

    // var_dump($kodeoutlet);
    // die();

    $detail = query("SELECT form_po01.kodesupplier,namasupplier,alamatsupplier,No_form,date,ppn FROM form_po01
    JOIN supplier01 ON form_po01.kodesupplier = supplier01.kodesupplier 
    WHERE  No_form = '$keyword' AND form_po01.kodeoutlet = '$kodeoutlet' AND supplier01.kodeoutlet = '$kodeoutlet'
    ORDER BY form_po01.id DESC ")[0];
}
