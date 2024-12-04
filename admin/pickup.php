<?php

include '../koneksi.php';
$transaksi = mysqli_query($koneksi, "SELECT 
trans_order.id AS order_id,
customer.nama_customer, 
trans_order.order_code,
trans_order.order_date,
trans_order.order_status,
trans_laundry_pickup.* FROM trans_laundry_pickup 
LEFT JOIN customer ON customer.id = trans_laundry_pickup.id_customer 
LEFT JOIN trans_order ON trans_order.id = trans_laundry_pickup.id_order
ORDER BY id DESC");

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM trans_laundry_pickup WHERE id='$id'");
    header("location: pickup.php?hapus=berhasil");
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
                                <h5 class="card-header">Orderan Selesai</h5>
                                <form action="" method="post">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Customer</th>
                                                    <th>Kode Order</th>
                                                    <th>Tanggal Order</th>
                                                    <th>Tanggal Pickup</th>
                                                    <th>Status Order</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                                <?php $no = 1;
                                                while ($rowTransaksi = mysqli_fetch_assoc($transaksi)) : ?>
                                                    <tr>
                                                        <td><?php echo $no++ ?></td>
                                                        <td><?php echo $rowTransaksi['nama_customer'] ?></td>
                                                        <td><?php echo $rowTransaksi['order_code'] ?></td>
                                                        <td><?php echo $rowTransaksi['order_date'] ?></td>
                                                        <td><?php echo $rowTransaksi['pickup_date'] ?></td>
                                                        <td>
                                                            <?php
                                                            switch ($rowTransaksi['order_status']) {
                                                                case '1':
                                                                    $badge = "<span class='badge bg-success'>Sudah dikembalikan</span>";
                                                                    break;

                                                                default:
                                                                    $badge = "<span class='badge bg-warning'>Baru</span>";
                                                                    break;
                                                            }
                                                            echo $badge;
                                                            ?></td>
                                                        <td>| <a target="_blank" href="detail-pickup.php?ambil=<?php echo $rowTransaksi['order_id'] ?>"><i class='bx bx-show'></i></a>
                                                            | | <a href="pickup.php?delete=<?php echo $rowTransaksi['id'] ?>" onclick="return confirm('Apakah anda yakin akan menghapus data ini??')"><i class='bx bx-trash'></i> |</a></td>
                                                        </td>
                                                    </tr>
                                                <?php endwhile ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <?php include '../inc/footer.php' ?>

</body>

</html>