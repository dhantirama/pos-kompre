<?php

include '../koneksi.php';
$order_date = isset($_GET['$order_date']) ? $_GET['$order_date'] : '';
$order_end = isset($_GET['order_end_date']) ? $_GET['order_end_date'] : '';
$status = isset($_GET['order_code']) ? $_GET['order_code'] : '';
$query = "SELECT trans_order.id AS order_id, customer.nama_customer, trans_order.* FROM trans_order LEFT JOIN customer ON customer.id = trans_order.id_customer WHERE 1";

//jika status tidak kosong

if ($order_date != "") {
    $query .= " AND order_date <= '$order_date'";
}
if ($order_end != "") {
    $query .= " AND order_end_date  <= '$order_end'";
}
if ($status != "") {
    $query .= " AND order_code = '$status'";
}
$query .= " ORDER BY trans_order.id DESC";
$queryPickup = mysqli_query($koneksi, $query);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM customer WHERE id='$id'");
    header("location: laporan.php?hapus=berhasil");
}

// 

?>
<!DOCTYPE html>

<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../page/backend/assets/"
    data-template="vertical-menu-template-free">

<head>
    <?php include '../inc/header.php'; ?>
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
                <?php include '../inc/navbar.php'; ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="card">
                                <h5 class="card-header">Transaksi Laundry</h5>
                                <div class="card-body">
                                    <div class="table-responsive text-nowrap">
                                        <form action="" method="get">
                                            <div class="mb-3 row">
                                                <div class="col-sm-3">
                                                    <label for="">Dari Tanggal</label>
                                                    <input type="date" name="order_date" class="form-control">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="">Sampai Tanggal</label>
                                                    <input type="date" name="order_end_date" class="form-control">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="">Status</label>
                                                    <select name="order_status" id="" class="form-control">
                                                        <option value="">--Pilih Status--</option>
                                                        <option value="0">Baru</option>
                                                        <option value="1">Sudah Kembali</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3 mt-4">
                                                    <button name="filter" class="btn btn-primary">Tampilkan Laporan</button>
                                                </div>
                                            </div>
                                        </form>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Customer</th>
                                                    <th>Kode Order</th>
                                                    <th>Tanggal Order</th>
                                                    <th>Status Order</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                                <?php $no = 1;
                                                while ($rowPickup = mysqli_fetch_assoc($queryPickup)) : ?>
                                                    <tr>
                                                        <td><?php echo $no++ ?></td>
                                                        <td><?php echo $rowPickup['nama_customer'] ?></td>
                                                        <td><?php echo $rowPickup['order_code'] ?></td>
                                                        <td><?php echo $rowPickup['order_date'] ?></td>
                                                        <td><?php echo $rowPickup['order_end_date'] ?></td>
                                                        <td>
                                                            <?php
                                                            switch ($rowPickup['order_status']) {
                                                                case '1':
                                                                    $badge = "<span class='badge bg-success'>Sudah dikembalikan</span>";
                                                                    break;

                                                                default:
                                                                    $badge = "<span class='badge bg-warning'>Baru</span>";
                                                                    break;
                                                            }
                                                            echo $badge;
                                                            ?></td>
                                                        <td>| <a target="_blank" href="detail-pickup.php?ambil=<?php echo $rowPickup['order_id'] ?>"><i class='bx bx-show'></i></a>
                                                            | <a target="_blank" href="print.php?id=<?php echo $rowPickup['order_id'] ?>"><i class='bx bx-printer'></i></a> | </td>
                                                        </td>
                                                    </tr>
                                                <?php endwhile ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <?php include '../inc/footer.php' ?>

</body>

</html>