<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("location:../default/index"); // jika belum login, maka dikembalikan ke index
    exit;
}
require '../include/fungsi.php';
require '../include/fungsi_rupiah.php';
require '../include/fungsi_indotgl.php';
require 'c_datamaster/c_supplier.php';
$bagian = "Data Master";
$juhal = "Supplier";
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
                                    <h4 class="mb-3 header-title">Input Supplier</h4>

                                    <form class="form-horizontal" id="formsupplier">
                                        <input type="hidden" value="inputsupplier" id="inputsupplier" name="inputsupplier">
                                        <input type="hidden" value="<?= $kodeoutlet; ?>" id="kodeoutlet" name="kodeoutlet">
                                        <div class="row mb-2">

                                            <label class="col-4 col-xl-5 col-form-label">Nama Supplier</label>
                                            <div class="col-8 col-xl-7">
                                                <input type="text" class="form-control" required name="nsupplier" id="nsupplier" placeholder="Nama Supplier">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-4 col-xl-5 col-form-label">No Telp</label>
                                            <div class="col-8 col-xl-7">
                                                <input type="text" class="form-control" name="nohp" id="nohp" placeholder="Nomor Telepon">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-4 col-xl-5 col-form-label">Alamat</label>
                                            <div class="col-8 col-xl-7">
                                                <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat Supplier">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-4 col-xl-5 col-form-label">Nama Bank</label>
                                            <div class="col-8 col-xl-7">
                                                <select class="form-select select2" name="bank" id="bank">
                                                    <?php foreach ($bank as $row) : ?>
                                                        <option value="<?= $row["kodebank"] ?>">
                                                            <?= ucwords($row["namabank"]) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-4 col-xl-5 col-form-label">No Rek</label>
                                            <div class="col-8 col-xl-7">
                                                <input type="text" class="form-control" name="norek" id="norek" placeholder="Nomor Rekening">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label for="ppn" class="col-4 col-xl-5 col-form-label">PPn</label>
                                            <div class="col-8 col-xl-3">
                                                <div class="radio radio-info radio-inline">
                                                    <input type="radio" id="ppnon" value="1" name="ppn" required>
                                                    <label for="ppnon"> PPn On </label>
                                                </div>
                                            </div>
                                            <div class="col-8 col-xl-3">
                                                <div class="radio radio-info radio-inline">
                                                    <input type="radio" id="ppnoff" value="0" name="ppn" required>
                                                    <label for="ppnoff"> PPn Off </label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="justify-content-end row">
                                            <div class="col-8 col-xl-8">
                                                <button type="submit" class="btn btn-info waves-effect waves-light">Input Supplier</button>
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
                                    <h4 class="mt-0 header-title">Daftar Supplier</h4>


                                    <table id="responsive-datatable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode <br> Supplier</th>
                                                <th>Nama Supplier</th>
                                                <th>No Telp</th>
                                                <th>Nama Bank</th>
                                                <th>No Rekening</th>
                                                <th>PPn</th>
                                                <th>Action </th>
                                            </tr>
                                        </thead>

                                        <?php $i = 1; ?>
                                        <tbody>
                                            <?php foreach ($kodesupplierr as $row) : ?>
                                                <tr>
                                                    <td width=" 2%" ;><?= $i ?></td>
                                                    <td><?= $row["kodesupplier"] ?></td>
                                                    <td><?= ucwords($row["namasupplier"]) ?></td>
                                                    <td><?= $row["nohp"] ?></td>
                                                    <td><?= ucwords($row["namabank"]) ?></td>
                                                    <td><?= ucwords($row["norek"]) ?></td>
                                                    <td><?= ($row["ppn"] == 1) ? 'PPn' : 'Non PPn' ?></td>
                                                    <td>
                                                        <a class="badge btn-success edit-row rounded-pill waves-effect waves-light tombol-edit" data-bs-toggle="modal" data-bs-target="#modaledit" data-norek="<?= $row['norek']; ?>" data-bank="<?= $row['kodebank']; ?>" data-id="<?= $row['kodesupplier']; ?>" data-nama="<?= $row['namasupplier']; ?>" data-nohp="<?= $row['nohp']; ?>" data-alamat="<?= $row['alamatsupplier']; ?>" data-ppn="<?= $row['ppn']; ?>" id=""><i class="ti-pencil"></i></a>


                                                        <?php
                                                        $iddel = $row["id"];
                                                        if ($_SESSION['role_id'] == 1) :
                                                        ?>
                                                            |

                                                            <input type="hidden" class="delete_id_value" value="<?= $iddel ?>">

                                                            <a class="badge btn-danger remove-row rounded-pill waves-effect waves-light tombol-deletesupplier">
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

            <div id="modaledit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Supplier</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formupdate">
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" class="kodesupplierr" name="update-supplier">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="namasupplier" class="form-label">Nama Supplier</label>
                                                <input type="text" class="nama form-control" id="unama" name="unama" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nohpsupplier" class="form-label">No. Telp</label>
                                                <input type="text" class="nohp form-control" id="unohp" name="unohp">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="field-4" class="form-label">Nama Bank</label>
                                                <select class="form-select select2 ubank" name="ubank" id="ubank">
                                                    <?php foreach ($bank as $row) : ?>
                                                        <option value="<?= $row["kodebank"] ?>">
                                                            <?= ucwords($row["namabank"]) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="field-5" lass="form-label">No Rekening</label>
                                                <input type="text" class="form-control unorek" name="unorek" id="unorek" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="field-6" class="form-label">PPn</label>
                                                <select class="form-select select2 uppn" name="uppn" id="uppn">
                                                    <option value="0">Non PPn</option>
                                                    <option value="1">PPn</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="">
                                                <label for="field-7" class="form-label">Alamat</label>
                                                <textarea class="form-control alamat" rows="2" id="ualamat" name="ualamat" placeholder=""></textarea>
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

        $('#formsupplier').submit(function(e) {

            e.preventDefault();
            var dataform = $('#formsupplier')[0];
            var data = new FormData(dataform);

            var inputsupplier = $('#inputsupplier').val();
            var kodeoutlet = $('#kodeoutlet').val();
            var nsupplier = $('#nsupplier').val();
            var nohp = $('#nohp').val();
            var alamat = $('#alamat').val();

            if (nsupplier == "") {
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
                                title: "Nama Supplier sudah terdaftar",
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
            const alamat = $(this).data('alamat');
            const bank = $(this).data('bank');
            const norek = $(this).data('norek');
            const ppn = $(this).data('ppn');
            $('.kodesupplierr').val(id);
            $('.nama').val(nama);
            $('.nohp').val(nohp);
            $('.alamat').val(alamat);
            $('.uppn').val(ppn);
            $('#uppn').trigger('change');
            $('.ubank').val(bank);
            $('#ubank').trigger('change');
            $('.unorek').val(norek);
            $('#modaledit').modal('show');
        });

        $('#formupdate').submit(function(e) {

            // alert('ok');
            e.preventDefault();
            var dataform = $('#formupdate')[0];
            var data = new FormData(dataform);
            console.log(data);

            var namasupplier = $('#unama').val();
            var nohpsupplier = $('#unohp').val();
            var alamatsupplier = $('#ualamat').val();
            var ubank = $('#ubank').val();
            var unorek = $('#unorek').val();

            if (namasupplier == "") {
                Swal.fire({

                    icon: "error",
                    title: "Nama Supplier Belom Diisi",
                    showConfirmButton: !1,
                    timer: 1500

                })
            } else if (nohpsupplier == "") {
                Swal.fire({

                    icon: "error",
                    title: "No hp Belum Diisi",
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
                                title: "Nama Supplier sudah terdaftar",
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

        // $('.tombol-deletesupplier').click(function(e) {
        $('#responsive-datatable').on('click', '.tombol-deletesupplier', function(e) {
            e.preventDefault();
            //alert('hapus');
            //var delete = 'delete';
            var tabel = 'supplier01';
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
    // })
</script>