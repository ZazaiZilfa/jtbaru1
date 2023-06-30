<?php

$kodeunit = query("SELECT * FROM unit01 ORDER BY id DESC ");

// if (isset($_POST["updateunit"])) {
//     //var_dump($_POST);
//     $idunit = $_POST["idunit"];
//     $nunit = strtolower(htmlspecialchars($_POST["namaunit"]));


//     $query = "UPDATE unit SET
//                 namaunit = '$nunit'
//         WHERE id = $idunit
//     ";
//     $masuk_data = mysqli_query($conn, $query);
//     if ($masuk_data) {
//         echo "<script >
//             alert('edit berhasil');
//                 document.location.href = 'unit';
//             </script>";
//         //echo 3;
//     } else {
//         echo "<script>
//                 alert('gagal');
//                 document.location.href = 'unit';
//             </script>";
//         //echo 1;
//     }
// }
