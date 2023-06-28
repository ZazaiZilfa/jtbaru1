<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("location:../index"); // jika belum login, maka dikembalikan ke index
    exit;
}
require '../include/fungsi.php';
require '../include/fungsi_rupiah.php';
require '../include/fungsi_indotgl.php';

$kodeunit = query("SELECT * FROM tesaja ORDER BY id DESC ");



$bagian = "blank page";
$juhal = "tesswal";
?>

<!DOCTYPE html>
<html lang="en">

<?php require "../include/header.php"; ?>

<!-- body start -->

<body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": true}, "topbar": {"color": "light"}, "showRightSidebarOnPageLoad": true}'>

    <!-- Begin page -->
    <div id="wrapper">


        <?php require "../include/topbar.php"; ?>

        <?php require '../include/sidebar.php'; ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mb-3 header-title">Input Unit</h4>

                                    <form class="form-horizontal" id="formtes">
                                        <input type="hidden" value="tesunit" id="tesunit" name="tesunit">
                                        <div class="row mb-2">

                                            <label class="col-4 col-xl-4 col-form-label">Nama Unit</label>
                                            <div class="col-8 col-xl-8">
                                                <input type="text" class="form-control" required name="ntesit" id="ntesit" placeholder="Nama unit">
                                            </div>
                                        </div>


                                        <br> <br>

                                        <div class="justify-content-end row">
                                            <div class="col-8 col-xl-8">
                                                <button type="submit" class="btn btn-info waves-effect waves-light" name="tombol-tes" id="sa-custom-position">Input unit</button>
                                            </div>
                                        </div>
                                    </form>

                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div>
                        <!-- end col -->

                        <div class="col-8">
                            <div class="card">
                                <div class="card-body table-responsive ">
                                    <h4 class="mt-0 header-title">Daftar Unit</h4>


                                    <table id="responsive-datatable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>id</th>
                                                <th>Nama </th>
                                                <th>Action </th>
                                            </tr>
                                        </thead>

                                        <?php $i = 1; ?>
                                        <tbody>
                                            <?php foreach ($kodeunit as $row) : ?>
                                                <tr>
                                                    <td width="2%" ;><?= $i ?></td>
                                                    <td><?= $row["id"] ?></td>
                                                    <td><?= $row["nyoba"] ?></td>
                                                    <td>
                                                        <a class="badge btn-success  edit-row rounded-pill waves-effect waves-light tombol-edit" data-bs-toggle="modal" data-bs-target="#modaledit" data-id="<?= $row['id']; ?>" data-namaunit="<?= $row['namaunit']; ?>" id=""><i class="ti-pencil"></i></a>

                                                        <!-- <button type="button" class="btn btn-success edit-row rounded-pill waves-effect waves-light tombol-edit" data-norek="<?= $row['norek']; ?>" data-bank="<?= $row['kodebank']; ?>" data-id="<?= $row['kodesupplier']; ?>" data-nama="<?= $row['namasupplier']; ?>" data-nohp="<?= $row['nohp']; ?>" data-alamat="<?= $row['alamatsupplier']; ?>" data-ppn="<?= $row['ppn']; ?>" id=""><i class="fa fa-pencil" aria-hidden="true"></i></button> -->
                                                        <!-- <a class="on-default edit-row badge badge-success tombol-edit" data-norek="<?= $row['norek']; ?>" data-bank="<?= $row['kodebank']; ?>" data-id="<?= $row['kodesupplier']; ?>" data-nama="<?= $row['namasupplier']; ?>" data-nohp="<?= $row['nohp']; ?>" data-alamat="<?= $row['alamatsupplier']; ?>" data-ppn="<?= $row['ppn']; ?>" id=""><i class="fa fa-pencil"></i></a> -->
                                                        <?php if ($_SESSION['role_id'] == 1) : ?>
                                                            |
                                                            <input type="hidden" class="delete_id_value" value="<?= $row["id"] ?>">

                                                            <!-- <button type="button" class="btn btn-danger remove-row rounded-pill waves-effect waves-light  tombol-deletesupplier"><i class="fa fa-trash" aria-hidden="true"></i></button> -->
                                                            <a class="badge btn-danger remove-row rounded-pill waves-effect waves-light tombol-deleteunit">
                                                                <i class="fe-trash-2"></i>
                                                            </a>
                                                            <!-- <a class="on-default remove-row badge badge-danger tombol-deletesupplier"><i class="fa fa-trash-o"></i></a> -->
                                                        <?php endif ?>
                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- end row -->


                </div> <!-- container-fluid -->

            </div> <!-- content -->

            <?php require "../include/rightsidebar.php"; ?>

            <?php require "../include/footer.php"; ?>


</body>

</html>

<script>
    $(document).ready(function() {
        $('#formtes').submit(function(e) {

            e.preventDefault();
            var dataform = $('#formtes')[0];
            var data = new FormData(dataform);

            var ntesit = $('#tesit').val();

            if (ntesit == "") {
                swal("Nama Supplier belum di isi!", "", "error")
            } else {
                $.ajax({
                    url: '../models/input.php',
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
                            document.getElementById("sa-custom-position").addEventListener("click", function() {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "error",
                                    title: "Input Gagal",
                                    showConfirmButton: !1,
                                    timer: 1500
                                })
                            })
                        } else if (hasil == 2) {
                            document.getElementById("sa-custom-position").addEventListener("click", function() {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "erorr",
                                    title: "tanggal tidak sesuai",
                                    showConfirmButton: !1,
                                    timer: 1500
                                })
                            })
                        } else if (hasil == 3) {
                            document.getElementById("sa-custom-position").addEventListener("click", function() {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: "Input Berhasil!",
                                    showConfirmButton: !1,
                                    timer: 1500
                                })
                            })
                            location.reload();

                        } else if (hasil == 4) {
                            document.getElementById("sa-custom-position").addEventListener("click", function() {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "error",
                                    title: "Nama Supplier sudah terdaftar",
                                    showConfirmButton: !1,
                                    timer: 1500
                                })
                            })
                        }
                    }
                });
            }
        })
    })
    // document.getElementById("sa-custom-position").addEventListener("click", function() {
    //     Swal.fire({
    //         position: "top-end",
    //         icon: "success",
    //         title: "Your work has been saved",
    //         showConfirmButton: !1,
    //         timer: 1500
    //     })
    // })
</script>