<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("location:../default/index"); // jika belum login, maka dikembalikan ke index
    exit;
}
require '../include/fungsi.php';
require '../include/fungsi_rupiah.php';
require '../include/fungsi_indotgl.php';
require 'c_datamaster/c_barang.php';
$bagian = "Data Master";
$juhal = "Barang";
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
                                <div class="card-body">

                                    <h4 class="mb-3 header-title">Form Input <?= $juhal ?></h4>
                                    <form class="form-horizontal" id="formbarang">
                                        <div class="row">

                                            <div class="col-lg-3">

                                                <input type="hidden" value="inputbarang" id="inputbarang" name="inputbarang">
                                                <input type="hidden" value="<?= $kodeoutlet; ?>" id="kodeoutlet" name="kodeoutlet">
                                                <div class="mb-1">
                                                    <label class="col-4 col-xl-8 col-form-label">Kategori Barang</label>
                                                    <div class="col-8 col-xl-10  ">
                                                        <select class="form-select select2" name="kategoribarang" id="kategoribarang">
                                                            <option value=""></option>
                                                            <?php foreach ($kategoribarang as $row) : ?>
                                                                <option value="<?= $row["kodekategoribarang"] ?>">
                                                                    <?= ucwords($row['namakategoribarang'])  ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="mb-1">
                                                    <label class="col-4 col-xl-8 col-form-label">Sub Kategori Barang</label>
                                                    <div class="col-8 col-xl-10  ">
                                                        <select class="form-select select2" name="subkategoribarang" id="subkategoribarang">
                                                            <option value=""></option>
                                                            <?php foreach ($subkatbarang as $row) : ?>
                                                                <option value="<?= $row["kodesubkatbarang"] ?>">
                                                                    <?= ucwords($row['namasubkatbarang'])  ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="mb-1">
                                                    <label class="col-4 col-xl-8 col-form-label">Nama <?= $juhal ?></label>
                                                    <div class="col-8 col-xl-10">
                                                        <input autofocus type="text" class="form-control" required name="nbarang" id="nbarang" placeholder="Nama Barang">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-3">

                                                <div class="mb-1">
                                                    <label class="col-4 col-xl-8 col-form-label">Harga Beli</label>
                                                    <div class="col-8 col-xl-10">
                                                        <input type="text" class="form-control" required name="hargabeli" id="hargabeli" placeholder="Harga Beli">
                                                    </div>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="col-4 col-xl-8 col-form-label">Unit </label>
                                                    <div class="col-8 col-xl-10  ">
                                                        <select class="form-select select2" name="nunit" id="nunit">
                                                            <option></option>
                                                            <?php foreach ($unit as $row) : ?>
                                                                <option value="<?= $row["kodeunit"] ?>">
                                                                    <?= ucwords($row['namaunit'])  ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="mb-1">
                                                    <input type="hidden" class="form-control" required name="rak1" id="rak1" value="0"></input>
                                                </div>
                                                <div class="mb-1">
                                                    <input type="hidden" class="form-control" required name="dept1" id="dept1" value="0"></input>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="col-4 col-xl-8 col-form-label">Supplier</label>
                                                    <div class="col-8 col-xl-10  ">
                                                        <select class="form-select select2" name="supplier1" id="supplier1">
                                                            <option></option>
                                                            <?php foreach ($supplier as $row) : ?>
                                                                <option value="<?= $row["kodesupplier"] ?>">
                                                                    <?= ucwords($row['namasupplier'])  ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-lg-3">

                                                <div class="mb-1">
                                                    <label class="col-4 col-xl-8 col-form-label">Kode item</label>
                                                    <div class="col-8 col-xl-10">
                                                        <input type="text" class="form-control" required name="kodeitem1" id="kodeitem1" placeholder="Kode Item">
                                                    </div>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="col-4 col-xl-8 col-form-label">Kode Barcode</label>
                                                    <div class="col-8 col-xl-10">
                                                        <input type="text" class="form-control" required name="kodebarcode1" id="kodebarcode1" placeholder="Kode Barcode">
                                                    </div>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="col-4 col-xl-8 col-form-label">Merk</label>
                                                    <div class="col-8 col-xl-10">
                                                        <input type="text" class="form-control" required name="merk1" id="merk1" placeholder="Merk">
                                                    </div>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="col-4 col-xl-8 col-form-label">Harga Jual 1</label>
                                                    <div class="col-8 col-xl-10">
                                                        <input type="text" class="form-control" required name="hargajual1" id="hargajual1" placeholder="Harga Jual 1">
                                                    </div>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="col-4 col-xl-8 col-form-label">Harga jual 2</label>
                                                    <div class="col-8 col-xl-10">
                                                        <input type="text" class="form-control" required name="hargajual2" id="hargajual2" placeholder="Harga Jual 2">
                                                    </div>
                                                </div>
                                                <div class="mb-1">
                                                    <input type="hidden" value="" class="form-control" name="nunitjual" id="nunitjual">
                                                </div>
                                            </div>

                                            <div class="col-lg-3">

                                                <div class="mb-1">
                                                    <label class="col-4 col-xl-8 col-form-label">Stok</label>
                                                    <div class="col-8 col-xl-10">
                                                        <input type="text" class="form-control" required name="stok" id="stok" placeholder="Jumlah Stok">
                                                    </div>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="col-4 col-xl-8 col-form-label">Minimal Stok</label>
                                                    <div class="col-8 col-xl-10">
                                                        <input type="text" class="form-control" required name="minstok" id="minstok" placeholder="Minimal Stok">
                                                    </div>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="col-4 col-xl-8 col-form-label">Keterangan</label>
                                                    <div class="col-8 col-xl-10">
                                                        <input type="text" class="form-control" name="keterangan1" id="keterangan1">
                                                    </div>
                                                </div>
                                                <div class=mb-1>
                                                    <input name="status" type="hidden" value="0" class="form-control">
                                                </div>
                                            </div>

                                            <div class="justify-content-end row">
                                                <div class="col-8 col-xl-8">
                                                    <button type="submit" class="btn btn-info waves-effect waves-light" name="tombol-barang" id="tambah-barang">Input Barang</button>
                                                </div>
                                            </div>

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
                                <div class="card-body table-responsive ">
                                    <h4 class="mt-0 header-title">Daftar Barang</h4>


                                    <table id="responsive-datatable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="1%">No</th>
                                                <th width="3%">Kategori</th>
                                                <th width="15%">Nama Barang</th>
                                                <th width="5%">Merk</th>
                                                <th width="3%">Stok</th>
                                                <th width="10%">Harga Beli</th>
                                                <th width="10%">Proc 1</th>
                                                <th width="10%">Proc 2 </th>
                                                <th width="10%">HJ1</th>
                                                <th width="10%">HJ2</th>
                                                <th width="2%">Unit</th>
                                                <th width="1%">Min Stok</th>
                                                <th width="10$">Supplier</th>
                                                <th width="3%">action</th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            <?php $i = 1; ?>

                                            <?php foreach ($barang as $row) :
                                                $kodesubkatbarang = $row["subkatbarang"];
                                                $hb = $row["hargabeli"];
                                                if ($hb == 0) {
                                                    $hb = 1;
                                                }
                                                $hj1 = $row["hargajual1"];
                                                if ($hj1 == 0) {
                                                    $hj1 = 1;
                                                }
                                                $hj2 = $row["hargajual2"];
                                                if ($hj2 == 0) {
                                                    $hj2 = 1;
                                                }
                                            ?>

                                                <tr>
                                                    <td width="1%"><?= $i ?></td>

                                                    <td width="3%">
                                                        <?php
                                                        $kodekategoribarang = $row["kategoribarang"];
                                                        echo query("SELECT namakategoribarang FROM kategoribarang02 WHERE kodekategoribarang = '$kodekategoribarang'")[0]['namakategoribarang'];
                                                        ?>
                                                    </td>

                                                    <td width="15%"><?= $row["namabarang"] ?></td>
                                                    <td width="5%"><?= $row["merk"] ?></td>
                                                    <td width="3%"><?= $row["stok"] ?></td>
                                                    <td width="10%"><?= format_rupiah($row["hargabeli"]) ?></td>

                                                    <td width="10%">
                                                        <?= ($hb > 0 || $hj1 > 0) ? round(($hj1 - $hb) / $hb * 100, 2) . '%' : '-0%' ?>
                                                    </td>

                                                    <td width="10%">
                                                        <?= ($hb > 0 || $hj2 > 0) ? round(($hj2 - $hb) / $hb * 100, 2) . '%' : '-0%' ?>
                                                    </td>

                                                    <td width="10%"><?= format_rupiah($row["hargajual1"]) ?></td>
                                                    <td width="10%"><?= format_rupiah($row["hargajual2"]) ?></td>

                                                    <td width="2%">
                                                        <?php
                                                        $kodeunit = $row["unitbeli"];
                                                        $ka = "SELECT namaunit FROM unit01 WHERE kodeunit ='$kodeunit'"; //perintah untuk menjumlahkan
                                                        $hasilka = mysqli_query($conn, $ka); //melakukan query dengan varibel $jumlahkan
                                                        $tampil = mysqli_fetch_array($hasilka); //menyimpan hasil query ke variabel $t
                                                        echo $tampilkode = $tampil['namaunit'];
                                                        ?>
                                                    </td>

                                                    <td width="1%"><?= $row["minstok"] ?></td>

                                                    <td width="10%">
                                                        <?php
                                                        $kodesupplier = $row["supplier"];
                                                        $ka = "SELECT namasupplier FROM supplier01 WHERE kodesupplier ='$kodesupplier'"; //perintah untuk menjumlahkan
                                                        $hasilka = mysqli_query($conn, $ka); //melakukan query dengan varibel $jumlahkan
                                                        $tampil = mysqli_fetch_array($hasilka); //menyimpan hasil query ke variabel $t
                                                        echo $tampilkode = (isset($tampil['namasupplier']) ? $tampil['namasupplier'] : '');
                                                        ?>
                                                    </td>

                                                    <td>
                                                        <a class="badge btn-success edit-row rounded-pill waves-effect waves-light tombol-edit" data-bs-toggle="modal" data-bs-target="#modaledit" data-kodebarang="<?= $row['kodebarang']; ?>" data-unitbeli="<?= $row['unitbeli']; ?>" data-unitjual="<?= $row['unitjual']; ?>" data-kategoribarang="<?= $kodekategoribarang ?>" data-subkategoribarang="<?= $kodesubkatbarang ?>" data-namabarang="<?= $row['namabarang']; ?>" data-harga="<?= $row['hargabeli']; ?>" data-hargajual1="<?= $row["hargajual1"] ?>" data-hargajual2="<?= $row["hargajual2"] ?>" data-stok="<?= $row['stok']; ?>" data-mstok="<?= $row['minstok']; ?>" data-status="<?= $row['status']; ?>" data-kodeitem="<?= $row['kodeitem']; ?>" data-kodebarcode="<?= $row['kodebarcode']; ?>" data-merk="<?= $row['merk']; ?>" data-rak="<?= $row['rak']; ?>" data-dept="<?= $row['dept']; ?>" data-supplier="<?= $row['supplier']; ?>" data-keterangan="<?= $row['keterangan']; ?>" id="">
                                                            <i class="ti-pencil"></i>
                                                        </a>
                                                        <?php
                                                        $iddel = $row["id"];
                                                        if ($_SESSION['role_id'] == 1) :
                                                        ?>
                                                            |
                                                            <input type="hidden" class="delete_id_value" value="<?= $iddel ?>">
                                                            <a class="badge btn-danger remove-row rounded-pill waves-effect waves-light tombol-deletebarang">
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
                                    <input type="hidden" name="updatebarang">
                                    <input type="hidden" name="kodebarang" id="kodebarang">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="field-4" class="form-label">Kategori barang</label>
                                                <select class="form-select select2" name="ukategoribarang" id="ukategoribarang">
                                                    <option value=""></option>
                                                    <?php foreach ($kategoribarang as $row) : ?>
                                                        <option value="<?= $row["kodekategoribarang"] ?>">
                                                            <?= ucwords($row['namakategoribarang'])  ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="field-4" class="form-label">Kategori barang</label>
                                                <select class="form-select select2" name="usubkategoribarang" id="usubkategoribarang">
                                                    <option value=""></option>
                                                    <?php foreach ($subkatbarang as $row) : ?>
                                                        <option value="<?= $row["kodesubkatbarang"] ?>">
                                                            <?= ucwords($row['namasubkatbarang'])  ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nama Barang</label>
                                                <input type="text" class="form-control" required name="unamabarang" id="unamabarang" placeholder="Nama barang"></input>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Harga Beli</label>
                                                <input type="text" class="form-control" required name="uhargabeli" id="uhargabeli" placeholder="Harga Beli"></input>
                                            </div>
                                            <div class="mb-3">
                                                <label for="field-4" class="form-label">Unit Beli</label>
                                                <select class="form-select select2" name="uunitbeli" id="uunitbeli">
                                                    <option value=""></option>
                                                    <?php foreach ($unit as $row) : ?>
                                                        <option value="<?= $row["kodeunit"] ?>">
                                                            <?= ucwords($row['namaunit'])  ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <input type="hidden" class="form-control" required name="rak2" id="rak2" value="0"></input>
                                            </div>
                                            <div class="mb-3">
                                                <input type="hidden" class="form-control" required name="dept2" id="dept2" value="0"></input>
                                            </div>
                                            <div class="mb-3">
                                                <label for="field-4" class="form-label">Supplier</label>
                                                <select class="form-select select2" name="supplier2" id="supplier2">
                                                    <option value=""></option>
                                                    <?php foreach ($supplier as $row) : ?>
                                                        <option value="<?= $row["kodesupplier"] ?>">
                                                            <?= ucwords($row['namasupplier'])  ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Harga 1</label>
                                                <input type="text" class="form-control" required name="uhargajual1" id="uhargajual1" placeholder="Harga Jual 1"></input>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Harga 2</label>
                                                <input type="text" class="form-control" required name="uhargajual2" id="uhargajual2" placeholder="Harga Jual 2"></input>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Merk</label>
                                                <input type="text" class="form-control" required name="merk2" id="merk2" placeholder="Merk"></input>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Stok</label>
                                                <input type="text" class="form-control" required name="ustok" id="ustok" placeholder="Jumlah Stok"></input>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Min Stok</label>
                                                <input type="text" class="form-control" required name="uminstok" id="uminstok" placeholder="Minimal Stok"></input>
                                            </div>
                                            <div class="mb-3">
                                                <input name="status" type="hidden" value="0" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Keterangan</label>
                                                <input type="text" class="form-control" name="keterangan2" id="keterangan2" placeholder="Keterangan"></input>
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

        $('#formbarang').submit(function(e) {

            e.preventDefault();
            var dataform = $('#formbarang')[0];
            var data = new FormData(dataform);

            var kategoribarang = $('#kategoribarang').val();
            var nbarang = $('#nbarang').val();
            var nunit = $('#nunit').val();
            var nunitjual = $('#nunitjual').val();
            var supplier1 = $('#supplier1').val();

            if (kategoribarang == "") {
                Swal.fire({
                    position: "top-end",
                    icon: "erorr",
                    title: "Kategori Belom Dipilih",
                    showConfirmButton: !1,
                    timer: 1500

                })
            } else if (nbarang == "") {
                Swal.fire({
                    position: "top-end",
                    icon: "erorr",
                    title: "Nama Barang Belom Diisi",
                    showConfirmButton: !1,
                    timer: 1500

                })
            } else if (nunit == "") {
                Swal.fire({
                    position: "top-end",
                    icon: "erorr",
                    title: "Nama Unit Belom Diisi",
                    showConfirmButton: !1,
                    timer: 1500

                })
            } else if (nunitjual == "pilih unit") {
                Swal.fire({
                    position: "top-end",
                    icon: "erorr",
                    title: "Unit Jual Belom Diisi",
                    showConfirmButton: !1,
                    timer: 1500

                })
            } else if (supplier1 == "") {
                Swal.fire({
                    position: "top-end",
                    icon: "erorr",
                    title: "Nama Supplier Belom Diisi",
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


            const unitbeli = $(this).data('unitbeli');
            const unitjual = $(this).data('unitjual');
            const kategoribarang = $(this).data('kategoribarang');
            const subkategoribarang = $(this).data('subkategoribarang');
            const namabarang = $(this).data('namabarang');
            const harga = $(this).data('harga');
            const hargajual1 = $(this).data('hargajual1');
            const hargajual2 = $(this).data('hargajual2');
            const stok = $(this).data('stok');
            const mstok = $(this).data('mstok');
            const status = $(this).data('status');
            const kodebarang = $(this).data('kodebarang');
            const kodeitem = $(this).data('kodeitem');
            const kodebarcode = $(this).data('kodebarcode');
            const merk = $(this).data('merk');
            const rak = $(this).data('rak');
            const dept = $(this).data('dept');
            const supplier = $(this).data('supplier');
            const keterangan = $(this).data('keterangan');

            // console.log(status)
            $('#uunitbeli').val(unitbeli);
            $('#uunitbeli').trigger('change');
            $('#uunitjual').val(unitjual);
            $('#uunitjual').trigger('change');
            $('#ukategoribarang').val(kategoribarang);
            $('#ukategoribarang').trigger('change');
            $('#usubkategoribarang').val(subkategoribarang);
            $('#usubkategoribarang').trigger('change');
            $('#unamabarang').val(namabarang);
            $('#uhargabeli').val(harga);
            $('#uhargajual1').val(hargajual1);
            $('#uhargajual2').val(hargajual2);
            $('#ustok').val(stok);
            $('#uminstok').val(mstok);
            // $('#ustatus').val(status);
            $('#kodebarang').val(kodebarang);
            $('#kodeitem2').val(kodeitem);
            $('#kodebarcode2').val(kodebarcode);
            $('#merk2').val(merk);
            $('#rak2').val(rak);
            $('#dept2').val(dept);
            $('#supplier2').val(supplier);
            $('#supplier2').trigger('change');
            $('#keterangan2').val(keterangan);
            if (status == 1) {

                html =
                    '<option id=" ustatus" selected="" value="1">Unstore</option><option id="ustatus" value="0">Store </option>'
            } else {
                html =
                    '<option id="ustatus" selected="true" value="0">Store </option><option id=" ustatus" value="1">Unstore</option>'
            }
            $('#ustatus').html(html)

            $('#modaledit').modal('show');
        });

        $('#formupdate').submit(function(e) {

            // alert('ok');
            e.preventDefault();
            var dataform = $('#formupdate')[0];
            var data = new FormData(dataform);
            console.log(data);

            var ukategoribarang = $('#ukategoribarang').val();
            var usubkategoribarang = $('#usubkategoribarang').val();
            var ubarang = $('#unamabarang').val();
            var uunit = $('#uunit').val();
            var uunitjual = $('#uunitjual').val();
            var supplier2 = $('#supplier2').val();

            if (ukategoribarang == "") {
                Swal.fire({

                    icon: "error",
                    title: "Nama Kategori Belom Diisi",
                    showConfirmButton: !1,
                    timer: 1500

                })
            } else if (usubkategoribarang == "") {
                Swal.fire({

                    icon: "error",
                    title: "Sub Kstegori Belum Diisi",
                    showConfirmButton: !1,
                    timer: 1500

                })
            } else if (ubarang == "") {
                Swal.fire({

                    icon: "error",
                    title: "Sub Kstegori Belum Diisi",
                    showConfirmButton: !1,
                    timer: 1500

                })
            } else if (uunit == "") {
                Swal.fire({

                    icon: "error",
                    title: "Sub Kstegori Belum Diisi",
                    showConfirmButton: !1,
                    timer: 1500

                })
            } else if (supplier2 == "") {
                Swal.fire({

                    icon: "error",
                    title: "Sub Kstegori Belum Diisi",
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

        $('.tombol-deletebarang').click(function(e) {
            $('#responsive-datatable').on('click', '.tombol-deletebarang', function(e) {
                e.preventDefault();
                //alert('hapus');
                //var delete = 'delete';
                var tabel = 'barang01';
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