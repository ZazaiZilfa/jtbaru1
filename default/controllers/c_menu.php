<?php
$kodemenu = query("SELECT * FROM user_menu ORDER BY id ASC ");
$kodesub_menu = query("SELECT * FROM user_sub_menu ORDER BY id DESC ");


if (isset($_POST["updateproduk"])) {
    //var_dump($_POST);
    $idproduk = $_POST["idproduk"];
    $nproduk = strtolower(htmlspecialchars($_POST["namaproduk"]));
    $hargabeli = htmlspecialchars($_POST["hargabeli"]);
    $hargajual = htmlspecialchars($_POST["hargajual"]);
    
    $query = "UPDATE produk SET
                namaproduk = '$nproduk',
                harga = '$hargabeli',
                hargaj = '$hargajual'
        WHERE id = $idproduk
    ";
    $masuk_data = mysqli_query($conn, $query);
    if ($masuk_data) {
        echo "<script >
            alert('edit berhasil');
                document.location.href = 'produk';
            </script>";
        //echo 3;
    } else {
        echo "<script>
                alert('gagal');
                document.location.href = 'produk';
            </script>";
        //echo 1;
    }
}   