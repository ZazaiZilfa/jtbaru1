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
$juhal = "Form PO";
$kodeoutlet = $_SESSION['kodeoutlet'];
// $kodeoutlet = $_SESSION['role_id'];

$kodesupplierr = query("SELECT * FROM supplier01 WHERE kodeoutlet = '$kodeoutlet' AND kodesupplier != 'SUP000' AND namasupplier != 'Central Kitchen' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<?php require "../include/header.php"; ?>

<!-- body start -->

<body onload="sweetfunction()" class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": true}, "topbar": {"color": "light"}, "showRightSidebarOnPageLoad": true}'>

    <!-- Begin page -->
    <div id="wrapper">


        <?php require "../include/topbar.php"; ?>

        <?php require '../include/sidebar.php'; ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <!-- terima msg -->
            <?php if (isset($_SESSION['msg'])) : ?>
                <div id="msg" data-msg="<?= $_SESSION["msg"] ?>"></div>
                <?php unset($_SESSION['msg']); ?>
            <?php endif ?>
            <!-- akhir terima msg -->
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid" style="margin-top: 5px;">

                    <div class="row">
                        <form class="form-horizontal" role="formpo" id="formdinamis" method="POST" action="m_purchasing/input.php">
                            <div class="row mb-2">


                                <div class="col-8 col-xl-2">
                                    <label class="col-4 col-xl-12 col-form-label">Tanggal</label>
                                    <input class="form-control datepicker" type="text" name="tanggal_manual" value="<?= date("d/m/Y"); ?>" placeholder="Tanggal">
                                </div>
                                <div class="col-8 col-xl-2">
                                    <label class="col-4 col-xl-12 col-form-label">Nama Supplier</label>
                                    <select class="form-control select2-single select2" id="supplier" name="supplier" required>
                                        <option value="">Pilih Supplier</option>
                                        <?php foreach ($kodesupplierr as $row) : ?>
                                            <option value="<?= $row["kodesupplier"] ?>">
                                                <?= ucwords($row["namasupplier"]) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-8 col-xl-2">
                                    <label for="pembayaran" class="col-4 col-xl-12 col-form-label">Pembayaran</label>
                                    <select name="pembayaran" id="pembayaran" required class="select2-container form-control select2" data-placeholder="Pembayaran">
                                        <option value="cash">Cash</option>
                                        <option value="hutang">Hutang</option>
                                    </select>
                                </div>
                                <div class="col-8 col-xl-2">
                                    <label for="metodepembayaran" class="col-4 col-xl-12 col-form-label">Metode Pembayaran</label>
                                    <select name=" metodepembayaran" id="metodepembayaran" required class="select2-container form-control select2" data-placeholder="Metode Pembayaran">
                                        <option value="cash">Cash</option>
                                        <option value="transfer">Transfer</option>
                                    </select>
                                </div>
                                <div class="col-8 col-xl-3" style="display: flex;">
                                    <div class="col-4 col-xl-10">
                                        <label class="col-form-label">Total (Sebelum PPN)</label>
                                        <div class="input-group">
                                            <span class="btn btn-primary text-white">Rp</span>
                                            <input type="text" readonly name="total_keseluruhan" id="total-harga" value="0" class="form-control lead text-blue " style="font-size: 1.3  em;">
                                        </div>
                                    </div>
                                    <?php if ($kodeoutlet != 'OUT001') : ?>


                                        <div class="col-4 col-xl-3" style="display: flex;align-items: flex-end;">
                                            <button type="submit" class="btn form-control btn-success waves-effect waves-light" id="simpan">
                                                <span>Simpan</span>
                                            </button>
                                        </div>


                                    <?php endif ?>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-8 col-xl-12">
                                    <!-- <span class="input-group-addon bg-primary b-0 text-white"><i class="ti-search"></i></span> -->
                                    <select class="form-control select2 select2-multiple" id="searchBarang" data-toggle="select2" data-width="100%" multiple="multiple" data-placeholder="Cari Barang....">
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="inputformpo">
                            <div class="col-lg-12">
                                <div class="card" style="height:390px; overflow-y: auto;">
                                    <div class="card-body">
                                        <div class="responsive-table-plugin">
                                            <div class="table-rep-plugin">
                                                <div class="table-responsive" data-pattern="priority-columns">
                                                    <table id="order" class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th width="1%">No</th>
                                                                <th width="40%">Nama Barang</th>
                                                                <th data-priority="1" width="15%">Harga Net</th>
                                                                <th data-priority="1" width="10%">Unit</th>
                                                                <th data-priority="3" width="10%">Jumlah</th>
                                                                <th data-priority="1" width="20%">Subtotal</th>
                                                                <th data-priority="1" width="5%">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Items goes here -->
                                                        </tbody>
                                                    </table>
                                                </div> <!-- end .table-responsive -->

                                            </div> <!-- end .table-rep-plugin-->
                                        </div> <!-- end .responsive-table-plugin-->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end row -->


                </div> <!-- container-fluid -->

            </div> <!-- content -->

            <?php require "../include/rightsidebar.php"; ?>

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

        function isDecimal(n) {
            return Number(n) === n && n % 1 !== 0;
        }

        $('#searchBarang').on('select2:selecting', function(e) {
            e.preventDefault()
            var id = e.params.args.data.id.split("|")[0]
            var nama = e.params.args.data.id.split("|")[1]
            var harga = parseFloat(e.params.args.data.id.split("|")[2])
            var kodebarang = e.params.args.data.id.split("|")[3]
            var unitbeli = e.params.args.data.id.split("|")[4]
            var namaunit = e.params.args.data.id.split("|")[5]
            var jumlah = 1;

            if (isDecimal(harga)) {
                harga = harga.toFixed(2)
            }


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
                            <input type="number" id="harga" step=".01" class="form-control harga hrg-${kodebarang}" name="harga[]" value="${ harga }">
                        </td>
                        <td>
                            <input class=" form-control" readonly type="text" value="${namaunit}">
                        </td>
                        <td>
                            <input id="jumlah" step=".01" min=".01" class="jumlah form-control ${kodebarang}" type="number" name="jumlah[]" value="${jumlah}">
                        </td>
                        <input class=" form-control" type="hidden" name="unitbeli[]" value="${unitbeli}">
                        <td>
                            <input type="text" readonly name="subtotal[]" class="form-control total sub-${kodebarang}" id="subtotal_item" value="${Math.round(harga)}">
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
            swal.fire({
                title: "Input Berhasil!",
                type: "success",
                //text: "I will close in 2 seconds.",
                timer: 1500,
                showConfirmButton: false

            })
            // sleep(1000);
            setTimeout(function() {
                window.location.replace("../purchasing/form-po.php");
            }, 1300);

        } else if (msg == 2) {
            swal.fire("Kode Akun Belum di Pilih!", "", "error")
        } else if (msg == 3) {
            swal.fire("Supplier Belum di Pilih!", "", "error")
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

        if (sum > 0) {
            preventToLeave()
        } else {
            removePreventToLeave()
        }

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
            removePreventToLeave()

            var supplier = $('#supplier').val();

            if (supplier == "Pilih Supplier") {
                swal.fire("Supplier belum di pilih!", "", "error")
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
            var totalFirst = jumlah * harga;
            var total = totalFirst

            if (jumlah % 1 != 0) {
                total = totalFirst + (totalFirst * 1 / 100)
            }

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