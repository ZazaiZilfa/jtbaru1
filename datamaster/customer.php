<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("location:../default/index"); // jika belum login, maka dikembalikan ke index
    exit;
}
require '../include/fungsi.php';
require '../include/fungsi_rupiah.php';
require '../include/fungsi_indotgl.php';
require 'c_datamaster/c_customer.php';
$bagian = "Data Master";
$juhal = "Customer";
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
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="mb-3 header-title">Input Customer</h4>

                                        <form class="form-horizontal" id="formcustomer">
                                            <input type="hidden" value="inputcustomer" id="inputcustomer" name="inputcustomer">
                                            <input type="hidden" value="<?= $kodeoutlet; ?>" id="kodeoutlet" name="kodeoutlet">
                                            <div class="row mb-2">

                                                <label class="col-4 col-xl-5 col-form-label">Nama Customer</label>
                                                <div class="col-8 col-xl-7">
                                                    <input type="text" class="form-control" required name="ncustomer" id="ncustomer" placeholder="Nama Customer">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-4 col-xl-5 col-form-label">No Telp</label>
                                                <div class="col-8 col-xl-7">
                                                    <input type="text" class="form-control" name="nohp" id="nohp" placeholder="Nomor Telepon">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-4 col-xl-5 col-form-label">NIK</label>
                                                <div class="col-8 col-xl-7">
                                                    <input type="text" maxlength="16" pattern="[0-9]{16}" class="form-control" name="nik" id="nik" placeholder="337205..">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-4 col-xl-5 col-form-label">Alamat</label>
                                                <div class="col-8 col-xl-7">
                                                    <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat Customer"></input>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-4 col-xl-5 col-form-label">Sales</label>
                                                <div class="col-8 col-xl-7">
                                                    <select class="form-select select2" name="sales" id="sales" required data-placeholder="">
                                                        <option value=""></option>
                                                        <?php foreach ($sales as $sale) : ?>
                                                            <option value="<?= $sale['nip'] ?>"><?= $sale['nama'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-4 col-xl-5 col-form-label">Status</label>
                                                <div class="col-8 col-xl-7">
                                                    <select class="form-select select2" name="statuss" id="statuss" required data-placeholder="">
                                                        <option value=""></option>
                                                        <option value="0">Tingkat 0</option>
                                                        <option value="1">Tingkat 1</option>
                                                        <option value="2">Tingkat 2</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-4 col-xl-5 col-form-label">Level</label>
                                                <div class="col-8 col-xl-7">
                                                    <select class="form-select select2" name="level" id="level" required data-placeholder="">
                                                        <option value=""></option>
                                                        <option value="1">Level 1</option>
                                                        <option value="2">Level 2</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="justify-content-end row">
                                                <div class="col-8 col-xl-8">
                                                    <button type="submit" class="btn btn-info waves-effect waves-light" name="customer" id="tombol-customer">Input Customer</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div>
                            <!-- end col -->

                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body table-responsive ">
                                        <h4 class="mt-0 header-title">Daftar Customer</h4>


                                        <table id="responsive-datatable" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width=" 2%">No</th>
                                                    <th width="5%">Nama Customer</th>
                                                    <th width="5%">No Telp</th>
                                                    <th width="5%">NIK</th>
                                                    <th width="5%">Sales</th>
                                                    <th width="5%">Status</th>
                                                    <th width="5%">Level</th>
                                                    <th width="3%">Action </th>
                                                </tr>
                                            </thead>

                                            <?php $i = 1; ?>
                                            <tbody>
                                                <?php foreach ($kodecustomer as $row) : ?>
                                                    <tr>
                                                        <td width=" 2%" ;><?= $i ?></td>
                                                        <td width="5%"><?= ucwords($row["namacustomer"]) ?></td>
                                                        <td width="5%"><?= $row["nohpcustomer"] ?></td>
                                                        <td width="5%"><?= $row["nikcustomer"] ?></td>
                                                        <td width="5%">
                                                            <?php
                                                            $salesNIP = $row["sales"];
                                                            if ($salesNIP != '') {
                                                                echo query("SELECT nama FROM karyawan01 WHERE nip = '$salesNIP' ORDER BY id DESC LIMIT 1")[0]['nama'];
                                                            }
                                                            ?>
                                                        </td>
                                                        <td width="5%"><?= $row["status"] ?></td>
                                                        <td width="5%"><?= $row["level"] ?></td>
                                                        <td width="3%">
                                                            <a class="badge btn-success edit-row rounded-pill waves-effect waves-light tombol-edit" data-bs-toggle="modal" data-bs-target="#modaledit" data-id="<?= $row['kodecustomer']; ?>" data-nama="<?= $row['namacustomer']; ?>" data-nohp="<?= $row['nohpcustomer']; ?>" data-nik="<?= $row['nikcustomer']; ?>" data-alamat="<?= $row['alamatcustomer']; ?>" data-status="<?= $row['status']; ?>" data-level="<?= $row['level']; ?>" data-sales="<?= $row['sales']; ?>" id=""><i class="ti-pencil"></i></a>


                                                            <?php
                                                            $iddel = $row["id"];
                                                            if ($_SESSION['role_id'] == 1) :
                                                            ?>
                                                                |

                                                                <input type="hidden" class="delete_id_value" value="<?= $iddel ?>">

                                                                <a class="badge btn-danger remove-row rounded-pill waves-effect waves-light tombol-deletecustomer">
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

                <div id="modaledit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Barang</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="formupdate">
                                <div class="modal-body">
                                    <div class="row">
                                        <input type="hidden" class="id" name="update-customer">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="form-label">Nama Customer</label>
                                                    <input type="text" class="nama form-control" required id="unama" name="unama"></input>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="control-label">NIK</label>
                                                    <input type="text" class="nik form-control" id="unik" name="unik">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Status</label>
                                                    <select class="form-select select2" name="ustatuss" id="ustatuss" required data-placeholder="">
                                                        <option value=""></option>
                                                        <option value="0">Tingkat 0</option>
                                                        <option value="1">Tingkat 1</option>
                                                        <option value="2">Tingkat 2</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="form-label">No Telp</label>
                                                    <input type="text" class="nohp form-control" required id="unohp" name="unohp">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Sales</label>
                                                    <select class="form-select select2" name="usales" id="usales" required data-placeholder="">
                                                        <option value=""></option>
                                                        <?php foreach ($sales as $sale) : ?>
                                                            <option value="<?= $sale['nip'] ?>"><?= $sale['nama'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Level</label>
                                                    <select class="form-select select2" name="ulevel" id="ulevel" required data-placeholder="">
                                                        <option value=""></option>
                                                        <option value="1">Level 1</option>
                                                        <option value="2">Level 2</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Alamat</label>
                                                    <textarea class="form-control alamat" rows="2" id="ualamat" name="ualamat" placeholder=""></textarea>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-info waves-effect waves-light" id="tombol-update">Save</button>
                                    </div>
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

        $('#formcustomer').submit(function(e) {

            e.preventDefault();
            var dataform = $('#formcustomer')[0];
            var data = new FormData(dataform);

            var inputcustomer = $('#inputcustomer').val();
            var kodeoutlet = $('#kodeoutlet').val();
            var ncustomer = $('#ncustomer').val();
            var nohp = $('#nohp').val();
            var alamat = $('#alamat').val();
            var statuss = $('#statuss').val();
            var level = $('#level').val();
            var sales = $('#sales').val();

            if (ncustomer == "") {
                Swal.fire({
                    position: "top-end",
                    icon: "erorr",
                    title: "Nama Customer Belom Diisi",
                    showConfirmButton: !1,
                    timer: 1500

                })
            } else if (statuss == "") {
                Swal.fire({
                    position: "top-end",
                    icon: "erorr",
                    title: "Status Belom Diisi",
                    showConfirmButton: !1,
                    timer: 1500

                })
            } else if (level == "") {
                Swal.fire({
                    position: "top-end",
                    icon: "erorr",
                    title: "Level Belom Diisi",
                    showConfirmButton: !1,
                    timer: 1500

                })
            } else if (sales == "") {
                Swal.fire({
                    position: "top-end",
                    icon: "erorr",
                    title: "Sales Belom Diisi",
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
                                title: "Customer sudah terdaftar",
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
            const nohp = $(this).data('nohp');
            const nik = $(this).data('nik');
            const alamat = $(this).data('alamat');
            const sales = $(this).data('sales');
            const statuss = $(this).data('statuss');
            const level = $(this).data('level');

            $('.id').val(id);
            $('.nama').val(nama);
            $('.nohp').val(nohp);
            $('.nik').val(nik);
            $('.alamat').val(alamat);
            $('.sales').val(sales).trigger('change');
            $('.statuss').val(statuss).trigger('change');
            $('.level').val(level).trigger('change');
            $('#modaledit').modal('show');
        });

        $('#formupdate').submit(function(e) {

            // alert('ok');
            e.preventDefault();
            var dataform = $('#formupdate')[0];
            var data = new FormData(dataform);
            console.log(data);

            var namacustomer = $('#unama').val();
            var nohpcustomer = $('#unohp').val();
            var alamatcustomer = $('#ualamat').val();
            var salescustomer = $('#usales').val();
            var statuscustomer = $('#ustatuss').val();
            var levelcustomer = $('#ulevel').val();

            if (namacustomer == "") {
                Swal.fire({

                    icon: "error",
                    title: "Nama Belom Diisi",
                    showConfirmButton: !1,
                    timer: 1500

                })
            } else if (nohpcustomer == "") {
                Swal.fire({

                    icon: "error",
                    title: "No hp Belum Diisi",
                    showConfirmButton: !1,
                    timer: 1500

                })
            } else if (statuscustomer == "") {
                Swal.fire({

                    icon: "error",
                    title: "Status Belum Diisi",
                    showConfirmButton: !1,
                    timer: 1500

                })
            } else if (levelcustomer == "") {
                Swal.fire({

                    icon: "error",
                    title: "Level Belum Diisi",
                    showConfirmButton: !1,
                    timer: 1500

                })
            } else if (salescustomer == "") {
                Swal.fire({

                    icon: "error",
                    title: "Sales Belum Diisi",
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
                                title: "Nama Customer sudah terdaftar",
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

        // $('.tombol-deletecustomer').click(function(e) {
        $('#responsive-datatable').on('click', '.tombol-deletecustomer', function(e) {
            e.preventDefault();
            //alert('hapus');
            //var delete = 'delete';
            var tabel = 'customer01';
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
</script>