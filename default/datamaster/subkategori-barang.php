<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("location:../index"); // jika belum login, maka dikembalikan ke index
    exit;
}
require '../include/fungsi.php';
require '../include/fungsi_rupiah.php';
require '../include/fungsi_indotgl.php';
require 'c_datamaster/c_subkategori-barang.php';
$bagian = "Data Master";
$juhal = "Sub Kategori Barang";
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
                                    <h4 class="mb-3 header-title">Input <?= $juhal ?></h4>

                                    <form class="form-horizontal" id="formsubkatbarang">
                                        <input type="hidden" value="inputsubkatbarang" id="inputsubkatbarang" name="inputsubkatbarang">
                                        <div class="row mb-2">
                                            <label class="col-4 col-xl-4 col-form-label">Kategori Barang</label>
                                            <div class="col-8 col-xl-8">
                                                <select class="form-select select2" name="nkategoribarang" id="nkategoribarang">
                                                    <?php foreach ($kodekategoribarang as $row) : ?>
                                                        <option value="<?= $row["kodekategoribarang"] ?>">
                                                            <?= ucwords($row["namakategoribarang"]) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">

                                            <label class="col-4 col-xl-4 col-form-label"><?= $juhal ?></label>
                                            <div class="col-8 col-xl-8">
                                                <input type="text" class="form-control" required name="nsubkatbarang" id="nsubkatbarang">
                                            </div>
                                        </div>

                                        <br>
                                        <div class="justify-content-end row">
                                            <div class="col-8 col-xl-8">
                                                <button type="submit" class="btn btn-info waves-effect waves-light" name="tombol-subkatbarang" id="tombol-subkatbarang">Input Sub Kategori</button>
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
                                    <h4 class="mt-0 header-title">Daftar <?= $juhal ?></h4>


                                    <table id="responsive-datatable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kategori Barang</th>
                                                <th>Kode Sub Kategori Barang</th>
                                                <th>Sub Kategori Barang</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>

                                        <?php $i = 1; ?>
                                        <tbody>
                                            <?php foreach ($kodesubkatbarang as $row) : ?>
                                                <tr>
                                                    <td width=" 2%" ;><?= $i ?></td>
                                                    <td>
                                                        <?php
                                                        $kodekategoribarang = $row["kodekategoribarang"];
                                                        $ka = "SELECT namakategoribarang FROM kategoribarang02 WHERE kodekategoribarang ='$kodekategoribarang'"; //perintah untuk menjumlahkan
                                                        $hasilka = mysqli_query($conn, $ka); //melakukan query dengan varibel $jumlahkan
                                                        $tampil = mysqli_fetch_array($hasilka); //menyimpan hasil query ke variabel $t
                                                        echo $tampilkode = $tampil['namakategoribarang'];
                                                        ?>
                                                    </td>
                                                    <td><?= $row["kodesubkatbarang"] ?></td>
                                                    <td><?= ucwords($row["namasubkatbarang"]) ?></td>
                                                    <td>
                                                        <a class="badge btn-success edit-row rounded-pill waves-effect waves-light tombol-edit" data-bs-toggle="modal" data-bs-target="#modaledit" data-nama="<?= $row["namasubkatbarang"] ?>" data-id="<?= $row["kodesubkatbarang"] ?>" id=""><i class=" ti-pencil"></i></a>


                                                        <?php
                                                        $iddel = $row["id"];
                                                        if ($_SESSION['role_id'] == 1) :
                                                        ?>
                                                            |

                                                            <input type="hidden" class="delete_id_value" value="<?= $iddel ?>">

                                                            <a class="badge btn-danger remove-row rounded-pill waves-effect waves-light tombol-deletesubkatbarang">
                                                                <i class="fe-trash-2"></i>
                                                            </a>
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

            <div id="modaledit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit <?= $juhal ?> </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formupdate">
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" class="kodesubkatbarang" name="update-skbarang">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="namasubkatbarang" class="form-label">Nama Kategori Barang</label>
                                                <input type="text" class="nama form-control" id="unama" name="unama" placeholder="">
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
        // $("#responsive-datatable").DataTable({
        //     dom: "Bfrtip",
        //     lengthMenu: [10, 25, 50, 75, 100],
        //     buttons: [
        //         'pageLength', {
        //             text: 'Download Template',
        //             extend: "excelHtml5",
        //             className: "btn btn-primary waves-effect buttons-csv d-none",
        //             title: "Template Data Supplier",
        //             exportOptions: {
        //                 // columns: [1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 13, 15, 16]
        //                 columns: [1, 2, 3, 4, 6, 7, 9]
        //             }
        //         }
        //     ],
        //     // responsive: !0
        // })

        // const btnDownloadTemplate = document.querySelector("#btnDownloadTemplate");

        // btnDownloadTemplate.addEventListener("click", () => {
        //     document.querySelector(".buttons-csv").click()
        // })

        // const btnUploadData = document.querySelectorAll(".btn-upload-data");

        // btnUploadData.forEach(button => {
        //     button.addEventListener("click", () => {
        //         document.querySelector("[name='stokofbarang']").value = button.dataset.value
        //     })
        // })

        $('#formsubkatbarang').submit(function(e) {

            e.preventDefault();
            var dataform = $('#formsubkatbarang')[0];
            var data = new FormData(dataform);

            var inputsubkatbarang = $('#inputsubkatbarang').val();
            var nsubkatbarang = $('#nsubkatbarang').val();

            if (nkategoribarang == "") {
                Swal.fire({
                    position: "top-end",
                    icon: "erorr",
                    title: "Nama Belom Diisi",
                    showConfirmButton: !1,
                    timer: 1500

                })
            } else {
                $.ajax({
                    url: 'm_datamaster/input.php',
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

                            Swal.fire({
                                position: "top-end",
                                icon: "error",
                                title: "Input Gagal",
                                showConfirmButton: !1,
                                timer: 1500

                            })
                        } else if (hasil == 2) {

                            Swal.fire({
                                position: "top-end",
                                icon: "erorr",
                                title: "tanggal tidak sesuai",
                                showConfirmButton: !1,
                                timer: 1500

                            })
                        } else if (hasil == 3) {

                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Input Berhasil!",
                                showConfirmButton: !1,
                                timer: 500

                            })
                            setTimeout(location.reload.bind(location), 800);

                        } else if (hasil == 4) {

                            Swal.fire({
                                position: "top-end",
                                icon: "error",
                                title: "Nama Sub kategori sudah terdaftar",
                                showConfirmButton: !1,
                                timer: 1500

                            })
                        }
                    }
                });
            }
        })


        $('#responsive-datatable').on('click', '.tombol-edit', function() {


            const id = $(this).data('id');
            const nama = $(this).data('nama');

            $('.kodesubkatbarang').val(id);
            $('.nama').val(nama);
            $('#modaledit').modal('show');
        });

        $('#formupdate').submit(function(e) {

            // alert('ok');
            e.preventDefault();
            var dataform = $('#formupdate')[0];
            var data = new FormData(dataform);
            console.log(data);

            var namaunit = $('#unama').val();


            if (namaunit == "") {
                Swal.fire({

                    icon: "error",
                    title: "Sub Kategori Barang Belom Diisi",
                    showConfirmButton: !1,
                    timer: 1500

                })
            } else {
                $.ajax({
                    url: 'm_datamaster/edit.php',
                    // url: '../controller/c_supplier.php',
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
                        // console.log(hasil);
                        //sukses
                        if (hasil == 1) {
                            Swal.fire({

                                icon: "error",
                                title: "Nama Sub Kategori sudah terdaftar",
                                showConfirmButton: !1,
                                timer: 1500

                            })
                        } else if (hasil == 3) {
                            swal.fire({
                                title: "Update Berhasil!",
                                icon: "success",
                                //text: "I will close in 2 seconds.",
                                timer: 500,
                                showConfirmButton: !1
                            })
                            // location.reload();
                            setTimeout(location.reload.bind(location), 500);

                        }
                    }
                });
            }
        })

        $('.tombol-deletesubkatbarang').click(function(e) {
            $('#responsive-datatable').on('click', '.tombol-deletesubkatbarang', function(e) {
                e.preventDefault();
                //alert('hapus');
                //var delete = 'delete';
                var tabel = 'subkatbarang01';
                var iddelete = $(this).closest('tr').find('.delete_id_value').val();
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

                        console.log('test');
                        $.ajax({
                            url: 'm_datamaster/delete.php',
                            type: 'post',
                            data: {
                                'tabel': tabel,
                                'delete_id': iddelete
                            },
                            success: function(hasil) {
                                // alert(hasil);
                                console.log(hasil);
                                //sukses
                                if (hasil == 2) {

                                } else if (hasil == 3) {
                                    swal.fire({
                                        title: "Delete Data Berhasil",
                                        type: "success",
                                        //text: "I will close in 2 seconds.",
                                        timer: 2000,
                                        showConfirmButton: false
                                    })
                                    setTimeout(location.reload.bind(location), 500);

                                }
                            }
                        });
                    } else {
                        swal.fire({
                            title: "Canceled",
                            type: "error",
                            //text: "I will close in 2 seconds.",
                            timer: 2000,
                            showConfirmButton: false
                        })
                    }
                });
            });
        })

        // document.getElementById("sa-custom-position").addEventListener("click", function() {
        //     Swal.fire({
        //         position: "top-end",
        //         icon: "success",
        //         title: "Your work has been saved",
        //         showConfirmButton: !1,
        //         timer: 1500
        //     })
    })
</script>