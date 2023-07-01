<?php

require '../../include/fungsi.php';
require '../../include/fungsi_indotgl.php';


if (isset($_POST["updatemenu"])) {
    $id = $_POST['updatemenu'];
    $menu = $_POST['umenu'];
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
} else if (isset($_POST['update-submenu'])) {
    $nama = $_POST['umenu'];
    $url = $_POST['uurl'];
    $uaktif = $_POST['uaktif'];
    $id = $_POST['update-submenu'];

    $query = "UPDATE user_sub_menu SET title = '$nama', url = '$url', is_active = '$uaktif' WHERE id ='$id'";
    $masuk_data = mysqli_query($conn, $query);
    if ($masuk_data) {
        echo 2;
    } else {
        echo 1;
    }
} else if (isset($_POST['update-user'])) {
    $name = $_POST['uname'];
    $email = $_POST['uemail'];
    $role_id = $_POST['urole_id'];
    $uaktif = $_POST['uaktif'];
    $id = $_POST['update-user'];

    $query = "UPDATE user SET name = '$name', email = '$email', role_id = '$role_id', is_active = '$uaktif' WHERE id ='$id'";
    $masuk_data = mysqli_query($conn, $query);
    if ($masuk_data) {
        echo 2;
    } else {
        echo 1;
    }
}
