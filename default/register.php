<?php
session_start();

if (isset($_SESSION["email"])) {
    header("location: datamaster");
    exit;
}
require 'include/fungsi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Register & Signup | Adminto - Responsive Admin Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico">


    <!-- Plugins css-->
    <link href="../assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="../assets/css/config/default/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="../assets/css/config/default/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="../assets/css/config/default/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled="disabled" />
    <link href="../assets/css/config/default/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled="disabled" />

    <!-- icons -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />

</head>

<body class="loading authentication-bg authentication-bg-pattern">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="text-center">
                        <a href="index.html">
                            <img src="../assets/images/logo-dark.png" alt="" height="22" class="mx-auto">
                        </a>
                        <p class="text-muted mt-2 mb-4">Responsive Admin Dashboard</p>
                    </div>
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center mb-4">
                                <h4 class="text-uppercase mt-0">Register</h4>
                            </div>

                            <form id="add-user" method="post">

                                <div class="mb-3">
                                    <label for="name" class="form-label">Username</label>
                                    <input class="form-control" type="text" id="name" name="name" placeholder="Enter your name">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input class="form-control" type="email" name="email" id="emailAddress" required placeholder="Enter your email">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input class="form-control" type="password" required id="password" name="password" placeholder="Enter your password">
                                    <input type="hidden" id="outlet" name="outlet" value="<?= $company['kodeoutlet']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Choose Jabatan</label>
                                    <select class="form-control" name="role_id" id="role_id">
                                        <option>User Level</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Bos</option>
                                        <option value="3">Administratif</option>
                                        <option value="4">Kepala Proyek</option>
                                        <option value="5">Kepala Maintenance</option>
                                        <option value="6">Staff Proyek</option>
                                        <option value="7">Staff Maintenance</option>
                                    </select>
                                </div>
                                <div class="mb-3 text-center d-grid">
                                    <input type="hidden" name="tambah-user">
                                    <button class="btn btn-primary" type="submit" id="tombol-simpan"> Sign Up </button>
                                </div>

                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">Already have account? <a href="index.php" class="text-dark ms-1"><b>Sign In</b></a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- Vendor js -->
    <script src="../assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="../assets/js/app.min.js"></script>

    <!-- Sweet Alerts js -->
    <script src="../assets/libs/sweetalert2/sweetalert2.all.min.js"></script>

    <!-- Sweet alert init js-->
    <script src="../assets/js/pages/sweet-alerts.init.js"></script>


</body>

</html>
<script>
    $(document).ready(function() {
        // tambah data
        $('#tombol-simpan').click(function(e) {
            e.preventDefault();
            var dataform = $('#add-user')[0];
            var data = new FormData(dataform);
            var name = $('#name').val();
            var emailAddress = $('#emailAddress').val();
            var outlet = $('#kodeoutlet').val();
            var password = $('#password').val();
            var role_id = $('#role_id').val();
            //alert(ngambar)
            if (name == "") {
                swal.fire("Username belum di isi!", "", "error")
            } else if (emailAddress == "") {
                swal.fire("Email belum di isi!", "", "error")
            } else if (outlet == "") {
                swal.fire("Outlet kosong!", "", "error")
            } else if (role_id == "user level") {
                swal.fire("jabatan belum di isi!", "", "error")
            } else {
                $.ajax({
                    url: 'models/reg.php',
                    type: 'post',
                    data: data,
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        // $('.spinn').show();
                        $('.rowspin').css('display', 'flex');
                    },
                    success: function(hasil) {
                        // alert(hasil);
                        $('.spinn').hide();
                        console.log(hasil);
                        //sukses
                        if (hasil == 1) {
                            swal.fire("Email sudah terdaftar", "", "error")
                        } else if (hasil == 2) {
                            swal.fire("Input Gagal!", "", "error")
                        } else if (hasil == 3) {
                            swal.fire({
                                    title: "Input Berhasil!",
                                    type: "success",
                                    //text: "I will close in 2 seconds.",
                                    timer: 1000,
                                    showConfirmButton: !1
                                })
                                .then(function() {
                                    location.reload();
                                    document.location.href = 'index.php';
                                })
                        } else if (hasil == 4) {
                            swal.fire("Username sudah terdaftar", "", "error")

                        }
                    }
                });
            }
        })
        // akhir tambah data
    })
</script>