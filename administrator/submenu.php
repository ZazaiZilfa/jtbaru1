<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("location:../index"); // jika belum login, maka dikembalikan ke index
    exit;
}
require '../include/fungsi.php';
require '../include/fungsi_rupiah.php';
require '../include/fungsi_indotgl.php';
require 'c_admin/c_submenu.php';
$bagian = "Administrator";
$juhal = "Sub Menu";

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
                                    <h4 class="mb-3 header-title">Input Sub Menu Sidebar</h4>

                                    <form class="form-horizontal" id="formmenu">
                                        <input type="hidden" name="inputsubmenu">
                                        <div class="row mb-2">

                                            <label class="col-4 col-xl-5 col-form-label">Menu Parent</label>
                                            <div class="col-8 col-xl-7">

                                                <select class="form-control select2" id="nparent" name="mparent">
                                                    <option>Pilih Kategori</option>
                                                    <?php foreach ($menu as $row) : ?>
                                                        <option value="<?= $row["id"] ?>">
                                                            <?= ucwords($row["menu"]) ?></option>
                                                    <?php endforeach; ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-4 col-xl-5 col-form-label">Nama Menu</label>
                                            <div class="col-8 col-xl-7">
                                                <input autofocus type="text" class="form-control" required name="nmenu" id="nmenu" placeholder="Masukkan Nama menu"></input>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-4 col-xl-5 col-form-label">URL</label>
                                            <div class="col-8 col-xl-7">
                                                <input type="text" class="form-control" required name="nurl" id="nurl" placeholder="Masukkan URL"></input>
                                            </div>
                                        </div>



                                        <div class="justify-content-end row">
                                            <div class="col-8 col-xl-8">
                                                <button type="submit" class="btn btn-info waves-effect waves-light" name="tombol-menu" id="tombol-menu">Input Menu</button>
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
                                    <h4 class="mt-0 header-title">Daftar sub menu sidebar</h4>


                                    <table id="responsive-datatable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Menu Parent</th>
                                                <th>Nama Sub Menu</th>
                                                <th>url</th>
                                                <th>Status</th>
                                                <th>Action </th>
                                            </tr>
                                        </thead>

                                        <?php $i = 1; ?>
                                        <tbody>
                                            <?php foreach ($submenu as $sm) : ?>
                                                <tr>
                                                    <td width="2%" ;><?= $i ?></td>
                                                    <td><?= $sm["menu"] ?></td>
                                                    <td><?= $sm["title"] ?></td>
                                                    <td><?= $sm["url"] ?></td>
                                                    <td>
                                                        <?php
                                                        if ($sm["is_active"] != 1) {
                                                            echo "Inactive";
                                                        } else {
                                                            echo "Active";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a class="badge btn-success edit-row rounded-pill waves-effect waves-light tombol-edit" data-bs-toggle="modal" data-bs-target="#modaledit" data-id="<?= $sm['id']; ?>" data-menu="<?= $sm['title']; ?>" data-url="<?= $sm['url']; ?>" data-active="<?= $sm['is_active']; ?>" id=""><i class="ti-pencil"></i></a>

                                                        |

                                                        <input type="hidden" class="delete_id_value" value="<?= $sm["id"] ?>">
                                                        <a class="badge btn-danger remove-row rounded-pill waves-effect waves-light tombol-hapus" data-id="<?= $sm['id'] ?>">
                                                            <i class="fe-trash-2"></i>
                                                        </a>
                                                        <!-- <a class="on-default remove-row badge badge-danger tombol-deletesupplier"><i class="fa fa-trash-o"></i></a> -->

                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            <?php endforeach;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->


                </div> <!-- container-fluid -->

            </div> <!-- content -->

            <?php require "../include/rightsidebar.php"; ?>
            <div id="modaledit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Sub Menu</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formupdate">
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" class="id" name="update-submenu">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Menu</label>
                                                <input type="text" class="menu form-control" id="umenu" name="umenu">
                                            </div>
                                        </div>
                                        <div class=" col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Url</label>
                                                <input type="text" class="url form-control" id="uurl" name="uurl">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class=" col-md-6">
                                            <div class="mb-3">
                                                <label for="uaktif" class="control-label">Status</label>
                                                <select id="uaktif" name="uaktif" class="form-control select2 uaktif">
                                                    <option value="0">Inactive</option>
                                                    <option value="1">Active</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="tombol-update">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal -->
            <?php require "../include/footer.php"; ?>


</body>

</html>
<script>
    $(document).ready(function() {
        $('#tombol-menu').click(function(e) {
            e.preventDefault();
            var dataform = $('#formmenu')[0];
            var data = new FormData(dataform);
            // console.log(data);
            var nparent = $('#nparent').val();
            var nmenu = $('#nmenu').val();
            var nurl = $('#nurl').val();


            if (nmenu == "") {
                swal.fire("Nama menu belum di isi!", "", "error")
            } else if (nparent == "Pilih Kategori") {
                swal.fire("Menu Parent belum di pilih!", "", "error")
            } else if (nurl == "") {
                swal.fire("URL belum di isi!", "", "error")

            } else {
                $.ajax({
                    url: 'm_admin/input.php',
                    type: 'post',
                    data: data,
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        $('.spinn').show();
                    },
                    success: function(hasil) {
                        // alert(hasil);
                        // console.log('ok');
                        //sukses
                        if (hasil == 1) {
                            swal.fire("Nama menu sudah ada!", "", "error")
                        } else if (hasil == 2) {
                            swal.fire("URL Sudah ada ", "", "error")
                        } else if (hasil == 3) {
                            swal.fire("Input Eror, Coba Lagi ", "", "error")
                        } else if (hasil == 4) {
                            swal.fire({
                                title: "Update Berhasil!",
                                type: "success",
                                //text: "I will close in 2 seconds.",
                                timer: 2000,
                                showConfirmButton: false
                            })
                            setTimeout(location.reload.bind(location), 800);

                        }
                    }
                });
            }
        })

        //$('.tombol-edit').on('click', function() {
        $('#responsive-datatable').on('click', '.tombol-edit', function() {

            const id = $(this).data('id');
            const menu = $(this).data('menu');
            const url = $(this).data('url');
            const aktif = $(this).data('active');

            $('.id').val(id);
            $('.menu').val(menu);
            $('.url').val(url);
            $('.uaktif').val(aktif).trigger('change');

            $('#modaledit').modal('show');
        });

        $('#tombol-update').click(function(e) {


            e.preventDefault();
            var dataform = $('#formupdate')[0];
            var data = new FormData(dataform);
            // console.log(data);

            var umenu = $('#umenu').val();
            var uurl = $('#uurl').val();
            var uaktif = $('#uaktif').val();

            // console.log(umenu);
            // console.log(uurl);

            if (umenu == "") {
                swal.fire("Nama menu belum di isi!", "", "error")
            } else if (uurl == "") {
                swal.fire("URL belum di isi!", "", "error")
            } else if (uaktif == "") {
                swal.fire("Status belum di isi!", "", "error")
            } else {
                $.ajax({
                    url: 'm_admin/edit.php',
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
                        $('.spinn').hide();
                        // alert(hasil);
                        console.log(hasil);
                        //sukses
                        if (hasil == 1) {
                            swal.fire("Tidak Berhasil ditambahkan!", "", "error")
                        } else if (hasil == 2) {
                            swal.fire({
                                title: "Update Berhasil!",
                                type: "success",
                                //text: "I will close in 2 seconds.",
                                timer: 2000,
                                showConfirmButton: false
                            })
                            setTimeout(location.reload.bind(location), 800);

                        }
                    }
                });
            }




        })

        $('#responsive-datatable').on('click', '.tombol-hapus', function(e) {

            // console.log('ok');
            const tabel = 'user_sub_menu';
            const id = $(this).data('id');

            e.preventDefault();
            const href = $(this).attr('href');
            swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Data Anda Akan Terhapus!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Tidak!",
                closeOnConfirm: false,
                closeOnCancel: false,
                beforeSend: function() {
                    $('.spinn').show();
                },
            }).then((isConfirm) => {
                if (isConfirm.isConfirmed) {
                    $.ajax({
                        url: 'm_admin/delete.php',
                        type: 'post',
                        data: {
                            'tabel': tabel,
                            'delete_id': id
                        },
                        beforeSend: function() {
                            $('.spinn').show();
                        },
                        success: function(hasil) {
                            // alert(hasil);
                            console.log(hasil);
                            //sukses
                            if (hasil == 2) {

                            } else if (hasil == 3) {
                                swal.fire({
                                    title: "hapus Berhasil!",
                                    type: "success",
                                    //text: "I will close in 2 seconds.",
                                    timer: 22000,
                                    showConfirmButton: false
                                })
                                setTimeout(location.reload.bind(location), 800);

                            }
                        }
                    });
                } else {
                    swal.fire("Cancelled", "", "error");
                }
            });
        })

    })
</script>