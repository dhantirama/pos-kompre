<?php
include '../koneksi.php';
$dataCustomer = mysqli_query($koneksi, "SELECT * FROM customer");
$dataSet = mysqli_query($koneksi, "SELECT * FROM type_of_service");
if (isset($_POST['simpan'])) {


    $id_customer = $_POST['id_customer'];
    $order_code = $_POST['order_code'];
    $order_date = $_POST['order_date'];
    $order_end_date = $_POST['order_end_date'];
    $order_change = $_POST['order_change'];
    $order_pay = $_POST['order_pay'];
    $total_price = $_POST['total_price'];

    $id_service = $_POST['id_service'];

    // Insert into table trans_order
    $insertTransOrder = mysqli_query($koneksi, "INSERT INTO trans_order (id_customer, order_code, order_date, order_end_date, order_pay, order_change, total_price) VALUES ('$id_customer', '$order_code', '$order_date', '$order_end_date', '$order_pay', '$order_change', '$total_price')");

    $last_id = mysqli_insert_id($koneksi);
    foreach ($id_service as $key => $service_id) {
        $qty = $_POST['jumlah'][$key];
        $id_service = $_POST['id_service'][$key];
        $subtotal = $_POST['subtotal'][$key];

        $insertDetailTransaksi = mysqli_query($koneksi, "INSERT INTO trans_order_detail (id_order, id_service, qty, subtotal) VALUES ('$last_id', '$id_service', '$qty', '$subtotal')");
        // print_r($insertDetailTransaksi);
        // die;
    }

    header("location:order-masuk.php?tambah=berhasil");
}

//no invoice kode
//001, jika ada auto increment id +1 = 002, selain itu 001
// select max adalah mencari data yg terbesar, min terkecil
$queryInvoice = mysqli_query($koneksi, "SELECT MAX(id) AS no_invoice FROM trans_order");
//membuat string unik
$str_unique  = "SKC";
$date_now   = date("dmY");
//jika di dalam tabel trans_order ada datanya 
if (mysqli_num_rows($queryInvoice) > 0) {
    $rowInvoice = mysqli_fetch_assoc($queryInvoice);
    $incrementPlus = $rowInvoice['no_invoice'] + 1; //no_invoice adalah alias yg sudah dibuat untuk id
    $code = $str_unique . "" . $date_now . "" . "000" . $incrementPlus;
} else {
    $code = $str_unique . "" . $date_now . "" . "0001";
}

?>


<!DOCTYPE html>
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <?php include '../inc/header.php'; ?>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <!-- / Menu -->
            <?php include '../inc/sidebar.php'; ?>
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <?php include '../inc/navbar.php'; ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Basic Inputs</h4>

                        <div class="row">
                            <div class="col-xl-12">
                                <!-- HTML5 Inputs -->
                                <div class="card mb-4">
                                    <h5 class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Paket</h5>
                                    <div class="card-body">
                                        <form action="" method="post">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="order_code" class="col-form-label">Kode Order</label>
                                                        <input class="form-control" type="text" name="order_code" value="<?php echo $code ?>" id="order_code" readonly />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="id_service" class="col-form-label">Jenis Paket</label>
                                                        <select class="form-select" name="id_service" id="id_service">
                                                            <option value="" selected>-- Pilih Paket --</option>
                                                            <?php while ($rowSet = mysqli_fetch_assoc($dataSet)) : ?>
                                                                <option value="<?php echo $rowSet['id'] ?>"><?php echo $rowSet['service_name'] ?></option>
                                                            <?php endwhile ?>
                                                        </select>
                                                    </div>
                                                    <input type="hidden" id="price">
                                                    <div class="mb-3">
                                                        <label for="order_date" class="col-form-label">Tanggal Masuk</label>
                                                        <input class="form-control" type="date" name="order_date" value="" id="order_date" />
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="nama_customer" class="col-form-label">Nama Pelanggan</label>
                                                        <select class="form-select" name="id_customer" id="nama_customer">
                                                            <option value="" selected>-- Pilih Pelanggan --</option>
                                                            <?php while ($rowCustomer = mysqli_fetch_assoc($dataCustomer)) : ?>
                                                                <option value="<?php echo $rowCustomer['id'] ?>"><?php echo $rowCustomer['nama_customer'] ?></option>
                                                            <?php endwhile ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="qty" class="col-form-label">Jumlah</label>
                                                        <input class="form-control" type="number" id="qty" />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="order_end_date" class="col-form-label">Tanggal Selesai</label>
                                                        <input class="form-control" type="date" name="order_end_date" value="" id="order_end_date" />
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary add-row" type="button">Tambah</button>
                                            <table class="table" id="table">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Paket</th>
                                                        <th>Jumlah</th>
                                                        <th>Harga</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="4" align="right">Total Harga</td>
                                                        <td>
                                                            <input type="number" name="total_price" class="total-harga form-control" readonly>
                                                            <input type="hidden" name="order_status" value="0" id="">
                                                        </td>
                                                    <tr>
                                                        <td colspan="4" align="right">Dibayar</td>
                                                        <td>
                                                            <input type="number" name="order_pay" class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" align="right">Kembalian</td>
                                                        <td>
                                                            <input type="number" name="order_change" class="form-control" readonly>

                                                        </td>
                                                    </tr>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <button class="btn btn-success" type="submit" name="simpan">Simpan</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <?php include '../inc/footer.php' ?>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        //untuk memanggil harga dari paket
                        $('#id_service').change(function() {
                            // alert('semoga berhasil'); //salah satu cara debugging
                            let id_service = $(this).val();
                            $.ajax({
                                url: '../lib/getHarga.php',
                                type: 'GET',
                                data: {
                                    id_service: id_service
                                },
                                dataType: 'json',
                                success: function(resp) {
                                    $('#price').val(resp.price)
                                }
                            })
                        });

                        $('.add-row').click(function(e) {
                            e.preventDefault(); // menghentikan aksi default form submit

                            // Ambil nilai id_service, qty, dan harga dari input form
                            let nama_paket = $('#id_service').find('option:selected').text();
                            let id_service = $('#id_service').val();
                            let harga = $('#price').val(); // Pastikan harga sudah diambil dengan benar
                            let qty = $('#qty').val(); // Ambil kuantitas dari input qty
                            let subtotal = parseInt(harga) * parseInt(qty);
                            let no = 0;

                            // Validasi input id_service dan qty
                            if (id_service == "" || id_service == null) {
                                alert('Paket Tidak Boleh Kosong');
                                return false;
                            }
                            if (qty == "" || qty <= 0) {
                                alert('Kuantitas Tidak Boleh Kosong dan Harus Lebih Besar dari 0');
                                return false;
                            }

                            console.log(qty)

                            // Membuat baris baru untuk tabel
                            no++;
                            let newRow = "";
                            newRow += "<tr>";
                            newRow += "<td>" + no + "</td>";
                            newRow += "<td>" + nama_paket + "<input type='hidden' name='id_service[]' class='id_service' value='" + id_service + "'></td>";
                            newRow += "<td>" + qty + "<input type='hidden' name='jumlah[]' value='" + qty + "'></td>";
                            newRow += "<td>" + harga + "<input type='hidden' name='price[]' value='" + harga + "' ></td>";
                            newRow += "<td>" + subtotal + "<input class='subtotal' type='hidden' name='subtotal[]' value='" + subtotal + "'></td>";
                            newRow += "</tr>";

                            // Tambahkan baris baru ke dalam tabel
                            let tbody = $('#table tbody');
                            tbody.append(newRow);

                            // Update total harga
                            let total = 0;
                            $('.subtotal').each(function() {
                                let totalHarga = parseFloat($(this).val()) || 0;
                                total += totalHarga;
                            });

                            $('.total-harga').val(total); // Jika ada input untuk total harga
                            $('#id_service').val(""); // Reset dropdown
                            $('input[name="qty[]"]').val(""); // Reset kuantitas
                        });

                        function hitungKembalian() {
                            let totalHarga = parseFloat($('.total-harga').val()) || 0; // Total harga dari input
                            let dibayar = parseFloat($('input[name="order_pay"]').val()) || 0; // Dibayar dari input

                            // Kembalian adalah selisih antara dibayar dan total harga
                            let kembalian = dibayar - totalHarga;

                            // Menampilkan kembalian ke dalam input "order_change"
                            $('input[name="order_change"]').val(kembalian.toFixed(2)); // Memastikan kembalian dalam format dua angka desimal
                        }

                        // Setiap kali ada perubahan pada input "order_pay" atau "total_price", hitung kembalian
                        $('.total-harga').on('input', function() {
                            hitungKembalian();
                        });

                        $('input[name="order_pay"]').on('input', function() {
                            hitungKembalian();
                        });
                    </script>
</body>

</html>