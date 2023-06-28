<?php

$kodesubkatbarang = query("SELECT * FROM subkatbarang01 ORDER BY id DESC ");
$kodekategoribarang = query("SELECT * FROM kategoribarang02 ORDER BY id ASC ");
if (isset($_POST["updatesubkatbarang"])) {
    //var_dump($_POST);
    $idsubkatbarang = $_POST["idsubkatbarang"];
    $nsubkatbarang = strtolower(htmlspecialchars($_POST["namasubkatbarang"]));


    $query = "UPDATE subkatbarang SET
                namasubkatbarang = '$nsubkatbarang'
        WHERE id = $idsubkatbarang
    ";
    $masuk_data = mysqli_query($conn, $query);
    if ($masuk_data) {
        echo "<script >
            alert('edit berhasil');
                document.location.href = 'subkategori-barang';
            </script>";
        //echo 3;
    } else {
        echo "<script>
                alert('gagal');
                document.location.href = 'subkategori-barang';
            </script>";
        //echo 1;
    }
}
