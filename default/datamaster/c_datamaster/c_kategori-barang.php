<?php

$kodekategoribarang = query("SELECT * FROM kategoribarang02 ORDER BY id DESC ");

// if (isset($_POST["updatekategoribarang"])) {
//     //var_dump($_POST);
//     $idkategoribarang = $_POST["idkategoribarang"];
//     $nkategoribarang = strtolower(htmlspecialchars($_POST["namakategoribarang"]));


//     $query = "UPDATE kategoribarang SET
//                 namakategoribarang = '$nkategoribarang'
//         WHERE id = $idkategoribarang
//     ";
//     $masuk_data = mysqli_query($conn, $query);
//     if ($masuk_data) {
//         echo "<script >
//             alert('edit berhasil');
//                 document.location.href = 'kategori-barang';
//             </script>";
//         //echo 3;
//     } else {
//         echo "<script>
//                 alert('gagal');
//                 document.location.href = 'kategori-barang';
//             </script>";
//         //echo 1;
//     }
// }
