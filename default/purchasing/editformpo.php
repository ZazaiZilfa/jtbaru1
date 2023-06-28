<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("location:../index"); // jika belum login, maka dikembalikan ke index
    exit;
}
require '../include/fungsi.php';
require '../include/fungsi_rupiah.php';
require '../include/fungsi_indotgl.php';
$bagian = "Purchasing";
$juhal = "Form PO";

$noform = $_GET['noform'];

$formPO = query("SELECT * FROM form_po01 WHERE No_form = '$noform' ORDER BY id")[0];
$tgl = date('d/m/Y', strtotime($formPO['date']));

$itemPO = query("SELECT * FROM item_po01 WHERE No_form = '$noform' ORDER BY id");

$kodeoutlet = $_SESSION['kodeoutlet'];
$kodesupplierr = query("SELECT * FROM supplier01 WHERE kodeoutlet = '$kodeoutlet' AND kodesupplier != 'SUP000' AND namasupplier != 'Central Kitchen' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<?php require "../include/header.php"; ?>

<!-- body start -->


<body onload="sweetfunction()" class="fixed-left">

    <!-- Begin page -->
    <div id="wrapper">



        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content">



            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <form class="form-horizontal" role="formpo" id="formdinamis" method="POST" action="m_purchasing/edit.php">
                            <div class="row mb-2">



                                <?php if ($kondisi['status'] != 1) : ?>
                                    <input type="hidden" name="tanggal_manual" value="<?= $tgl ?>">
                                <?php else : ?>
                                    <div class="col-8 col-xl-2">
                                        <label class="col-4 col-xl-12 col-form-label" for="datepickers">Tanggal </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" name="tanggal_manual" value="<?= $tgl ?>" id="datepickers">
                                            <span class="btn btn-primary b-0 text-white"><i class="ti-calendar"></i></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="col-8 col-xl-2">
                                    <label class="col-8 col-xl-12 col-form-label" for="supplier">Supplier</label>
                                    <select class="form-control select2-single select2" id="supplier" name="supplier" data-placeholder="Pilih supplier">
                                        <option value="">Pilih Supplier</option>
                                        <?php foreach ($kodesupplierr as $row) : ?>
                                            <option value="<?= $row["kodesupplier"] ?>">
                                                <?= ucwords($row["namasupplier"]) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-8 col-xl-2">
                                    <label class="col-8 col-xl-12 col-form-label" for="pembayaran">Pembayaran </label>
                                    <select name="pembayaran" id="pembayaran" required class="form-control select2" data-placeholder="Pembayaran">
                                        <option value="cash">Cash</option>
                                        <option value="hutang">Hutang</option>
                                    </select>
                                </div>
                                <div class="col-8 col-xl-2">
                                    <label class="col-8 col-xl-12 col-form-label" for="metodepembayaran">Metode Pembayaran</label>
                                    <select name="metodepembayaran" id="metodepembayaran" required class="select2-container form-control select2" data-placeholder="Metode Pembayaran">
                                        <option value="cash">Cash</option>
                                        <option value="transfer">Transfer</option>
                                    </select>
                                </div>


                                <div class="col-8 col-xl-4">
                                    <label class="col-4 col-xl-12 col-form-label">Total (Sebelum PPN)</label>
                                    <div class="input-group">
                                        <span class="btn btn-primary b-0 text-white">Rp</span>
                                        <input type="text" readonly name="total_keseluruhan" id="total-harga" value="0" class="form-control text-primary dropcap">
                                        &nbsp;&nbsp;
                                        <?php if ($_SESSION['kodeoutlet'] != 'OUT001') : ?>
                                            <div class="col-8 col-xl-2  ">
                                                <button type="submit" class="btn form-control btn-success waves-effect waves-light" id="simpan">
                                                    <span>Simpan</span>
                                                </button>
                                            </div>
                                        <?php endif ?>
                                    </div>

                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-8 col-xl-12">

                                    <div class="input-group col-4 col-xl-12">
                                        <span class="btn btn-primary b-0 text-white"><i class="ti-search"></i></span>
                                        <select id="searchBarang" class="form-control select2 select2-multiple" data-toggle="select2" data-width="1409px" multiple="multiple" data-placeholder="Cari barang..">
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <input type="hidden" name="editformpo">
                                <input type="hidden" id="noform" name="noform">
                                <div class="card-box" style="height:390px; overflow-y: auto;">
                                    <div class="col-lg-12">
                                        <div class="responsive-table-plugin">
                                            <div class="table-rep-plugin">
                                                <div class="table-responsive" data-pattern="priority-columns">
                                                    <table id="order" class="table table-striped mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th width="1%">No</th>
                                                                <th width="39%">Nama Barang</th>
                                                                <th data-priority="1" width="15%">Harga</th>
                                                                <th data-priority="1" width="10%">Unit</th>
                                                                <th data-priority="3" width="10%">Jumlah</th>
                                                                <th data-priority="1" width="20%">Subtotal</th>
                                                                <th data-priority="1" width="5%">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($itemPO as $item) :
                                                                $unit = $item['unit'];
                                                                $namaunit = query("SELECT namaunit FROM unit01 WHERE kodeunit = '$unit'")[0]['namaunit'];
                                                                $barang = $item['kodebahan'];
                                                                $namabarang = query("SELECT namabarang FROM barang01 WHERE kodebarang = '$barang'")[0]['namabarang'];
                                                            ?>
                                                                <tr>
                                                                    <td class="nomor-urut" style="vertical-align: middle;"></td>
                                                                    <td>
                                                                        <input type="hidden" name="kodebarang[]" class="form-control" value="<?= $item['kodebahan'] ?>">
                                                                        <input readonly type="text" name="namabarang[]" class="form-control" value="<?= $namabarang ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" id="harga" step=".01" class="form-control harga hrg-<?= $item['kodebahan'] ?>" name="harga[]" value="<?= round($item['harga'], 2) ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input class=" form-control" readonly type="text" value="<?= $namaunit ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input id="jumlah" step=".01" min=".01" class="jumlah form-control <?= $item['kodebahan'] ?>" type="number" name="jumlah[]" value="<?= $item['qty'] ?>">
                                                                    </td>
                                                                    <input class=" form-control" type="hidden" name="unitbeli[]" value="<?= $item['unit'] ?>">
                                                                    <td>
                                                                        <input type="text" readonly name="subtotal[]" class="form-control total sub-<?= $item['kodebahan'] ?>" id="subtotal_item" value="<?= round(round($item['harga'], 2) * $item['qty']) ?>">
                                                                    </td>
                                                                    <td>
                                                                        <a href="javascript:void(0);" id="remove" class="btn btn-icon waves-effect waves-light btn-danger m-b-5"><i class="fe-x-square"></i></a>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div>


        <?php //require "../include/footer.php";
        ?>

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->



    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- Vendor js -->
    <script src="../../assets/js/vendor.min.js"></script>

    <!-- third party js -->
    <script src="../../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="../../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="../../assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
    <script src="../../assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../../assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../../assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../../assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../../assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
    <!-- <script src="../../assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="../../assets/libs/pdfmake/build/vfs_fonts.js"></script> -->
    <!-- third party js ends -->

    <!-- Plugins js -->
    <script src="../../assets/libs/moment/min/moment.min.js"></script>
    <script src="../../assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- Plugins js-->
    <script src="../../assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

    <script src="../../assets/libs/multiselect/js/jquery.multi-select.js"></script>
    <script src="../../assets/libs/select2/js/select2.min.js"></script>



    <!-- Sweet alert init js-->
    <script src="../../assets/js/pages/sweet-alerts.init.js"></script>

    <!-- App js-->
    <script src="../../assets/js/app.min.js"></script>




    <script>
        jQuery(document).ready(function() {

            // Select2
            $(".select2").select2();

        });

        // Date Picker
        jQuery('#datepicker').datepicker();
        jQuery('#datepicker-autoclose').datepicker({
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#datepicker-autoclose1').datepicker({
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#datepicker-autoclose2').datepicker({
            autoclose: true,
            todayHighlight: true
        });
    </script>

</body>

</html>

<script>
    $(document).ready(function() {
        $(".select2").select2();
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayHighlight: true,
            orientation: 'auto',
        });

        $('#formdinamis').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $('#supplier').val("<?= $formPO["kodesupplier"] ?>").trigger('change');
        $('#pembayaran').val("<?= $formPO["pembayaran"] ?>").trigger('change');
        $('#metodepembayaran').val("<?= $formPO["metodepembayaran"] ?>").trigger('change');
        $('#noform').val("<?= $noform ?>")

        totalharga();

        $(document).on("input", "[type='number']", function() {
            if ($(this).val().charAt(0) == '0' && /([0-9])/i.test($(this).val().charAt(1))) {
                $(this).val($(this).val().substr(1, $(this).val().length))
            }

            if ($(this).val() == '') {
                $(this).val('0')
            }
        })

        $('#searchBarang').select2({
            minimumInputLength: 2,
            multiple: true,
            ajax: {
                url: "c_purchasing/c_form-po.php",
                type: 'POST',
                data: function(params) {
                    return {
                        'keyword_form-po': params.term
                    }
                },
                processResults: function(response) {
                    var data = JSON.parse("[" + response + "]");
                    for (var i = 0; i < data.length; ++i) {
                        datas = data[i];
                    }

                    return {
                        results: $.map(datas, function(item) {
                            return {
                                text: item.namabarang,
                                id: `${item.id}|${item.namabarang}|${item.hargabeli}|${item.kodebarang}|${item.unitbeli}|${item.namaunit}`,
                            }
                        })
                    };
                },
            }
        });

        $('#searchBarang').on('select2:selecting', function(e) {
            e.preventDefault()
            var id = e.params.args.data.id.split("|")[0]
            var nama = e.params.args.data.id.split("|")[1]
            var harga = e.params.args.data.id.split("|")[2]
            var kodebarang = e.params.args.data.id.split("|")[3]
            var unitbeli = e.params.args.data.id.split("|")[4]
            var namaunit = e.params.args.data.id.split("|")[5]
            var jumlah = 1;
            var check = document.getElementsByClassName(kodebarang)[0];
            if (check != null) {
                var qty = check.value;
                var newQty = parseFloat(qty) + parseFloat(jumlah);
                check.value = newQty;
                var price = parseFloat(document.getElementsByClassName("hrg-" + kodebarang)[0].value);
                var newPrice = price * newQty;
                document.getElementsByClassName("sub-" + kodebarang)[0].value = newPrice;
            } else {
                html =
                    `<tr>
                        <td class="nomor-urut" style="vertical-align: middle;"></td>
                        <td>
                            <input type="hidden" name="kodebarang[]"  class="form-control"  value="${kodebarang}">
                            <input readonly type="text" name="namabarang[]"  class="form-control"  value="${nama}">
                        </td>
                        <td>
                            <input type="number" id="harga" step=".01" class="form-control harga hrg-${kodebarang}" name="harga[]" value="${harga}">
                        </td>
                        <td>
                            <input class=" form-control" readonly type="text" value="${namaunit}">
                        </td>
                        <td>
                            <input id="jumlah" step=".01" min=".01"  class="jumlah form-control ${kodebarang}" type="number" name="jumlah[]" value="${jumlah}">
                        </td>
                        <input class=" form-control" type="hidden" name="unitbeli[]" value="${unitbeli}">
                        <td>
                            <input type="text" readonly name="subtotal[]" class="form-control total sub-${kodebarang}" id="subtotal_item" value="${harga}">
                        </td>
                        <td>
                            <a href="javascript:void(0);" id="remove" class="btn btn-icon waves-effect waves-light btn-danger m-b-5"><i class="fe-x-square"></i></a>
                        </td>
                    </tr>`;
                $("#order>tbody").append(html);
            }
            totalharga();
            $('#searchBarang').select2('close');
        })
    })

    function sweetfunction() {

        const msg = $('#msg').data('msg');

        if (msg == 1) {
            swal({
                title: "Input Berhasil!",
                type: "success",
                //text: "I will close in 2 seconds.",
                timer: 1500,
                showConfirmButton: false

            })
            // sleep(1000);
            setTimeout(function() {
                window.location.replace("../purchasing/");
            }, 1300);

        } else if (msg == 2) {
            swal("Kode Akun Belum di Pilih!", "", "error")
        } else if (msg == 3) {
            swal("Supplier Belum di Pilih!", "", "error")
        }

    }

    function currencyFormat(num) {
        return (
            num
            .toFixed(0) // always two decimal digits
            .replace('.', ',') // replace decimal point character with ,
            .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
        ) // use . as a separator
    }

    function totalharga() {
        var sum = 0;
        $(".total").each(function() {
            sum += parseFloat($(this).val());
        });

        // if(sum > 0) {
        //     preventToLeave()
        // } else {
        //     removePreventToLeave()
        // }

        $("#total-harga").val(currencyFormat(sum));
        // $("#totalPrice").text('Rp. ' + sum);

        document.querySelectorAll('.nomor-urut').forEach((num, i) => {
            var orderNumber = i + 1
            num.innerText = ""
            num.innerText = orderNumber
        })

    }
    $(document).ready(function() {
        $('#formdinamis').submit(function(e) {
            // removePreventToLeave()

            var supplier = $('#supplier').val();

            if (supplier == "Pilih Supplier") {
                swal("Supplier belum di pilih!", "", "error")
                e.preventDefault();
            }
            // else {

            //     $('#formdinamis').submit();
            // }
        })

        $(document).on("click", "#remove", function() {
            $(this).closest("tr").remove();
            totalharga();
        });

        $(document).on("input", "#jumlah", function() {
            var jumlah = parseFloat($(this).val());
            var harga = parseFloat($(this).closest("tr").find(".harga").val());
            var total = jumlah * harga;

            $(this).closest("tr").find("input#subtotal_item").val(Math.round(total));

            totalharga();
        });

        $(document).on("input", "#harga", function() {
            var harga = parseFloat($(this).val());
            var jumlah = parseFloat($(this).closest("tr").find(".jumlah").val());
            var total = jumlah * harga;

            $(this).closest("tr").find("input#subtotal_item").val(Math.round(total));

            totalharga();
        });


    })
</script>