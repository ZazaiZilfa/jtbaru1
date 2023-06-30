<?php
$kodeoutlet = $_SESSION['kodeoutlet'];
$No_form = $_GET['No_form'];
$cekStatusPO = query("SELECT * FROM form_po01 WHERE No_form = '$No_form' AND kodeoutlet = '$kodeoutlet'")[0];




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
