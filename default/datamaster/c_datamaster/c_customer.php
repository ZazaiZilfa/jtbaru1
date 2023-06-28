<?php
$kodeoutlet = $_SESSION['kodeoutlet'];
$kodecustomer = query("SELECT * FROM customer01 ORDER BY id DESC ");
$sales = query("SELECT * FROM karyawan01 WHERE jabatan = 'JAB005' OR jabatan = 'JAB006' ORDER BY id DESC");

// if (isset($_POST["updatecustomer"])) {
//     //var_dump($_POST);
//     $idcustomer = $_POST["idcustomer"];
//     $ncustomer = strtolower(htmlspecialchars($_POST["namacustomer"]));


//     $query = "UPDATE customer SET
//                 namacustomer = '$ncustomer'
//         WHERE id = $idcustomer
//     ";
//     $masuk_data = mysqli_query($conn, $query);
//     if ($masuk_data) {
//         echo "<script >
//             alert('edit berhasil');
//                 document.location.href = 'customer';
//             </script>";
//         //echo 3;
//     } else {
//         echo "<script>
//                 alert('gagal');
//                 document.location.href = 'customer';
//             </script>";
//         //echo 1;
//     }
// }
