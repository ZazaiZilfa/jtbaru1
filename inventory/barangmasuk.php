<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("location:../default/index"); // jika belum login, maka dikembalikan ke index
    exit;
}
require '../include/fungsi.php';
require '../include/fungsi_rupiah.php';
require '../include/fungsi_indotgl.php';


$tabel = 'form_in01';
$tabel_join = 'supplier01';
$kode = 'supplier';

include '../include/filter_date.php';
include 'm_inventory/information.php';
$bagian = "Inventory";
$juhal = "Barang Masuk";
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
                        <div class="col-4">
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
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive ">
                                <h4 class="mt-0 header-title">Daftar Supplier</h4>


                                <table id="responsive-datatable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>No. Form IN</th>
                                            <th>No. Form PO</th>
                                            <th>Supplier</th>
                                            <th>Jatuh Tempo</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($data)) : ?>
                                            <?php $i = 1 ?>
                                            <?php foreach ($data as $dp) : ?>
                                                <?php if ($dp['kodeoutlet'] == $kodeoutlet) : ?>
                                                    <tr>
                                                        <td><?= $i++; ?></td>
                                                        <td><?= tgl_indo($dp['date']); ?></td>
                                                        <td><?= $dp['No_form']; ?></td>
                                                        <td><?= $dp['Form_po']; ?></td>
                                                        <td><?= ucwords($dp['namasupplier']) ?></td>
                                                        <td><?= tgl_indo($dp['jatuhtempo']); ?></td>

                                                        <!-- <?php if ($dp['status_ot'] == 0 && $dp['status_ck'] == 0) : ?>
                                                        <td><span class="label label-danger">Confirm</span></td>
                                                    <?php elseif ($dp['status_ot'] == 1 && $dp['status_ck'] == 0) : ?>
                                                        <td><span class="label label-info">Confirmed</span></td>
                                                    <?php elseif ($dp['status_ot'] == 2 && $dp['status_ck'] == 0) : ?>
                                                        <td><span class="label label-success">Checked by Manager</span></td>
                                                    <?php elseif ($dp['status_ot'] == 2 && $dp['status_ck'] == 1) : ?>
                                                        <td><span class="label label-success">Checked by CK</span></td>
                                                    <?php elseif ($dp['status_ot'] == 2 && $dp['status_ck'] == 2) : ?>
                                                        <td><span class="label label-primary">Delivery</span></td>
                                                    <?php endif ?> -->

                                                        <td><a href="detail.php?No_form=<?= $dp['No_form']; ?>" class="btn btn-icon waves-effect waves-light btn-xs btn-primary m-b-5">Details</a>

                                                            <?php if ($_SESSION['role_id'] == '1' || $_SESSION['role_id'] == '0') : ?>
                                                                |
                                                                <!--style="display:none;" -->
                                                                <button data-noform="<?= $dp['No_form']; ?>" class="btn btn-icon waves-effect waves-light btn-danger btn-xs m-b-5 hapusformin"><i class="fa fa-trash"></i></i></button>
                                                            <?php endif ?>
                                                        </td>
                                                    </tr>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        <?php endif ?>

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
        $('#responsive-datatable').on('click', '.hapusformin', function() {
            const noform = $(this).data('noform');
            $('.hapusformin').attr('disabled', 'disabled')
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
                        url: 'm_inventory/delete.php',
                        type: 'post',
                        data: {
                            'deleteformin': noform,
                            'kodeoutlet': '<?= $kodeoutlet ?>',
                        },
                        success: function(hasil) {
                            // alert(hasil);
                            console.log(hasil);
                            //sukses
                            if (hasil == 1) {
                                swal.fire("Gagal!",
                                    "Hapus Data Gagal.",
                                    "error");
                            } else if (hasil == 3) {
                                swal.fire("Deleted!",
                                    "Hapus Data Berhasil.",
                                    "success");
                                $('.hapusformin').removeAttr('disabled')
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
                    $('.hapusformin').removeAttr('disabled')
                }
            });
        })
    })
</script>