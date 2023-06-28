<?php
		
    $proyek = query("SELECT * FROM proyekjt WHERE year(tanggalpjt) = '$y' ORDER BY id DESC");
    
 ?>