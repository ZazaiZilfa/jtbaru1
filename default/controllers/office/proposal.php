<?php 
if( isset($_POST["tp"]) ) {
    $tampilkanbulan = $_POST["bulan"];
    $tahun = $_POST["tahun"];
    

    if ($tampilkanbulan==="Bulan") {
        header("location:proyek");
    }

    $proposal = query("SELECT * FROM proyekjt WHERE month(tanggalpro) ='$tampilkanbulan' AND year(tanggalpro) ='$tahun' ORDER BY id DESC");
}else{
	$proposal = query("SELECT * FROM proyekjt WHERE noproyek = '' ORDER BY id DESC");
	$kodemarketingg = query("SELECT * FROM marketing ORDER BY id DESC ");
}

