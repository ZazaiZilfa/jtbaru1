<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("location:../default/index"); // jika belum login, maka dikembalikan ke index
    exit;
}
require '../include/fungsi.php';
require '../include/fungsi_rupiah.php';
require '../include/fungsi_indotgl.php';
$bagian = "Purchasing";
$juhal = "Data PO";
$kodeoutlet = $_SESSION['kodeoutlet'];
include 'c_purchasing/c_detail-po.php';
$tabel = 'form_po01';
include 'm_purchasing/cek.php';
$jab = $_SESSION['role_id'];

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
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <h4 class="mt-0 header-title">Detail PO <?= $detail['No_form']; ?></h4>
                                    <table class="">
                                        <tr>
                                            <td style="font-weight: 600; width:100px">Tanggal</td>
                                            <td>: <?= tgl_indo($detail['date']); ?> </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 600; width:100px">Supplier</td>
                                            <td>: <?= ucwords($detail['namasupplier']); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 600; width:100px">Alamat</td>
                                            <td>: <?= $detail['alamatsupplier']; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 600; width:100px">Status</td>
                                            <form method="POST">
                                                <input type="hidden" name="status">
                                                <input type="hidden" name="No_form" value="<?= $detail['No_form']; ?>">
                                                <!-- supplier bukan ck -->
                                                <?php if ($detail['kodesupplier'] != 'SUP000') : ?>
                                                    <?php if ($sot == 0 and $sck == 0) : ?>
                                                        <?php if ($jab == '1' || $jab == '0') : ?>
                                                            <td><button type="submit" value="<?= $sot ?>" name="sot" class="btn btn-danger waves-effect waves-light btn-xs m-b-5">Check</button>
                                                            </td>
                                                        <?php else : ?>
                                                            <td><a class="btn btn-danger waves-effect waves-light btn-xs m-b-5">Check</a>
                                                            </td>
                                                        <?php endif ?>


                                                    <?php elseif ($sot == 1 && $sck == 0) : ?>
                                                        <?php if ($jab == '1' || $jab == '0') : ?>
                                                            <td><button type="submit" value="1" name="sck" class="btn btn-info waves-effect waves-light btn-xs m-b-5">Checked
                                                                    by Manager</button>
                                                            </td>
                                                        <?php else : ?>
                                                            <td><a class="btn btn-info waves-effect waves-light btn-xs m-b-5">Checked
                                                                    by Manager</a>
                                                            </td>
                                                        <?php endif ?>
                                                    <?php elseif ($sot == 1  && $sck == 2) : ?>
                                                        <td>
                                                            <a class="btn btn-primary waves-effect waves-light btn-xs m-b-5">Delivery</a>
                                                        </td>
                                                    <?php elseif ($sot == 2  && $sck == 2) : ?>
                                                        <td><a class="btn btn-success waves-effect waves-light btn-xs m-b-5">Delivered</a>
                                                        </td>
                                                    <?php endif ?>

                                                <?php else : ?>
                                                    <!-- supplier CK -->

                                                    <?php if ($sot == 0 && $sck == 0) : ?>
                                                        <?php if ($jab == '1' || $jab == '0' && $kodeoutlet != 'OUT002') : ?>
                                                            <td>
                                                                <button type="submit" value="<?= $sot ?>" name="sot" class="btn btn-danger waves-effect waves-light btn-xs m-b-5">Confirm</button>
                                                            </td>
                                                        <?php else : ?>
                                                            <td><a class="btn btn-danger waves-effect waves-light btn-xs m-b-5">Confirm</a>
                                                            </td>
                                                        <?php endif ?>
                                                    <?php elseif ($sot == 1 && $sck == 0) : ?>
                                                        <?php if ($jab == '1' || $jab == '0' && $kodeoutlet == 'OUT002') : ?>
                                                            <td><button type="submit" value="<?= $sck; ?>" name="sck" class="btn btn-custom waves-effect waves-light btn-xs m-b-5">Checked
                                                                    by Manager</button>
                                                            </td>
                                                        <?php else : ?>
                                                            <td><a class="btn btn-custom waves-effect waves-light btn-xs m-b-5">Acc
                                                                    by OEM</a>
                                                            </td>
                                                        <?php endif ?>
                                                    <?php elseif ($sot == 1 && $sck == 1) : ?>
                                                        <?php if ($jab == '1' || $jab == '0' && $kodeoutlet == 'OUT002') : ?>
                                                            <td><button type="submit" value="<?= $sck; ?>" name="sck" class="btn btn-info waves-effect waves-light btn-xs m-b-5">Checked
                                                                    by CK</button>
                                                            </td>
                                                        <?php else : ?>
                                                            <td><a class="btn btn-info waves-effect waves-light btn-xs m-b-5">Checked
                                                                    by CK</a>
                                                            </td>
                                                        <?php endif ?>
                                                    <?php elseif ($sot == 1  && $sck == 2) : ?>
                                                        <?php if ($jab == '1' || $jab == '0' && $kodeoutlet != 'OUT002') : ?>
                                                            <td><button type="submit" value="<?= $sot; ?>" name="sot" class="btn btn-primary waves-effect waves-light btn-xs m-b-5">Delivery</button>
                                                            </td>
                                                        <?php else : ?>
                                                            <td><a class="btn btn-primary waves-effect waves-light btn-xs m-b-5">Delivery</a>
                                                            </td>
                                                        <?php endif ?>
                                                    <?php elseif ($sot == 2  && $sck == 2) : ?>
                                                        <td><a class="btn btn-success waves-effect waves-light btn-xs m-b-5">Delivered</a>
                                                        </td>
                                                    <?php endif ?>
                                                <?php endif ?>
                                            </form>
                                        </tr>
                                    </table>
                                </div>
                                <div class="pull-right">
                                    <?php if ($sot == 1  && $sck == 0) : ?>

                                        <a href="purchase_order?No_form=<?= $No_form; ?>" target="_blank" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print m-r-5"></i>Cetak PO</a>
                                    <?php elseif ($sot == 1  && $sck == 2) : ?>
                                        <!--<a href="report?No_form=<?= $No_form; ?>" target="_blank" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print m-r-5"></i>Cetak</a>-->
                                        <a href="purchase_order?No_form=<?= $No_form; ?>" target="_blank" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print m-r-5"></i>Cetak PO</a>
                                    <?php endif ?>
                                </div>
                                <div class="card-body table-responsive">
                                    <table id="responsive-datatable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Nama Barang</th>
                                                <th class="text-center">Harga Net</th>
                                                <th class="text-center">Jumlah</th>
                                                <?php if ($sot == 2  && $sck == 2) : ?>
                                                    <th class="text-center">Disc (%)</th>
                                                <?php endif; ?>
                                                <th class="text-center">Unit</th>
                                                <th class="text-center">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $i = 1;
                                        $qtyTotal = 0;
                                        $subTotal = 0;
                                        ?>
                                        <tbody>
                                            <?php foreach ($item_po as $item) :
                                                $qtyTotal = $qtyTotal + $item['qty'];
                                                $subTotal = $subTotal + $item['subtotal'];
                                                $discFormat = '';
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?= $i++;  ?></td>
                                                    <td><?= $item['namabarang']; ?></td>
                                                    <td class="text-right"><?= format_rupiah($item['harga']); ?></td>
                                                    <td class="text-right"><?= $item['qty']  ?></td>
                                                    <?php if ($sot == 2  && $sck == 2) : ?>
                                                        <td class="text-right">
                                                            <?php
                                                            ($item['disc'] > 0) ? $discFormat .= ' ' . $item['disc'] : $discFormat .= '';
                                                            ($detail['diskon1'] > 0) ? $discFormat .= ' ' . $detail['diskon1'] : $discFormat .= '';
                                                            ($detail['diskon2'] > 0) ? $discFormat .= ' ' . $detail['diskon2'] : $discFormat .= '';
                                                            ($detail['diskon3'] > 0) ? $discFormat .= ' ' . $detail['diskon3'] : $discFormat .= ''; ?>
                                                            <?= str_replace(' ', ' + ', ltrim($discFormat)) ?>
                                                        </td>
                                                    <?php endif; ?>
                                                    <td><?= $item['namaunit']  ?></td>
                                                    <td class="text-right"><?= format_rupiah($item['subtotal']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <th colspan="3" class="text-center">Sub Total</th>
                                                <th class="text-right"><?= $qtyTotal ?></th>
                                                <?php if ($sot == 2  && $sck == 2) : ?>
                                                    <th colspan="2"></th>
                                                <?php else : ?>
                                                    <th></th>
                                                <?php endif; ?>
                                                <th class="text-right"><?= format_rupiah($subTotal) ?></th>
                                            </tr>
                                            <?php if ($sot == 2  && $sck == 2) : ?>
                                                <tr>
                                                    <th colspan="6" class="text-center">PPN</th>
                                                    <th class="text-right"><?= format_rupiah($ppn) ?></th>
                                                </tr>
                                            <?php endif; ?>
                                            <tr>
                                                <?php if ($sot == 2  && $sck == 2) : ?>
                                                    <th colspan="6" class="text-center">TOTAL</th>
                                                <?php else : ?>
                                                    <th colspan="5" class="text-center">TOTAL</th>
                                                <?php endif; ?>
                                                <th class="text-right">Rp <?= format_rupiah($grand_total) ?></th>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <a href="javascript:window.close();" class="btn btn-primary"><i class="fa fa-angle-left" style="margin-right: 8px;"></i>Back</a>
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