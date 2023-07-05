<?php
session_start();
require '.././include/fungsi.php';

$_SESSION = [];
session_unset();
session_destroy();
header("location: ../index.php");
