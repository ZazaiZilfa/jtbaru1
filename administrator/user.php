<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("location:../index"); // jika belum login, maka dikembalikan ke index
    exit;
}
require '../include/fungsi.php';
require '../include/fungsi_rupiah.php';
require '../include/fungsi_indotgl.php';

$kodeuser = query("SELECT * FROM user ORDER BY id ASC ");

$bagian = "Administtrator";
$juhal = "User";
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
                    <!-- terima msg -->
                    <?php if (isset($_SESSION['msg'])) : ?>
                        <div id="msg" data-msg="<?= $_SESSION["msg"] ?>"></div>
                        <?php unset($_SESSION['msg']); ?>
                    <?php endif ?>
                    <!-- akhir terima msg -->

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mb-3 header-title">Input Sub Menu Sidebar</h4>

                                    <form class="form-horizontal" id="add-user" method="post">


                                        <div class="row mb-2">
                                            <label class="col-4 col-xl-5 col-form-label">Nama</label>
                                            <div class="col-8 col-xl-7">
                                                <input autofocus type="text" class="form-control" required id="name" name="name" placeholder="Enter your name"></input>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-4 col-xl-5 col-form-label">Email address</label>
                                            <div class="col-8 col-xl-7">
                                                <input type="email" class="form-control" required name="email" id="emailAddress" required placeholder="Enter your email"></input>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-4 col-xl-5 col-form-label">Password</label>
                                            <div class="col-8 col-xl-7">
                                                <input class="form-control" type="password" required id="password" name="password" placeholder="Enter password">
                                                <input type="hidden" id="outlet" name="outlet" value="<?= $company['kodeoutlet']; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-2">

                                            <label class="col-4 col-xl-5 col-form-label">Choose Jabatan</label>
                                            <div class="col-8 col-xl-7">
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
                                        </div>

                                        <div class="justify-content-end row">
                                            <div class="col-8 col-xl-8">
                                                <input type="hidden" name="tambah-user">
                                                <button type="submit" class="btn btn-info waves-effect waves-light" name="tombol-simpan" id="tombol-simpan">Input User</button>
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
                                    <h4 class="mt-0 header-title">Daftar menu sideabar</h4>


                                    <table id="responsive-datatable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Role_id</th>
                                                <th>Status</th>
                                                <th>Action </th>
                                            </tr>
                                        </thead>

                                        <?php $i = 1; ?>
                                        <tbody>
                                            <?php foreach ($kodeuser as $row) : ?>
                                                <tr>
                                                    <td width="2%" ;><?= $i ?></td>
                                                    <td><?= $row["name"] ?></td>
                                                    <td><?= $row["email"] ?></td>
                                                    <td><?= $row["role_id"] ?></td>
                                                    <td>
                                                        <?php
                                                        if ($row["is_active"] != 1) {
                                                            echo "Inactive";
                                                        } else {
                                                            echo "Active";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a class="badge btn-success edit-row rounded-pill waves-effect waves-light tombol-edit" data-bs-toggle="modal" data-bs-target="#modaledit" data-id="<?= $row['id']; ?>" data-name="<?= $row['name']; ?>" data-email="<?= $row['email']; ?>" data-roleid="<?= $row['role_id']; ?>" data-active="<?= $row['is_active']; ?>" id=""><i class="ti-pencil"></i></a>

                                                        |

                                                        <input type="hidden" class="delete_id_value" value="<?= $row["id"] ?>">
                                                        <a class="badge btn-danger remove-row rounded-pill waves-effect waves-light tombol-hapus" data-id="<?= $row['id'] ?>">
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
                            <h4 class="modal-title">Edit User</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formupdate">
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" class="id" name="update-user">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Nama</label>
                                                <input type="text" class="name form-control" id="uname" name="uname">
                                            </div>
                                        </div>
                                        <div class=" col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">email</label>
                                                <input type="text" class="email form-control" id="uemail" name="uemail">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Choose Jabatan</label>
                                                <select class="form-control select2 urole_id" name="urole_id" id="urole_id">
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
                                        </div>

                                        <div class=" col-md-6">
                                            <div class="mb-3">
                                                <label for="uaktif" class="form-label">Status</label>
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
                    url: 'm_admin/input.php',
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
                                })
                        } else if (hasil == 4) {
                            swal.fire("Username sudah terdaftar", "", "error")

                        }
                    }
                });
            }
        })
        // akhir tambah data

        $('#responsive-datatable').on('click', '.tombol-edit', function() {

            const id = $(this).data('id');
            const name = $(this).data('name');
            const email = $(this).data('email');
            const role_id = $(this).data('roleid');
            const aktif = $(this).data('active');

            $('.id').val(id);
            $('.name').val(name);
            $('.email').val(email);
            $('.urole_id').val(role_id).trigger('change');
            $('.uaktif').val(aktif).trigger('change');

            $('#modaledit').modal('show');
        });

        $('#tombol-update').click(function(e) {


            e.preventDefault();
            var dataform = $('#formupdate')[0];
            var data = new FormData(dataform);
            // console.log(data);

            var uname = $('#uname').val();
            var uemail = $('#uemail').val();
            var urole_id = $('#urole_id').val();
            var uaktif = $('#uaktif').val();

            // console.log(umenu);
            // console.log(uurl);

            if (uname == "") {
                swal.fire("Nama belum di isi!", "", "error")
            } else if (uemail == "") {
                swal.fire("email belum di isi!", "", "error")
            } else if (urole_id == "") {
                swal.fire("jabatan belum di isi!", "", "error")
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
            const tabel = 'user';
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