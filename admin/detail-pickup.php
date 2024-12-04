<?php
include '../koneksi.php';
$queryPickup = mysqli_query($koneksi, "SELECT * FROM trans_laundry_pickup");
$rowPickup = mysqli_fetch_assoc($queryPickup);
$id = isset($_GET['ambil']) ? $_GET['ambil'] : "";
$queryTransPickup = mysqli_query($koneksi, "SELECT 
customer.nama_customer, 
customer.phone, 
customer.address, 
trans_order.id_customer,
trans_order.order_code,
trans_order.order_change, 
trans_order.order_pay, 
trans_order.total_price, 
trans_order.order_date, 
trans_order.order_end_date, 
trans_order.order_status, 
type_of_service.service_name, 
type_of_service.price, 
trans_order_detail.* 
FROM trans_order_detail 
LEFT JOIN trans_order ON trans_order.id = trans_order_detail.id_order
LEFT JOIN customer ON customer.id = trans_order.id_customer
LEFT JOIN type_of_service ON type_of_service.id = trans_order_detail.id_service 
WHERE trans_order_detail.id_order = '$id'");


$row = [];
while ($dataTrans = mysqli_fetch_assoc($queryTransPickup)) {
    $row[] = $dataTrans;
}
$queryPaket = mysqli_query($koneksi, "SELECT 

        type_of_service.service_name,
        type_of_service.price,
        trans_order_detail.*
    FROM 
        trans_order_detail
    LEFT JOIN 
        type_of_service ON type_of_service.id = trans_order_detail.id_service
    LEFT JOIN 
        trans_order ON trans_order.id = trans_order_detail.id_order
    WHERE 
        trans_order.id = (SELECT id_order FROM trans_laundry_pickup WHERE id = '$id')
");

$rowPaket = [];
while ($data = mysqli_fetch_assoc($queryPaket)) {
    $rowPaket[] = $data;
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
    <?php include '../inc/header.php' ?>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <?php include '../inc/sidebar.php' ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <?php include '../inc/navbar.php' ?>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <?php if (isset($_GET['ambil'])) : ?>
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="" method="post">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h5>Pengambilan Laundry <?php echo $row[0]['nama_customer'] ?></h5>
                                                        <div class="mb-3">
                                                            <label for="pickup_date" class="col-form-label">Tanggal Pickup</label>
                                                            <input class="form-control" type="text" name="pickup_date" value="<?php echo $rowPickup['pickup_date'] ?>" id="pickup_date" readonly />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 mt-5" align="right">
                                                        <a href="pickup.php" class="btn btn-secondary">Kembali</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Data Transaksi</h5>
                                        </div>
                                        <?php include '../lib/app.php' ?>
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th>No Invoice</th>
                                                    <td><?php echo $row[0]['order_code'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Masuk</th>
                                                    <td><?php echo $row[0]['order_date'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Selesai</th>
                                                    <td><?php echo $row[0]['order_end_date'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td><?php echo ubahStatus($row[0]['order_status']) ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Data Customer</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th>Nama</th>
                                                    <td><?php echo $row[0]['nama_customer'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Telepon</th>
                                                    <td><?php echo $row[0]['phone'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat</th>
                                                    <td><?php echo $row[0]['address'] ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Transaksi Detail</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="" method="post">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Qty</th>
                                                            <th>Nama Paket</th>
                                                            <th>Harga</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no = 1;
                                                        $total = 0;
                                                        foreach ($rowPaket as $key => $value) : ?>
                                                            <tr>
                                                                <td><?php echo $no++ ?></td>
                                                                <td><?php echo $value['qty'] ?></td>
                                                                <td><?php echo $value['service_name'] ?></td>
                                                                <td><?php echo "Rp" .  number_format($value['price']) ?></td>
                                                                <td><?php echo "Rp" .  number_format($value['subtotal']) ?></td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                        <tr>
                                                            <td colspan="4" align="right">
                                                                <strong>Total Keseluruhan</strong>
                                                            </td>
                                                            <td><strong><input type="text" name="total_price" placeholder="Dibayar" class="form-control"
                                                                        value="<?php echo "Rp" .  number_format($row[0]['total_price']) ?>" readonly></strong></td>

                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" align="right">
                                                                <strong>Dibayar</strong>
                                                            </td>
                                                            <td>
                                                                <strong>
                                                                    <input type="text" name="order_pay" placeholder="Dibayar" class="form-control"
                                                                        value="<?php echo "Rp" .  number_format($row[0]['order_pay'])  ?>" readonly>
                                                                </strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" align="right">
                                                                <strong>Kembalian</strong>
                                                            </td>
                                                            <td>
                                                                <strong>
                                                                    <input type="text" name="order_change" placeholder="Kembalian" class="form-control" value="<?php echo "Rp" .  number_format($row[0]['order_change'])  ?>" readonly>
                                                                </strong>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <!-- / Content -->

                    <!-- Footer -->
                    <?php include '../inc/footer.php'; ?>
</body>

</html>