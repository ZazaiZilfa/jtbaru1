<?php
if ($_SESSION['role_id'] != "0") {
    if ($_SESSION['outlet'] == "OUT000" || $_SESSION['outlet'] == "OUT001") {
        if ($_SESSION['role_id'] = "1") {
            $kodeusermenu = query("SELECT * FROM user_menu WHERE id<8 ORDER BY urut ASC ");
        } else if ($_SESSION['role_id'] = "2") {
            $kodeusermenu = query("SELECT * FROM user_menu WHERE id=1 OR id=2 OR id=3 OR id=4 OR id=7 OR id=9 OR id=10 ORDER BY urut ASC ");
        } else if ($_SESSION['role_id'] = "3") {
            $kodeusermenu = query("SELECT * FROM user_menu WHERE id=1 OR id=2 OR id=3 OR id=4 OR id=7 OR id=9 OR id=10 ORDER BY urut ASC ");
        } else if ($_SESSION['role_id'] = "4") {
            $kodeusermenu = query("SELECT * FROM user_menu WHERE id=2 OR id=3 OR id=7 ORDER BY urut ASC ");
        }
    } else if ($_SESSION['outlet'] == "out002") {
        if ($_SESSION['role_id'] = "1") {
            $kodeusermenu = query("SELECT * FROM user_menu WHERE id NOT IN (6,8) ORDER BY urut ASC ");
        } else if ($_SESSION['role_id'] = "2") {
            $kodeusermenu = query("SELECT * FROM user_menu WHERE id=1 OR id=2 OR id=3 OR id=4 OR id=7 OR id=9 OR id=10 ORDER BY urut ASC ");
        } else if ($_SESSION['role_id'] = "3") {
            $kodeusermenu = query("SELECT * FROM user_menu WHERE id=1 OR id=2 OR id=3 OR id=4 OR id=7 OR id=9 OR id=10 ORDER BY urut ASC ");
        } else if ($_SESSION['role_id'] = "4") {
            $kodeusermenu = query("SELECT * FROM user_menu WHERE id=2 OR id=3 OR id=7 ORDER BY urut ASC ");
        }
    } else {
        if ($_SESSION['role_id'] = "1") {
            $kodeusermenu = query("SELECT * FROM user_menu WHERE id NOT IN (3,6,8) ORDER BY urut ASC ");
        } else if ($_SESSION['role_id'] = "2") {
            $kodeusermenu = query("SELECT * FROM user_menu WHERE id=1 OR id=2 OR id=3 OR id=4 OR id=7 OR id=9 OR id=10 ORDER BY urut ASC ");
        } else if ($_SESSION['role_id'] = "3") {
            $kodeusermenu = query("SELECT * FROM user_menu WHERE id NOT IN (3,6) ORDER BY urut ASC ");
            $kodeusermenu = query("SELECT * FROM user_menu WHERE id=1 OR id=2 OR id=3 OR id=4 OR id=7 OR id=9 OR id=10 ORDER BY urut ASC ");
        } else if ($_SESSION['role_id'] = "4") {
            $kodeusermenu = query("SELECT * FROM user_menu WHERE id=2 OR id=3 OR id=4  ORDER BY urut ASC ");
        }
    }
} else {
    $kodeusermenu = query("SELECT * FROM user_menu WHERE urut NOT IN (9,10) ORDER BY urut ASC");
}

if ($_SESSION['role_id'] != 0) {
} else {
    $kodeusermenu2 = query("SELECT * FROM user_menu WHERE urut=9 OR urut=10  ORDER BY urut ASC");
}