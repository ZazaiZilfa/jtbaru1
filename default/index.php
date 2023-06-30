<?php
session_start();

if (isset($_SESSION["email"])) {
    header("location: ../datamaster");
    exit;
}
require '../include/fungsi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Log In | Adminto - Responsive Admin Dashboard Template</title>
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

    <div class="account-pages my-5">
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
                                <h4 class="text-uppercase mt-0">Sign In</h4>
                            </div>

                            <form id="formmasuk" action="">
                                <input type="hidden" id="login" name="login" value="login">
                                <input type="hidden" id="kodeoutlet" name="kodeoutlet" value="<?php echo $company['kodeoutlet']; ?>">
                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email address</label>
                                    <input class="form-control" type="email" required autofocus autocomplete="username" id="email" name="email" placeholder="Enter your email">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input class="form-control" type="password" required id="password" name="password" placeholder="Enter your password">
                                </div>

                                <div class="mb-3">

                                </div>

                                <div class="mb-3 d-grid text-center">
                                    <button class="btn btn-primary" type="submit" id="tombol-simpan" name="tombol-simpan"> Log In </button>
                                </div>
                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <!-- <p> <a href="pages-recoverpw.html" class="text-muted ms-1"><i class="fa fa-lock me-1"></i>Forgot your password?</a></p> -->
                            <p class="text-muted">Don't have an account? <a href="register.php" class="text-dark ms-1"><b>Sign Up</b></a></p>
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
        //     document.querySelector("#passwordToogle").addEventListener('click', () => {
        //         const password = document.querySelector("#password");
        //         const pwIcon = document.querySelector("#pwIcon");

        //         if (password.type === "password") {
        //             password.type = "text";
        //             pwIcon.className = "fas fa-eye input-group-text";
        //         } else {
        //             password.type = "password";
        //             pwIcon.className = "fas fa-eye-slash input-group-text";
        //         }
        //     })

        $('#tombol-simpan').click(function(e) {
            e.preventDefault();
            var dataform = $('#formmasuk')[0];
            var data = new FormData(dataform);

            //var input_foto = $('#input_foto').val();
            var login = $('#login').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var kodeoutlet = $('#kodeoutlet').val();

            if (email == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Email belum diisi !'
                })
            } else if (password == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Password belum diisi !'
                })
            } else {
                $.ajax({
                    url: '../models/login.php',
                    type: 'post',
                    data: data,
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(hasil) {
                        //sukses
                        if (hasil == 1) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal...',
                                text: 'Email Belum terdaftar'
                            });

                        } else if (hasil == 2) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal...',
                                text: 'Password Salah'
                            });
                        } else if (hasil == 3) {
                            // console.log(hasil);
                            Swal.fire({
                                    position: "top-end",
                                    type: "success",
                                    title: "Login Berhasil",
                                    showConfirmButton: !1,
                                    timer: 1000
                                })
                                .then(function() {
                                    location.reload('');
                                    // setTimeout(location.reload.bind(location), 800);
                                    // document.location.href = 'administrator';
                                });
                        } else if (hasil == 4) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal...',
                                text: 'Akun anda tidak terdaftar pada Outlet ini'
                            });
                        }
                    }
                });
            }
        })
    });
</script>