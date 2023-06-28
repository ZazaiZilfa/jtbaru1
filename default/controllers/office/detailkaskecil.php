<?php 
// if (!isset($_GET["id"])) {
//     header("location:kaskecil");
//     exit;
// }
$idd = $_GET["id"];
$kaskecil = query("SELECT * FROM kas WHERE id = $idd") [0];
$nv=$kaskecil['kodekas'].$kaskecil['kodebulan'].$kaskecil['kodetr'];
$dbon = query("SELECT * FROM detailbon WHERE novoucher='$nv' ORDER BY id DESC");


$jumlahrb = "SELECT SUM(jumlah) AS total_rb FROM detailbon WHERE novoucher='$nv' "; //perintah untuk menjumlahkan
$hasilrb = mysqli_query($conn, $jumlahrb) ;//melakukan query dengan varibel $jumlahkan
$rb = mysqli_fetch_array($hasilrb); //menyimpan hasil query ke variabel $t
$totalrb = $rb['total_rb'];

//cek apakah tombol input sudah di tekan atau belum
if( isset($_POST["pembelian"]) ) {
    
    
    $tanggal = $kaskecil['tanggal'];
    $novoucher = $kaskecil['kodekas'].$kaskecil['kodebulan'].$kaskecil['kodetr'];
    
    $toko = htmlspecialchars($_POST["toko"]);
    $keterangan = htmlspecialchars($_POST["keterangan"]);
    $jumlah = htmlspecialchars($_POST["jumlah"]);
    
    //query insert data
    $query = "INSERT INTO detailbon
                VALUES 
                ('','$tanggal','$novoucher','$toko','$keterangan','$jumlah')
            ";
    mysqli_query($conn, $query);

    
    
    //cek apakh data berhasil di tambahkan
    if( mysqli_affected_rows($conn) > 0 ) {
        echo "
            <script>
                alert('Input Rincian Bon berhasil');
                document.location.href = 'detailkaskecil.php?id=$idd';                
            </script>
            ";
  
        
    } else {
        echo "
            <script>
                alert('Input Rincian Bon Gagal');                
                document.location.href = 'detailkaskecil.php?id=$idd';                
            </script>
            ";
    }

}