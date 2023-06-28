<?php

require '../../include/fungsi.php';
require '../../include/fungsi_indotgl.php';


if (isset($_POST["updatemenu"])) {
    $id = $_POST['updatemenu'];
    $menu = $_POST['unama'];
    $url = $_POST['uurl'];
    $icon = $_POST['uicon'];

    // var_dump($url);
    $idmenu = query("SELECT id FROM user_menu WHERE id ='$id'")[0];
    $id = $idmenu['id'];

    $query = "UPDATE user_menu SET
                menu = '$menu',
                url = '$url',
                icon = '$icon'
        WHERE id = '$id'";

    $masuk_data = mysqli_query($conn, $query);
    if ($masuk_data) {
        echo 2;
    } else {
        echo 1;
    }
}
