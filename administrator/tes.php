<?php
session_start();
require '../include/fungsi.php';

echo "This is sandbox for administrator only. Stay away from here <br> P.s. ur IP Address is ";

function getUserIP()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}


$user_ip = getUserIP();

$testQuery = query("SELECT fsale.invoice, SUM(its.qty) AS qty_item, brg.namabarang FROM form_sale AS fsale JOIN item_sale AS its ON fsale.invoice = its.invoice JOIN barang AS brg ON its.kodebahan = brg.kodebarang WHERE brg.supplier = 'SUP001' AND fsale.date BETWEEN '2022-06-05' AND '2022-06-10'");

var_dump($testQuery);

echo $user_ip; // Output IP address [Ex: 177.87.193.134]

// $formSales = query("SELECT invoice, date, customer FROM form_sale WHERE 1");

// foreach($formSales as $row) {
//     $invoice = $row['invoice'];
//     $date = $row['date'];
//     $customer = $row['customer'];

//     mysqli_query($conn, "UPDATE item_sale SET dates = '$date', customers = '$customer' WHERE invoice = '$invoice'");
// }

// $cek = query("SELECT hargafix FROM item_in WHERE kodebahan = 'BAR008' AND kodeoutlet = 'OUT002' AND id NOT IN (2113) ORDER BY hargafix DESC LIMIT 1")[0]['hargafix'];
// var_dump($cek);

// $supplier = query("SELECT * FROM customer WHERE 1");

// foreach ($supplier as $key => $s) {
//     $id = $s['id'];
//     $nama = strtoupper($s['namacustomer']);
//     $update = mysqli_query($conn, "UPDATE customer SET namacustomer = '$nama' WHERE id = '$id'");
// }

// var_dump($update);

// $cekdata = mysqli_query($conn, "SELECT * FROM barang WHERE kodeoutlet = 'OUT005'");

// echo mysqli_num_rows($cekdata);

// $barang = query("SELECT * FROM barangppn WHERE 1");

// foreach ($barang as $key => $b) {
//     // $kodeoutlet = "OUT008";
//     // $kategoribarang = $b['kategoribarang'];
//     // $subkatbarang = $b['subkatbarang'];
    // $kodebarang = $b['kodebarang'];
//     // $namabarang = mysqli_real_escape_string($conn, $b['namabarang']);
//     // $hargabeli = $b['hargabeli'];
//     // $unitbeli = $b['unitbeli'];
    // $hargajual1 = $b['hargajual1'];
//     $hargajual2 = $b['hargajual2'];
//     // $unitjual = $b['unitjual'];
//     // $stok = $b['stok'];
//     // $minstok = $b['minstok'];
//     // $status = $b['status'];
//     // echo $kodebarang . " + " . $hargabeli . "<br>";
    // $newPrice = round(($hargajual1 / 11) * 10);
//     $newPrice2 = round(($hargajual2 / 11) * 10);

    // $query = "UPDATE barang SET hargajual1 = '$newPrice' WHERE kodebarang = '$kodebarang'";
//     $query = "UPDATE barang SET hargajual2 = '$newPrice2' WHERE kodebarang = '$kodebarang'";

    // $result = mysqli_query($conn, $query);
    
    // echo $result;
// }

// $cekdata = mysqli_query($conn, "SELECT * FROM barang WHERE kodeoutlet = 'OUT008'");

// echo mysqli_num_rows($cekdata);

//echo getHostByName(getHostName());

//$barang = query("SELECT * FROM barang1 WHERE kodeoutlet = 'OUT002'");

// foreach ($barang as $b) {
//     $kodeoutlet = $b['kodeoutlet'];
//     $kategoribarang = $b['kategoribarang'];
//     $subkatbarang = $b['subkatbarang'];
//     $kodebarang = $b['kodebarang'];
//     $namabarang = $b['namabarang'];
//     $hargabeli = $b['hargabeli'];
//     $unitbeli = $b['unitbeli'];
//     $hargajual1 = $b['hargajual1'];
//     $hargajual2 = $b['hargajual2'];
//     $unitjual = $b['unitjual'];
//     $stok = $b['stok'];
//     $minstok = $b['minstok'];
//     $status = $b['status'];

//     mysqli_query($conn, "INSERT INTO barang VALUES ('', '$kodeoutlet', '$kategoribarang', '$subkatbarang', '$kodebarang', '$namabarang', '$hargabeli', '$unitbeli', '$hargajual1', '$hargajual2', '$unitjual', '$stok', '$minstok', '$status')");
// }

// if (isset($_POST["submit"])) {
//     if ($_FILES['file']['name']) {
//         $filename = explode('.', $_FILES['file']['name']);
//         if ($filename[1] == 'csv') {
//             $handle = fopen($_FILES['file']['tmp_name'], "r");
//             while ($data = fgetcsv($handle)) {

//                 // $kodeoutlet = mysqli_real_escape_string($conn, $data[0]);

//                 // $cekdata = mysqli_query($conn, "SELECT * FROM supplier ");
//                 // //cek ada data?
//                 // if (mysqli_num_rows($cekdata) > 0) {
//                 //     $kodesupplier = query("SELECT * FROM supplier ORDER BY id DESC LIMIT 1")[0];
//                 //     $kodes = substr($kodesupplier['kodesupplier'], 3);
//                 //     $noUrut = (int) $kodes;
//                 //     $noUrut++;
//                 //     $newkodetr = sprintf("%03s", $noUrut);
//                 // } else {
//                 //     $newkodetr = "001";
//                 // }
//                 // $kodesupplier = "SUP" . $newkodetr;

//                 // $namasupplier = mysqli_real_escape_string($conn, $data[2]);
//                 // $nohp = mysqli_real_escape_string($conn, $data[3]);
//                 // $alamatsupplier = "";
//                 // $kodebank = "BAN001";
//                 // $norek = "";

//                 // $query = "INSERT INTO supplier
//                 //     VALUES
//                 //     ('','$kodeoutlet', '$kodesupplier', '$namasupplier','$nohp','$alamatsupplier','$kodebank', '$norek')
//                 // ";
//                 $kodeoutlet = preg_replace("/[^A-Za-z0-9\-]/", "", mysqli_real_escape_string($conn, $data[0]));
//                 $kategoribarang = mysqli_real_escape_string($conn, $data[1]);
//                 $subkatbarang = mysqli_real_escape_string($conn, $data[2]);
//                 $kodebarang = mysqli_real_escape_string($conn, $data[3]);
//                 $namabarang = mysqli_real_escape_string($conn, $data[4]);
//                 $hargabeli = mysqli_real_escape_string($conn, $data[5]);
//                 $unitbeli = mysqli_real_escape_string($conn, $data[6]);
//                 $hargajual1 = "";
//                 $hargajual2 = "";
//                 $unitjual = "";
//                 $stok = mysqli_real_escape_string($conn, $data[10]);
//                 $minstok = mysqli_real_escape_string($conn, $data[11]);
//                 $status = mysqli_real_escape_string($conn, $data[12]);

//                 mysqli_query($conn, "INSERT INTO barang VALUES ('', '$kodeoutlet', '$kategoribarang', '$subkatbarang', '$kodebarang', '$namabarang', '$hargabeli', '$unitbeli', '$hargajual1', '$hargajual2', '$unitjual', '$stok', '$minstok', '$status')");

//                 // mysqli_query($conn, $query);
//             }

//             fclose($handle);
//             //print "IMPORT DONE";
//         }
//     }
//     echo "
//             <script>
//                 alert('Import File berhasil');
//                 document.location.href = 'tes';
//             </script>
//             ";
// }
?>
<!--<form method="POST" enctype="multipart/form-data">-->

<!--    <input type="file" name="file" class="dropify" data-height="300" />-->
<!--    <br>-->
<!--    <div class="form-group">-->
<!--        <div class="col-sm-offset-4 col-sm-12">-->
<!--            <button type="submit" name="submit" value="import" class="btn btn-primary waves-effect waves-light">-->
<!--                Upload File-->
<!--            </button>-->

<!--        </div>-->
<!--    </div>-->
<!--</form>-->
<!--</div>-->