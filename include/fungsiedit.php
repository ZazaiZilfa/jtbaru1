<?php 
//fungsi input proposal
function realisasi(){

	global $conn;
	
    $id = htmlspecialchars($_POST["id"]);

    $tl = htmlspecialchars($_POST["tanggal"]);
    $ttl = $tl;
    $tatl = substr($ttl,3,2);
    $bul = substr($ttl,0,2);
    $tahtl = substr($ttl,6,4);
    $tang = $tahtl.'-'.$bul.'-'.$tatl;
    $tanggalpjt = date('Y-m-d',strtotime($tang));

    date_default_timezone_set('Asia/Jakarta'); $date = new DateTime();
    $butl = substr($date->format('Y-m-d'),5,2);
    $thl = substr($date->format('Y-m-d'),2,2);
    $kodeproyek = "PJT";
    $t = substr($ttl,8,2);
    $kodebulan = $t.$bul;

    $kas = query("SELECT * FROM proyekjt WHERE kodeproyek ='PJT' AND month(tanggalpjt) ='$bul' ORDER BY id DESC LIMIT 1")[0];
    if ($kas['kodebulan']!=$thl.$butl) {
        $newkodetr = "001";

    }else{
        $lastkode = query("SELECT * FROM proyekjt WHERE kodeproyek ='PJT' AND month(tanggalpjt) ='$bul' ORDER BY id DESC LIMIT 1")[0];
        $lk =$lastkode['kodetr'] ;
        $noUrut = (int) $lastkode['kodetr'];
        $noUrut++;    
        $newkodetr = sprintf("%03s", $noUrut);
    }

    

    //$novoucher = htmlspecialchars($_POST["nv"]);
    $namaklien = htmlspecialchars($_POST["namaklien"]);
    $outlet = htmlspecialchars($_POST["outlet"]);
    $tempat = htmlspecialchars($_POST["tempat"]);
    $pekerjaan = htmlspecialchars($_POST["pekerjaan"]);
    $nilaiproyek = htmlspecialchars($_POST["nilaiproyek"]);
    //$saldo = 0;
    
    //query edit data
    $query = "UPDATE proyekjt 
               SET  tanggalpjt = '$tanggalpjt',
                    kodeproyek = '$kodeproyek',
                    kodebulan = '$kodebulan',
                    kodetr = '$newkodetr',
                    namaklien = '$namaklien',
                    outlet = '$outlet',
                    tempat = '$tempat',
                    pekerjaan = '$pekerjaan',
                    nilaiproyek = '$nilaiproyek'                
                WHERE id = $id
            ";
    mysqli_query($conn, $query);
    
    
}

//fungsi edit proposal
function editproposal(){

    global $conn;

    $id = htmlspecialchars($_POST["id"]);
    $namaklien = htmlspecialchars($_POST["namaklien"]);
    $outlet = htmlspecialchars($_POST["outlet"]);
    $tempat = htmlspecialchars($_POST["tempat"]);
    $pekerjaan = htmlspecialchars($_POST["pekerjaan"]);
    $nilaiproyek = htmlspecialchars($_POST["nilaiproyek"]);
    

    //query edit data
    $query = "UPDATE proyekjt 
               SET  
                    namaklien = '$namaklien',
                    outlet = '$outlet',
                    tempat = '$tempat',
                    pekerjaan = '$pekerjaan',
                    nilaiproyek = '$nilaiproyek'                
                WHERE id = $id
            ";
    mysqli_query($conn, $query);
   
}


?>
