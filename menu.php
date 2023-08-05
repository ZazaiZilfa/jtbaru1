<?php
session_start();

require 'include/fungsi.php';
require 'include/header.php';
// require 'include/vendor_css.php';

// if ($_SESSION['jabatan'] == 'JAB005' || $_SESSION['jabatan'] == 'JAB006') {
//     header("location:sales/index");
// } elseif ($_SESSION['jabatan'] == 'JAB011' || $_SESSION['jabatan'] == 'JAB012') {
//     header("location:store/index");
// }

if (!isset($_SESSION['email'])) {
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $url = "https://";
    } elseif (isset($_SERVER['HTTP']) && $_SERVER['HTTPS'] === 'off') {
        $url = "http://";
    } else {
        $url = "localhost";
    }

    // Append the host(domain name, ip) to the URL.   
    $url .= $_SERVER['HTTP_HOST'];

    // Append the requested resource location to the URL   
    $url .= $_SERVER['REQUEST_URI'];

    header("location:./index?redirect=" . $url); // jika belum login, maka dikembalikan ke index
    exit;
} else {
    require 'controllers/c_sidebar.php';

    $user = query("SELECT * FROM admin WHERE email = '" . $_SESSION['email'] . "'")[0];
    $email = $user["email"];
    $username = $user["username"];

    mysqli_query($conn, "UPDATE admin SET last_active = now() + interval 7 hour WHERE email = '$email'");
}
?>
<style>
.img-menu {
    width: inherit;
    max-width: 110px;
    height: inherit;
    max-height: 110px;
    object-fit: contain;
    object-position: center;
}
</style>

<body class="loading authentication-bg authentication-bg-pattern">

    <div class="account-pages my-5">
        <div class="container">

            <div class="row justify-content-center">
                <div class="w-100">
                    <div class="text-center">
                        <a href="index.html">
                            <img src="assets/images/logoBP.png" alt="" height="50" class="mx-auto">
                        </a>
                        <p class="text-muted mt-2 mb-4"></p>
                    </div>
                    <div class="row">
                        <?php foreach ($kodeusermenu as $row) : ?>
                        <div class="col-md-6 col-xl-3">
                            <!-- Simple card -->
                            <div class="card">
                                <div class="card-body pb-2">
                                    <h4 class="card-title text-center"><?= $row['menu']; ?></h4>
                                </div>
                                <a href="<?= $row['url']; ?>/index" class="d-flex justify-content-center pb-3">
                                    <img class="w-100 img-menu text-center"
                                        src="assets/images/menu/<?= $row['gambar']; ?>" alt="<?= $row['menu']; ?>">
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php
                        if ($_SESSION['userlevel'] == 0) :
                            foreach ($kodeusermenu2 as $row) : ?>
                        <div class="col-md-6 col-xl-3">
                            <!-- Simple card -->
                            <div class="card">
                                <div class="card-body pb-2">
                                    <h4 class="card-title text-center"><?= $row['menu']; ?></h4>
                                </div>
                                <a href="<?= $row['url']; ?>/index" class="d-flex justify-content-center pb-3">
                                    <img class="w-100 img-menu text-center"
                                        src="assets/images/menu/<?= $row['gambar']; ?>" alt="<?= $row['menu']; ?>">
                                </a>
                            </div>
                        </div>
                        <?php
                            endforeach;
                        endif; ?>
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <?php
    require 'include/vendor_script.php';
    ?>

    <script>
    $(document).ready(function() {
        console.log('script executed')
    });
    </script>
    <?php
    require 'include/footer_main.php';
    ?>