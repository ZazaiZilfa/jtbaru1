<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("location:../default/index"); // jika belum login, maka dikembalikan ke index
    exit;
}
require '../include/fungsi.php';
require '../include/fungsi_rupiah.php';
require '../include/fungsi_indotgl.php';
require 'c_purchasing/c_barangmasuk.php';
$bagian = "Purchasing";
$juhal = "Form In";
$kodeoutlet = $_SESSION['kodeoutlet'];
$form = query("SELECT * FROM form_po01 JOIN supplier01 ON form_po01.kodesupplier = supplier01.kodesupplier WHERE form_po01.kodeoutlet = '$kodeoutlet' AND supplier01.kodeoutlet = '$kodeoutlet' AND (form_po01.status_ck='2' AND form_po01.status_ot='1')");
$dateNow = date("d/m/Y");
$tglTempo = date('m/d/Y', strtotime('+14 days', strtotime(date("m/d/Y"))));
?>

<!DOCTYPE html>
<html lang="en">

<?php require "../include/header.php"; ?>

<!-- body start -->

<body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": true}, "topbar": {"color": "light"}, "showRightSidebarOnPageLoad": true}'>

    <!-- Begin page -->
    <div id="wrapper">
        <style>
            .dropcap {
                font-size: 1.3em;
            }

            .table-responsive {
                overflow-x: unset !important;
            }
        </style>

        <?php require "../include/topbar.php"; ?>

        <?php require '../include/sidebar.php'; ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- terima msg -->
                <?php if (isset($_SESSION['msg'])) : ?>
                    <div id="msg" data-msg="<?= $_SESSION["msg"] ?>"></div>
                    <?php unset($_SESSION['msg']); ?>
                <?php endif ?>
                <!-- akhir terima msg -->

                <!-- Start Content-->
                <div class="container-fluid">
                    <form id="formPO" action="" method="POST">
                        <input type="hidden" name="keyword_bahan_masuk">
                    </form>

                    <form class="form-horizontal" id="formIn" role="formpo" method="POST" action="m_purchasing/input.php">
                        <div class="row">

                            <?php if (isset($detail)) :
                                $dateRaw = $detail['date'];
                                $dateNew =  explode('-', $dateRaw);
                                $dateNow = $dateNew[2] . '/' . $dateNew[1] . '/' . $dateNew[0];
                                $dateNow2 = $dateNew[1] . '/' . $dateNew[2] . '/' . $dateNew[0];
                                $tglTempo = date('d/m/Y', strtotime('+14 days', strtotime($dateNow2)));
                            endif
                            ?>
                            <?php if ($kondisi['status'] != 1) : ?>
                                <input type="hidden" name="tanggal_manual" value="<?= $dateNow ?>">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="col-4 col-xl-6 col-form-label">Tgl jatuh tempo</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker datepicker-tempo" name="tgl_tempo" value="<?= $tglTempo ?>">
                                            <span class="btn btn-primary text-white"><i class="ti-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="col-4 col-xl-6 col-form-label">Tgl Barang Datang</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker datepicker-datang" name="tanggal_manual" value="<?= $dateNow ?>">
                                            <span class="btn btn-primary text-white"><i class="ti-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="col-4 col-xl-6 col-form-label">Tgl jatuh tempo</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker datepicker-tempo" name="tgl_tempo" value="<?= $tglTempo ?>">
                                            <span class="btn btn-primary text-white"><i class="ti-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="col-4 col-xl-4 col-form-label">Diskon 1</label>
                                    <div class="input-group">
                                        <input type="number" min="0" max="100" class="form-control diskon1" name="diskon1" value="0" step=".01">
                                        <span class="btn btn-primary b-0 text-white">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="col-4 col-xl-4 col-form-label">Diskon 2</label>
                                    <div class="input-group">
                                        <input type="number" min="0" max="100" class="form-control diskon2" name="diskon2" value="0" step=".01">
                                        <span class="btn btn-primary b-0 text-white">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="col-4 col-xl-4 col-form-label">Diskon 3</label>
                                    <div class="input-group">
                                        <input type="number" min="0" max="100" class="form-control diskon3" name="diskon3" value="0" step=".01">
                                        <span class="btn btn-primary b-0 text-white">%</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label class="col-4 col-xl-4 col-form-label">No Faktur</label>
                                    <div class="input-group">

                                        <span class="btn btn-primary b-0 text-white dropcap">Faktur</span>
                                        <input type="text" required id="nofaktur" class="form-control" name="nofaktur">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label class="col-4 col-xl-4 col-form-label">Total + PPn (
                                        <select name="ppn_percent" id="ppnPercent" required>
                                            <option value="11" selected="selected">11%</option>
                                            <option value="10">10%</option>
                                        </select> )
                                    </label>
                                    <div class="input-group">
                                        <span class="btn btn-primary b-0 text-white">Rp</span>
                                        <input type="text" readonly name="total_keseluruhan" id="total-harga" class="form-control text-primary dropcap">
                                        <input type="hidden" name="ppn" id="ppn" class="form-control text-primary dropcap">

                                        <?php if ($_SESSION['kodeoutlet'] != 'OUT001') : ?>

                                            <button type="submit" class="col-4 col-xl-2 btn col-form-control btn-success waves-effect waves-light" id="simpan">
                                                <span>Save</span>
                                            </button>

                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <select id="selectPO" class="form-control select2" name="keyword_bahan_masuk">
                                        <option>Pilih No PO / Nama Supplier</option>
                                        <?php foreach ($form as $f) : ?>
                                            <option value="<?= $f['No_form']; ?>"> <?= tgl_indo($f['date']); ?> ||
                                                <?= $f['No_form']; ?> ||
                                                <?= $f['namasupplier']; ?> </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <input type="hidden" name="inputformin">
                            <input type="hidden" id="changePrice" name="changeprice" value="1">
                            <input type="hidden" id="submitCondition" value="false">
                            <div class="card-box" style="height:400px; overflow-y: auto;">
                                <div class="col-lg-12">
                                    <div class="card" style="height:390px; overflow-y: auto;">
                                        <div class="card-body">
                                            <div class="responsive-table-plugin">
                                                <div class="table-rep-plugin">
                                                    <div class="table-responsive" data-pattern="priority-columns">
                                                        <div class="col-6 m-b-10">
                                                            <?php if (isset($detail)) : ?>
                                                                <table class="">
                                                                    <tr>
                                                                        <td style="font-weight: 600; width:100px">No. PO
                                                                        </td>
                                                                        <td>: <?= $detail['No_form']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="font-weight: 600; width:100px">Supplier</td>
                                                                        <td>: <?= $detail['namasupplier']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="font-weight: 600; width:100px">Alamat</td>
                                                                        <td>: <?= $detail['alamatsupplier']; ?></td>
                                                                    </tr>
                                                                </table>
                                                            <?php endif ?>
                                                        </div>
                                                        <table id="order" class="table table-striped mb-0">
                                                            <thead class="form-in">
                                                                <tr>
                                                                    <th width="41%">Nama Barang</th>
                                                                    <th data-priority="1" width="14%">Harga Net</th>
                                                                    <th data-priority="1" width="8%">Unit</th>
                                                                    <th data-priority="3" width="10%">Jumlah</th>
                                                                    <th data-priority="1" width="10%">Disc</th>
                                                                    <th data-priority="1" width="15%">Subtotal</th>
                                                                    <th data-priority="1" width="2%">Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if (isset($item_po)) :
                                                                    $qtyTotal = 0; ?>
                                                                    <?php foreach ($item_po as $item) :
                                                                        $qtyTotal = $qtyTotal + $item['qty'];
                                                                        $kodebarang = $item['kodebarang'];
                                                                        $realPrice = query("SELECT hargabeli FROM barang01 WHERE kodebarang = '$kodebarang' LIMIT 1")[0]['hargabeli'];
                                                                    ?>
                                                                        <tr>
                                                                            <input type="hidden" name="noform" value="<?= $detail['No_form']; ?>">
                                                                            <input type="hidden" name="kodesupplier" value="<?= $detail['kodesupplier']; ?>">
                                                                            <input type="hidden" name="kodebahan[]" value="<?= $item["kodebarang"]; ?>">
                                                                            <input type="hidden" name="unit[]" value="<?= $item["unit"]; ?>">
                                                                            <td><input readonly type="text" class="form-control namabarang" value="<?= $item['namabarang']; ?>"></td>
                                                                            <td><input type="number" min="0" step=".01" name="harga[]" class="form-control harga" value="<?= $item['harga']; ?>" data-real-value="<?= $realPrice ?>"></td>
                                                                            <td><input readonly type="text" class="form-control" value="<?= $item['namaunit']; ?>"></td>
                                                                            <td><input type="number" id="qty" step=".01" min=".01" name="qty[]" class="form-control qty" value="<?= $item['qty']; ?>"></td>
                                                                            <td><input type="number" id="disc" step=".01" min="0" max="100" name="disc[]" class="form-control disc" value="0"></td>
                                                                            <td><input readonly name="subtotal[]" type="number" class="form-control subtotal text-right" value="<?= $item['subtotal']; ?>"></td>
                                                                            <input readonly name="subtotalasli[]" type="hidden" class="form-control subtotalasli" value="<?= $item['subtotal']; ?>">
                                                                            <td><a href="javascript:void(0);" class="btn btn-icon waves-effect waves-light btn-danger m-b-5 delete">
                                                                                    <i class="fe-x-square"></i> </a></td>
                                                                        </tr>
                                                                    <?php endforeach ?>
                                                                <?php endif ?>
                                                            </tbody>
                                                            <?php if (isset($item_po)) : ?>
                                                                <tfoot class="form-in">
                                                                    <tr>
                                                                        <th colspan="3" style="vertical-align: middle;" class="text-center">Sub Total</th>
                                                                        <td><input type="number" value="<?= $qtyTotal ?>" readonly id="qtyTotal" class="form-control">
                                                                        </td>
                                                                        <td colspan="3"></td>
                                                                    </tr>
                                                                </tfoot>
                                                            <?php endif ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- end row -->


            </div> <!-- container-fluid -->
        </div>
    </div> <!-- content -->

    <?php require "../include/rightsidebar.php"; ?>

    <?php require "../include/footer.php"; ?>

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

            $('form#formIn').submit(function(e) {

                if (document.getElementById("submitCondition").value == 'false') {
                    e.preventDefault();

                    let valueMin = 0;
                    let valueNameMin = '';

                    $(".harga").each(function() {
                        if (parseFloat($(this).val()) > parseFloat($(this).data('realValue'))) {
                            valueNameMin += $(this).closest("tr").find(".namabarang").val() +
                                ' | Rp ' + currencyFormat($(this).data('realValue')) +
                                ' < Rp ' + currencyFormat(parseFloat($(this).val())) + '\n'
                            valueMin++
                        }
                    });

                    if (valueMin > 0) {
                        swal.fire({
                            title: "Update harga dasar barang berikut?",
                            text: `${valueNameMin}`,
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: '#DD6B55',
                            confirmButtonText: 'Update',
                            cancelButtonText: "Tidak",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        }).then((isConfirm) => {
                            if (isConfirm.isConfirmed) {
                                document.getElementById("changePrice").value = 1
                                swal.fire("Updated!", "Please wait..", "success");
                            } else {
                                document.getElementById("changePrice").value = 0
                                swal.fire("Submited", "Please wait..", "success");
                            }
                            document.getElementById("submitCondition").value = 'true'
                            $('form#formIn').submit()
                        });
                    } else {
                        document.getElementById("submitCondition").value = 'true'
                        $('form#formIn').submit()
                    }
                }
            })

            $("#selectPO").change(function() {
                $("#formPO input").val($(this).val())
                $("#formPO").submit();
            });

            $(document).on("input", "[type='number']", function() {
                if ($(this).val().charAt(0) == '0' && /([0-9])/i.test($(this).val().charAt(1))) {
                    $(this).val($(this).val().substr(1, $(this).val().length))
                }

                if ($(this).val() == '') {
                    $(this).val('0')
                }
            })

            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
                orientation: 'auto',
            });

            if (document.querySelector('.datepicker-datang')) {
                $('.datepicker-datang').datepicker('update', "<?= $dateNow ?>");
            }

            $('.datepicker-tempo').datepicker('update', "<?= $tglTempo ?>");

            totalharga();
            $(document).on("input", ".diskon1", function() {
                var diskon1 = parseFloat($(this).val());
                var diskon2 = parseFloat($('.diskon2').val());
                var diskon3 = parseFloat($('.diskon3').val());

                $('.subtotalasli').each(function(key, index) {
                    var subtotal = parseFloat($(this).val())
                    var subtotalNew = document.querySelectorAll('.subtotal')

                    if (diskon1 == '0') {
                        var hdiskon1 = parseFloat(subtotal)
                        subtotalNew[key].value = Math.round(hdiskon1);
                    } else {
                        var hdiskon1 = parseFloat(subtotal - (subtotal * (diskon1 / 100)))
                        subtotalNew[key].value = Math.round(hdiskon1);
                    }

                    if (diskon2 == '0') {
                        var hdiskon2 = parseFloat(hdiskon1)
                        subtotalNew[key].value = Math.round(hdiskon2);
                    } else {
                        var hdiskon2 = parseFloat(hdiskon1 - (hdiskon1 * (diskon2 / 100)))
                        subtotalNew[key].value = Math.round(hdiskon2);
                    }

                    if (diskon3 == '0') {
                        var hdiskon3 = parseFloat(hdiskon2)
                        subtotalNew[key].value = Math.round(hdiskon3);
                    } else {
                        var hdiskon3 = parseFloat(hdiskon2 - (hdiskon2 * (diskon3 / 100)))
                        subtotalNew[key].value = Math.round(hdiskon3);
                    }
                })
                totalharga();
            });
            $(document).on("input", ".diskon2", function() {
                var diskon1 = parseFloat($('.diskon1').val());
                var diskon2 = parseFloat($(this).val());
                var diskon3 = parseFloat($('.diskon3').val());

                $('.subtotalasli').each(function(key, index) {
                    var subtotal = parseFloat($(this).val())
                    var subtotalNew = document.querySelectorAll('.subtotal')

                    if (diskon1 == '0') {
                        var hdiskon1 = parseFloat(subtotal)
                        subtotalNew[key].value = Math.round(hdiskon1);
                    } else {
                        var hdiskon1 = parseFloat(subtotal - (subtotal * (diskon1 / 100)))
                        subtotalNew[key].value = Math.round(hdiskon1);
                    }

                    if (diskon2 == '0') {
                        var hdiskon2 = parseFloat(hdiskon1)
                        subtotalNew[key].value = Math.round(hdiskon2);
                    } else {
                        var hdiskon2 = parseFloat(hdiskon1 - (hdiskon1 * (diskon2 / 100)))
                        subtotalNew[key].value = Math.round(hdiskon2);
                    }

                    if (diskon3 == '0') {
                        var hdiskon3 = parseFloat(hdiskon2)
                        subtotalNew[key].value = Math.round(hdiskon3);
                    } else {
                        var hdiskon3 = parseFloat(hdiskon2 - (hdiskon2 * (diskon3 / 100)))
                        subtotalNew[key].value = Math.round(hdiskon3);
                    }
                })
                totalharga();
            });
            $(document).on("input", ".diskon3", function() {
                var diskon1 = parseFloat($('.diskon1').val());
                var diskon2 = parseFloat($('.diskon2').val());
                var diskon3 = parseFloat($(this).val());

                $('.subtotalasli').each(function(key, index) {
                    var subtotal = parseFloat($(this).val())
                    var subtotalNew = document.querySelectorAll('.subtotal')

                    if (diskon1 == '0') {
                        var hdiskon1 = parseFloat(subtotal)
                        subtotalNew[key].value = Math.round(hdiskon1);
                    } else {
                        var hdiskon1 = parseFloat(subtotal - (subtotal * (diskon1 / 100)))
                        subtotalNew[key].value = Math.round(hdiskon1);
                    }

                    if (diskon2 == '0') {
                        var hdiskon2 = parseFloat(hdiskon1)
                        subtotalNew[key].value = Math.round(hdiskon2);
                    } else {
                        var hdiskon2 = parseFloat(hdiskon1 - (hdiskon1 * (diskon2 / 100)))
                        subtotalNew[key].value = Math.round(hdiskon2);
                    }

                    if (diskon3 == '0') {
                        var hdiskon3 = parseFloat(hdiskon2)
                        subtotalNew[key].value = Math.round(hdiskon3);
                    } else {
                        var hdiskon3 = parseFloat(hdiskon2 - (hdiskon2 * (diskon3 / 100)))
                        subtotalNew[key].value = Math.round(hdiskon3);
                    }
                })
                totalharga();
            });

            $(document).on("input", ".harga", function() {
                var diskon1 = parseFloat($('.diskon1').val());
                var diskon2 = parseFloat($('.diskon2').val());
                var diskon3 = parseFloat($('.diskon3').val());

                var harga = parseFloat($(this).val());
                var jumlah = parseFloat($(this).closest("tr").find(".qty").val());
                var disc = parseFloat($(this).closest("tr").find(".disc").val());
                if (disc > 0) {
                    var total = parseFloat((jumlah * harga) - ((jumlah * harga) * (disc / 100)));
                } else {
                    var total = parseFloat(jumlah * harga);
                }

                $(this).closest("tr").find("input.subtotal").val(Math.round(total));
                $(this).closest("tr").find("input.subtotalasli").val(Math.round(total));

                var subtotal = $(this).closest("tr").find("input.subtotalasli")
                var subtotalNew = $(this).closest("tr").find("input.subtotal")

                if (diskon1 == '0') {
                    var hdiskon1 = parseFloat(subtotal.val())
                    subtotalNew.val(Math.round(hdiskon1));
                } else {
                    var hdiskon1 = parseFloat(subtotal.val() - (subtotal.val() * (diskon1 / 100)))
                    subtotalNew.val(Math.round(hdiskon1));
                }

                if (diskon2 == '0') {
                    var hdiskon2 = parseFloat(hdiskon1)
                    subtotalNew.val(Math.round(hdiskon2));
                } else {
                    var hdiskon2 = parseFloat(hdiskon1 - (hdiskon1 * (diskon2 / 100)))
                    subtotalNew.val(Math.round(hdiskon2));
                }

                if (diskon3 == '0') {
                    var hdiskon3 = parseFloat(hdiskon2)
                    subtotalNew.val(Math.round(hdiskon3));
                } else {
                    var hdiskon3 = parseFloat(hdiskon2 - (hdiskon2 * (diskon3 / 100)))
                    subtotalNew.val(Math.round(hdiskon3));
                }

                totalharga();
            });
            $(document).on("input", ".qty", function() {
                var diskon1 = parseFloat($('.diskon1').val());
                var diskon2 = parseFloat($('.diskon2').val());
                var diskon3 = parseFloat($('.diskon3').val());

                var jumlah = parseFloat($(this).val());
                var harga = parseFloat($(this).closest("tr").find(".harga").val());
                var disc = parseFloat($(this).closest("tr").find(".disc").val());

                qtyTotals = 0;

                document.querySelectorAll('.qty').forEach(qtyTotal => {
                    qtyTotals += parseFloat(qtyTotal.value)
                })

                $('#qtyTotal').val(qtyTotals)

                if (disc > 0) {
                    var total = parseFloat((jumlah * harga) - ((jumlah * harga) * (disc / 100)));
                } else {
                    var total = parseFloat(jumlah * harga);
                }

                $(this).closest("tr").find("input.subtotal").val(Math.round(total));
                $(this).closest("tr").find("input.subtotalasli").val(Math.round(total));

                var subtotal = $(this).closest("tr").find("input.subtotalasli")
                var subtotalNew = $(this).closest("tr").find("input.subtotal")

                if (diskon1 == '0') {
                    var hdiskon1 = parseFloat(subtotal.val())
                    subtotalNew.val(Math.round(hdiskon1));
                } else {
                    var hdiskon1 = parseFloat(subtotal.val() - (subtotal.val() * (diskon1 / 100)))
                    subtotalNew.val(Math.round(hdiskon1));
                }

                if (diskon2 == '0') {
                    var hdiskon2 = parseFloat(hdiskon1)
                    subtotalNew.val(Math.round(hdiskon2));
                } else {
                    var hdiskon2 = parseFloat(hdiskon1 - (hdiskon1 * (diskon2 / 100)))
                    subtotalNew.val(Math.round(hdiskon2));
                }

                if (diskon3 == '0') {
                    var hdiskon3 = parseFloat(hdiskon2)
                    subtotalNew.val(Math.round(hdiskon3));
                } else {
                    var hdiskon3 = parseFloat(hdiskon2 - (hdiskon2 * (diskon3 / 100)))
                    subtotalNew.val(Math.round(hdiskon3));
                }

                totalharga();
            });
            $(document).on("input", ".disc", function() {
                var diskon1 = parseFloat($('.diskon1').val());
                var diskon2 = parseFloat($('.diskon2').val());
                var diskon3 = parseFloat($('.diskon3').val());

                var disc = parseFloat($(this).val());
                var harga = parseFloat($(this).closest("tr").find(".harga").val());
                var jumlah = parseFloat($(this).closest("tr").find(".qty").val());
                if (disc > 0) {
                    var total = parseFloat((jumlah * harga) - ((jumlah * harga) * (disc / 100)));
                } else {
                    var total = parseFloat(jumlah * harga);
                }
                // console.log(total)
                $(this).closest("tr").find("input.subtotal").val(Math.round(total));
                $(this).closest("tr").find("input.subtotalasli").val(Math.round(total));

                var subtotal = $(this).closest("tr").find("input.subtotalasli")
                var subtotalNew = $(this).closest("tr").find("input.subtotal")

                if (diskon1 == '0') {
                    var hdiskon1 = parseFloat(subtotal.val())
                    subtotalNew.val(Math.round(hdiskon1));
                } else {
                    var hdiskon1 = parseFloat(subtotal.val() - (subtotal.val() * (diskon1 / 100)))
                    subtotalNew.val(Math.round(hdiskon1));
                }

                if (diskon2 == '0') {
                    var hdiskon2 = parseFloat(hdiskon1)
                    subtotalNew.val(Math.round(hdiskon2));
                } else {
                    var hdiskon2 = parseFloat(hdiskon1 - (hdiskon1 * (diskon2 / 100)))
                    subtotalNew.val(Math.round(hdiskon2));
                }

                if (diskon3 == '0') {
                    var hdiskon3 = parseFloat(hdiskon2)
                    subtotalNew.val(Math.round(hdiskon3));
                } else {
                    var hdiskon3 = parseFloat(hdiskon2 - (hdiskon2 * (diskon3 / 100)))
                    subtotalNew.val(Math.round(hdiskon3));
                }

                totalharga();
            });

            $(document).on("change", "#ppnPercent", function() {
                totalharga();
            })

            $(document).on("click", ".delete", function() {
                $(this).closest("tr").remove();

                qtyTotals = 0;

                document.querySelectorAll('.qty').forEach(qtyTotal => {
                    qtyTotals += parseFloat(qtyTotal.value)
                })

                $('#qtyTotal').val(qtyTotals)

                totalharga();
            });
            $(document).on("click", "#simpan", function() {
                removePreventToLeave()
                // console.log($(this).serialize());
            });
        })

        function currencyFormat(num) {
            return (
                Number(num)
                .toFixed(0) // always two decimal digits
                .replace('.', ',') // replace decimal point character with ,
                .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
            ) // use . as a separator
        }

        function totalharga() {
            var sum = 0;
            $(".subtotal").each(function() {
                sum += parseFloat($(this).val());
            })

            if (sum > 0) {
                preventToLeave()
            } else {
                removePreventToLeave()
            }

            // console.log(sum)
            // var ppn = Math.round(sum * (<?= $globalPPN ?> / 100))
            var ppnPercent = $('#ppnPercent').val()
            var ppn = Math.round(sum * (ppnPercent / 100))
            var sumppn = parseFloat(sum + ppn)

            $("#total-harga").val(currencyFormat(sumppn));
            $("#ppn").val(currencyFormat(ppn));
        }

        function sweetfunction() {

            const msg = $('#msg').data('msg');
            if (msg == 1) {
                swal.fire({
                    title: "Input Berhasil!",
                    type: "success",
                    //text: "I will close in 2 seconds.",
                    timer: 1100,
                    showConfirmButton: false
                })
            } else if (msg < 1) {
                swal.fire("Input Gagal!", "", "error")
            }
        }
    </script>
</body>

</html>
<script>

</script>