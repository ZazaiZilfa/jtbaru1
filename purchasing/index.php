<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("location:../default/index"); // jika belum login, maka dikembalikan ke index
    exit;
}
require '../include/fungsi.php';
require '../include/fungsi_rupiah.php';
require '../include/fungsi_indotgl.php';

$tabel = 'form_po01';
$tabel_join = 'supplier01';
$kode = 'supplier';
include 'm_purchasing/information.php';
include '../include/filter_date.php';

$bagian = "Purchasing";
$juhal = "Data PO";
?>

<!DOCTYPE html>
<html lang="en">

<?php require "../include/header.php"; ?>

<!-- body start -->

<body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": true}, "topbar": {"color": "light"}, "showRightSidebarOnPageLoad": true}'>
    <style>
        .rowspin {
            display: none;
            justify-content: center;
            height: 100vh;
            width: 100%;
            align-items: center;
            position: absolute;
            z-index: 999999;
        }

        /* /* td.nsfp,
        td.nsfpedit,
        td.tanggals,
        td.tanggalsedit {
            background-color: #a1d3ff;
            color: black;
            cursor: cell;
        }

        td.nsfpedit,
        td.tanggalsedit {
            display: flex;
        }

        .d-none,
        .noforms {
            display: none; */
        /* } */

        */ body {
            padding-right: 0px !important;
        }

        .select2-dropdown.select2-dropdown--below {
            z-index: 999999 !important;
        }

        .select2-container {
            width: 83.33333% !important;
        }
    </style>
    <div class="rowspin">
        <div class="spinn">
            <i class="fa fa-spin fa-circle-o-notch spinn2 fa-4x"></i>
        </div>
    </div>
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
                                    <button type="button" class="btn btn-info waves-effect waves-light">Delivery: <?= $delivery['informasi'] ?></button>
                                    <button type="button" class="btn btn-success waves-effect waves-light">Delivered:<?= $delivered['informasi'] ?></button>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" action="">
                                        <input type="hidden" name="filter-specific-date">
                                        <div class="col-auto">
                                            <div class="input-group">
                                                <input type="hidden" value="<?= $_SESSION['kodeoutlet'] ?>" id="kodeoutlet" name="kodeoutlet">
                                                <input type="text" name="specific-date" class="form-control input-sm datepicker" placeholder="mm/dd/yyyy" autocomplete="off" required>
                                                &nbsp;&nbsp;&nbsp;
                                                <button class="btn btn-primary waves-effect waves-light btn-sm " name="tampilkan">Tampilkan</button>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" action="">
                                        <input type="hidden" name="filter-date">
                                        <input type="hidden" value="<?= $_SESSION['kodeoutlet'] ?>" id="kodeoutlet" name="kodeoutlet">
                                        <div class="input-group m-b-10">
                                            <div class="col-8 col-xl-4">
                                                <select class="form-control input-sm" id="bulan" name="bulan">
                                                    <option value="00">Semua</option>
                                                    <option value="01">Jan</option>
                                                    <option value="02">Feb</option>
                                                    <option value="03">Maret</option>
                                                    <option value="04">Apr</option>
                                                    <option value="05">Mei</option>
                                                    <option value="06">Jun</option>
                                                    <option value="07">Jul</option>
                                                    <option value="08">Aug</option>
                                                    <option value="09">Sept</option>
                                                    <option value="10">Okt</option>
                                                    <option value="11">Nov</option>
                                                    <option value="12">Des</option>
                                                </select>
                                                <script>
                                                    document.querySelector('#bulan').value = "<?= $month ?>"
                                                </script>
                                            </div>

                                            &nbsp;
                                            <div class="col-8 col-xl-4  ">
                                                <select class="form-control input-sm" id="tahun" name="tahun">
                                                    <option value="00">Semua</option>
                                                    <?php
                                                    $tahunpertama = 2019;
                                                    $tahunSekarang = date('Y');
                                                    $jt = ($tahunSekarang - $tahunpertama) + 1;
                                                    $tg_awal = date('Y') - $jt;
                                                    $tg_akhir = date('Y');
                                                    ?>
                                                    <?php for ($i = $tg_akhir; $i >= $tg_awal; $i--) : ?>
                                                        <option><?= $i ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                                <script>
                                                    document.querySelector('#tahun').value = "<?= $year ?>"
                                                </script>
                                            </div>
                                            &nbsp;&nbsp;&nbsp;&nbsp;

                                            <button class="btn btn-primary waves-effect waves-light btn-sm m-b-5 rounded" name="tampilkan">Tampilkan</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <?php if (count($data) == 0) { ?>
                                        <h4 class="header-title m-t-0 m-b-30">Tidak ada Data PO</h4>
                                    <?php } else if (isset($_POST['filter-date'])) { ?>
                                        <h4 class="header-title m-t-0 m-b-30">Data PO bulan
                                            <?= $_POST['bulan'] . '-' . $_POST['tahun'] ?> </h4>
                                    <?php } ?>
                                    <table id="datatable-po" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>

                                                <th>No. Form</th>
                                                <th>Pay Status</th>
                                                <?php if ($kodeoutlet == "OUT001") : ?>
                                                    <th>Nama Outlet</th>
                                                <?php endif; ?>
                                                <th>Tanggal</th>
                                                <th>No. Faktur</th>
                                                <th>Supplier</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <?php $i = 1; ?>
                                        <tbody>
                                            <?php if (isset($data)) : ?>
                                                <?php foreach ($data as $dp) :

                                                    if ($dp['status_ot'] == 2 && $dp['status_ck'] == 2) :
                                                        $No_form = $dp['No_form'];
                                                        $InTotal = query("SELECT total FROM form_in01 WHERE Form_po = '$No_form' AND kodeoutlet = '$kodeoutlet'")[0]['total'];
                                                        $thisDate = query("SELECT form_in01.date AS date FROM form_in01 WHERE Form_po = '$No_form' AND kodeoutlet = '$kodeoutlet'")[0]['date'];
                                                        $totalPaid = isset(query("SELECT sum(total) as totals FROM pembayaran_purchase01 WHERE no_po = '$No_form'")[0]['totals']) ? query("SELECT sum(total) as totals FROM pembayaran_purchase01 WHERE no_po = '$No_form'")[0]['totals'] : 0;
                                                        $notPaid = $InTotal - $totalPaid;
                                                    else :
                                                        $thisDate = $dp['date'];
                                                    endif;
                                                ?>
                                                    <tr>
                                                        <td><?= $i++; ?></td>
                                                        <?php if ($kodeoutlet == "OUT001") :
                                                            $kd = $dp['kodeoutlet']; ?>
                                                            <td><?php $namaoutlet = query("SELECT * FROM companypanel01 WHERE kodeoutlet = '$kd'")[0];
                                                                echo $namaoutlet['nama']; ?></td>
                                                        <?php endif ?>
                                                        <!-- <td class="noforms"><?= $dp['No_form']; ?></td> -->
                                                        <td>
                                                            <?php
                                                            if ($dp['status_ot'] == 2 && $dp['status_ck'] == 2) :
                                                                $No_form = $dp['No_form'];
                                                                $nofin = query("SELECT No_form FROM form_in01 WHERE Form_po = '$No_form' AND kodeoutlet = '$kodeoutlet'")[0]['No_form']; ?>
                                                                <a href="#" class="btn-detail-faktur" data-toggle="modal" data-target="#detailFakturModal" data-faktur="<?= $nofin ?>">
                                                                    <?= $nofin ?>
                                                                </a>
                                                            <?php else :
                                                                echo $dp['No_form'];
                                                            endif
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($dp['status_ot'] == 2 && $dp['status_ck'] == 2) : ?>
                                                                <span class="statusOutstanding<?= str_replace("/", "", $nofin); ?>">
                                                                    <?= ($notPaid <= 0) ? "<span class='text-success'>Lunas</span>" : "- <span class='text-danger'>" . format_rupiah($notPaid) . " </span>" ?>
                                                                </span>
                                                            <?php else :
                                                                echo "-";
                                                            endif; ?>
                                                        </td>
                                                        <td class="tanggals" data-date="<?= date('d/m/Y', strtotime($thisDate)) ?>">
                                                            <?= tgl_indo($thisDate) ?></td>
                                                        <td class="nsfp">
                                                            <?php
                                                            if ($dp['status_ot'] == 2 && $dp['status_ck'] == 2) :
                                                                $No_form = $dp['No_form'];
                                                                echo query("SELECT No_faktur FROM form_in01 WHERE Form_po = '$No_form' AND kodeoutlet = '$kodeoutlet'")[0]['No_faktur'];
                                                            else :
                                                                echo "-";
                                                            endif
                                                            ?>

                                                        </td>
                                                        <td><?= ucwords($dp['namasupplier']) ?></td>
                                                        <td>
                                                            <?php
                                                            if ($dp['status_ot'] == 2 && $dp['status_ck'] == 2) :
                                                                $No_form = $dp['No_form'];
                                                                $cekPrice = query("SELECT ppn, total FROM form_in01 WHERE Form_po = '$No_form' AND kodeoutlet = '$kodeoutlet'")[0];
                                                                $ppn = $cekPrice['ppn'];
                                                                $grand_total =  $cekPrice['total'];
                                                                +$ppn;
                                                                echo format_rupiah($grand_total);
                                                            else :
                                                                echo 0;
                                                            endif
                                                            ?>

                                                        </td>

                                                        <?php if ($dp['status_ot'] == 0 && $dp['status_ck'] == 0) : ?>
                                                            <td class="status"><span class="label label-danger">Confirm</span>
                                                            </td>
                                                        <?php elseif ($dp['status_ot'] == 1 && $dp['status_ck'] == 0) : ?>
                                                            <td class="status"><span class="label label-default">Acc by OEM</span></td>
                                                        <?php elseif ($dp['status_ot'] == 1 && $dp['status_ck'] == 1) : ?>
                                                            <td class="status"><span class="label label-info">Checked by CK</span></td>
                                                        <?php elseif ($dp['status_ot'] == 1 && $dp['status_ck'] == 2) : ?>
                                                            <td class="status"><span class="label label-primary">Delivery</span></td>
                                                        <?php elseif ($dp['status_ot'] == 2 && $dp['status_ck'] == 2) : ?>
                                                            <td class="status"><span class="label label-success">Delivered</span></td>
                                                        <?php endif ?>

                                                        <td><a href='javascript:window.open("detail.php?No_form=<?= $dp['No_form']; ?>", "_blank", "")' class="btn btn-icon waves-effect waves-light btn-primary btn-xs m-b-5">Details</a>
                                                            <?php if ($dp['status_ot'] == 1 && $dp['status_ck'] == 2) : ?>
                                                                |
                                                                <button data-noform="<?= $dp['No_form']; ?>" class="btn btn-icon waves-effect waves-light btn-info btn-xs m-b-5 editformpo">Edit</button>
                                                                <?php if ($_SESSION['role_id'] == '1' || $_SESSION['role_id'] == '0') : ?>
                                                                    |
                                                                    <button data-noform="<?= $dp['No_form']; ?>" class="btn btn-icon waves-effect waves-light btn-danger btn-xs m-b-5 hapusformpo"><i class="fa fa-trash"></i></i></button>
                                                                <?php endif ?>

                                                            <?php endif ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                </div> <!-- container-fluid -->

                <div id="detailFakturModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-full-width">
                        <div class="modal-content">
                            <div class="modal-header" style="display: flex;flex-wrap: wrap;width: 100%;align-items: center;">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                <!-- <h2 class="modal-title">Daftar Gaji Karyawan</h2>
                                    <div style="margin-left: auto;">
                                        <button class="btn btn-info waves-effect waves-light">Total Gaji Rp. <b id="totalGaji">0 </b></button>
                                        <button class="btn btn-primary waves-effect waves-light">Total Bayar Rp. <b id="totalBayar">0 </b></button>
                                    </div> -->
                            </div>
                            <div class="modal-body" style="padding-bottom: 1rem;">
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- content -->

            <?php require "../include/rightsidebar.php";
            ?>

            <div id="detailFormPO" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-full-width">
                    <div class="modal-content">
                        <div class="modal-header" style="display: flex;flex-wrap: wrap;width: 100%;align-items: center;">
                            <h4 class="modal-title" id="fullWidthModalLabel">Modal Heading</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="padding-bottom: 1rem;">
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->


            <?php require "../include/footer.php"; ?>


</body>

</html>

<script>
    function preventToLeave() {
        window.onbeforeunload = function(e) {
            var e = e || window.event;

            //IE & Firefox
            if (e) {
                e.returnValue = 'Yakin mau pindah halaman? Udah disimpan belum datanya?';
            }

            // For Safari
            return 'Yakin mau pindah halaman? Udah disimpan belum datanya?';
        };
    }

    function removePreventToLeave() {
        window.onbeforeunload = function(e) {}
    }

    $(document).ready(function() {

        var table = $("#datatable-po").DataTable({
            dom: "Bfrtip",
            lengthMenu: [10, 25, 50, 75, 100],
            buttons: [
                'pageLength', {
                    text: '<i class="fa fa-download m-10"></i> Excel',
                    extend: "excelHtml5",
                    className: "btn btn-success waves-effect m-l-10",
                    title: "Data Purchasing CFI",
                    exportOptions: {
                        // columns: [1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 13, 15, 16]
                        columns: [2, 3, 4, 5, 6, 7]
                    }
                }
            ],
            // responsive: !0
        })





        $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            autoclose: true,
            todayHighlight: true,
            orientation: 'auto',
        });


        // $('#responsive-datatable').on('click', '.btn-detail-faktur', function() {
        //     const faktur = $(this).data('faktur');
        //     $('.rowspin').css('display', 'flex');

        //     $("#detailFakturModal .modal-body").load(`./detail-faktur-purchase?faktur=${faktur}`, function(
        //         responseTxt,
        //         statusTxt, xhr) {
        //         if (statusTxt == "success") {
        //             // swal.fire("External content loaded successfully!", "", "success");
        //             $('#detailFakturModal').modal('show')
        //         } else if (statusTxt == "error") {
        //             swal.fire("Error: " + xhr.status + ": " + xhr.statusText, "", "error");
        //         }

        //         $('#detailFakturModal').on('hide.bs.modal', function(e) {
        //             // console.log("test")
        //             if ($('#detailFakturModal').hasClass("in") == false) {
        //                 $("#detailFakturModal .modal-body").empty()
        //             }
        //         })

        //         $('.rowspin').css('display', 'none');
        //     });
        // })

        // $('#responsive-datatable tbody').on('click', 'td', function() {
        //     var cell = table.cell(this);
        //     var ogCell = cell.data();
        //     var noforms = this.parentElement.querySelector('.noforms').innerText
        //     if (!document.querySelector(".nsfpedit")) {
        //         var status = this.parentElement.querySelector('.status').innerText
        //         if (this.classList.value == 'nsfp' && status == 'Delivered') {
        //             var this1 = this
        //             this1.classList.remove('nsfp')
        //             this1.classList.add('nsfpedit')

        //             cell.data(
        //                 `<input type="text" id="nsfp" name="nsfp" value="${cell.data()}">
        //         <button class="btn btn-success btn-sm confirmUpdate"><i class="fa fa-check"></i></button>
        //         <button class="btn btn-danger btn-sm cancelUpdate"><i class="fa fa-times"></i></button>`
        //             ).draw(false);
        //             var inputNsfp = this.querySelector('#nsfp')
        //             inputNsfp.focus()
        //             document.querySelector('#nsfp').nextElementSibling.addEventListener("click", () => {
        //                 // inputNsfp.focus()

        //                 // $('#responsive-datatable').on('click', '.confirmUpdate', function() {
        //                 var nopajak = $('input#nsfp').val();
        //                 var data = new FormData();
        //                 data.append('updatefakturpurchase', true);
        //                 data.append('noform', noforms);
        //                 data.append('nopajak', nopajak);

        //                 if (nopajak == "") {
        //                     swal.fire("No Pajak belum diisi!", "", "error")
        //                 } else {
        //                     $.ajax({
        //                         url: '../models/edit.php',
        //                         type: 'post',
        //                         data: data,
        //                         enctype: 'multipart/form-data',
        //                         processData: false,
        //                         contentType: false,
        //                         cache: false,
        //                         beforeSend: function() {
        //                             $('.rowspin').css('display', 'flex');
        //                         },
        //                         success: function(hasil) {
        //                             $('.rowspin').hide();
        //                             //sukses
        //                             if (hasil == 0) {
        //                                 swal.fire("Tidak Berhasil ditambahkan!", "",
        //                                     "error")
        //                             } else if (hasil == 3) {
        //                                 swal.fire({
        //                                     title: "Update Berhasil!",
        //                                     type: "success",
        //                                     timer: 500,
        //                                     showConfirmButton: false
        //                                 })
        //                                 cell.data(nopajak).draw(false);
        //                                 this1.classList.add('nsfp')
        //                                 this1.classList.remove('nsfpedit')
        //                             }
        //                         }
        //                     });
        //                 }
        //             })
        //             document.querySelector('#nsfp').nextElementSibling.nextElementSibling.addEventListener(
        //                 "click", () => {
        //                     // $('#responsive-datatable').on('click', '.cancelUpdate', function() {
        //                     // inputNsfp.focus()

        //                     cell.data(ogCell).draw(false);
        //                     this1.classList.add('nsfp')
        //                     this1.classList.remove('nsfpedit')
        //                 })
        //             // $(document).on('click', function() {
        //             //     if (document.activeElement === document.querySelector('#nsfp') ||
        //             //         document.activeElement === document.querySelector(
        //             //             '.confirmUpdate') ||
        //             //         document.activeElement === document.querySelector('.cancelUpdate')
        //             //     ) {
        //             //         return false
        //             //     } else {
        //             //         if (document.querySelector(".nsfpedit")) {
        //             //             cell.data(ogCell).draw(false)
        //             //             this1.classList.add('nsfp')
        //             //             this1.classList.remove('nsfpedit')
        //             //         }
        //             //     }
        //             // })
        //         }
        //     }
        //     if (!document.querySelector(".tanggalsedit")) {
        //         var status = this.parentElement.querySelector('.status').innerText
        //         if (this.classList.value == 'tanggals' && status == 'Delivered') {
        //             var this2 = this
        //             this2.classList.remove('tanggals')
        //             this2.classList.add('tanggalsedit')

        //             cell.data(
        //                 `<input type="text" id="tanggals" name="tanggals" value="${this.dataset.date}">
        //         <button class="btn btn-success btn-sm confirmUpdate"><i class="fa fa-check"></i></button>
        //         <button class="btn btn-danger btn-sm cancelUpdate"><i class="fa fa-times"></i></button>`
        //             ).draw(false);

        //             $('#tanggals').datepicker({
        //                 format: 'dd/mm/yyyy',
        //                 autoclose: true,
        //                 todayHighlight: true,
        //                 orientation: 'auto',
        //             });

        //             $('#tanggals').datepicker('update', this.dataset.date);

        //             var inputTanggals = this.querySelector('#tanggals')
        //             inputTanggals.focus()
        //             document.querySelector('#tanggals').nextElementSibling.addEventListener("click", () => {
        //                 var tanggal = $('input#tanggals').val();
        //                 var data2 = new FormData();
        //                 data2.append('updatetanggalpurchase', true);
        //                 data2.append('noform', noforms);
        //                 data2.append('tanggal', tanggal);

        //                 if (tanggal == "") {
        //                     swal.fire("Tanggal belum diisi!", "", "error")
        //                 } else {
        //                     $.ajax({
        //                         url: '../models/edit.php',
        //                         type: 'post',
        //                         data: data2,
        //                         enctype: 'multipart/form-data',
        //                         processData: false,
        //                         contentType: false,
        //                         cache: false,
        //                         beforeSend: function() {
        //                             $('.rowspin').css('display', 'flex');
        //                         },
        //                         success: function(hasil) {
        //                             $('.rowspin').hide();
        //                             //sukses
        //                             // console.log(hasil)
        //                             if (hasil.status == 500) {
        //                                 swal.fire("Tidak Berhasil ditambahkan!", "",
        //                                     "error")
        //                                 cell.data(ogCell).draw(false);
        //                                 this2.classList.add('tanggals')
        //                                 this2.classList.remove('tanggalsedit')
        //                             } else if (hasil.status == 200) {
        //                                 swal.fire({
        //                                     title: "Update Berhasil!",
        //                                     type: "success",
        //                                     timer: 500,
        //                                     showConfirmButton: false
        //                                 })
        //                                 cell.data(hasil.tanggal).draw(false);
        //                                 this2.dataset.date = hasil.tanggal2
        //                                 this2.classList.add('tanggals')
        //                                 this2.classList.remove('tanggalsedit')
        //                             }
        //                         }
        //                     });
        //                 }
        //             })
        //             document.querySelector('#tanggals').nextElementSibling.nextElementSibling
        //                 .addEventListener("click", () => {
        //                     cell.data(ogCell).draw(false);
        //                     this2.classList.add('tanggals')
        //                     this2.classList.remove('tanggalsedit')
        //                 })
        //         }
        //     }
        // })

        $('#datatable-po').on('click', '.editformpo', function() {
            const noform = $(this).data('noform');
            console.log(noform);
            $('.editformpo').attr('disabled', 'disabled')
            $('.rowspin').css('display', 'flex');
            $("#detailFormPO .modal-title").text(`Edit PO No.${noform}`);

            $("#detailFormPO .modal-body").load(`./editformpo?noform=${noform}`, function(responseTxt,
                statusTxt, xhr) {
                if (statusTxt == "success") {
                    // swal.fire("External content loaded successfully!", "", "success");
                    $('#detailFormPO').modal('show')
                } else if (statusTxt == "error") {
                    swal.fire("Error: " + xhr.status + ": " + xhr.statusText, "", "error");
                }

                $('#detailFormPO').on('hide.bs.modal', function(e) {
                    if ($('#detailFormPO').hasClass('show') == false) {
                        if (confirm("Yakin mau ditutup? Udah disimpan belum datanya?") !=
                            true) {
                            e.preventDefault()
                        }
                    }
                })

                $('.editformpo').removeAttr('disabled')
                $('.rowspin').css('display', 'none');
            });
        })

        $('#datatable-po').on('click', '.hapusformpo', function() {
            const noform = $(this).data('noform');
            $('.hapusformpo').attr('disabled', 'disabled')
            swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Data Anda Akan Terhapus!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Tidak!",
                closeOnConfirm: false,
                closeOnCancel: true
            }).then((isConfirm) => {
                if (isConfirm.isConfirmed) {
                    $.ajax({
                        url: 'm_purchasing/delete.php',
                        type: 'post',
                        data: {
                            'deleteformpo': noform,
                            'kodeoutlet': '<?= $kodeoutlet ?>',
                        },
                        success: function(hasil) {
                            // alert(hasil);
                            // console.log(hasil);
                            //sukses
                            if (hasil == 1) {
                                swal.fire("Gagal!",
                                    "Hapus Data Gagal.",
                                    "error");
                            } else if (hasil == 3) {
                                swal.fire("Deleted!",
                                    "Hapus Data Berhasil.",
                                    "success");
                                $('.hapusformpo').removeAttr('disabled')
                                location.reload();
                            }
                        }
                    });
                } else {
                    // swal.fire("Cancelled", "", "error");
                    $('.hapusformpo').removeAttr('disabled')
                }
            });
        })
    })
</script>