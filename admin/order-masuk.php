<?php
include '../koneksi.php';
$order = mysqli_query($koneksi, "SELECT customer.nama_customer, trans_order.* FROM trans_order LEFT JOIN customer ON customer.id = trans_order.id_customer WHERE trans_order.order_status = 0 ORDER BY id DESC");

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];

  $delete = mysqli_query($koneksi, "DELETE FROM trans_order WHERE id = '$id'");
  header("location: order-masuk.php?hapus=berhasil");
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

          <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Hoverable Table rows -->
            <div class="card">
              <h5 class="card-header text-center">Orderan Masuk</h5>
              <div class="table-responsive text-nowrap">
                <div align="right" class="m-3"><a href="tambah-order_masuk.php" class="btn btn-primary">Tambah</a></div>
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode Order</th>
                      <th>Pelanggan</th>
                      <th>Tanggal Masuk</th>
                      <th>Tanggal Selesai</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="table-border-bottom-0">
                    <?php $no = 1;
                    while ($rowOrder = mysqli_fetch_assoc($order)): ?>
                      <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $rowOrder['order_code'] ?></td>
                        <td><?php echo $rowOrder['nama_customer'] ?></td>
                        <td><?php echo $rowOrder['order_date'] ?></td>
                        <td><?php echo $rowOrder['order_end_date'] ?></td>
                        <td>
                          <?php
                          switch ($rowOrder['order_status']) {
                            case '1':
                              $badge = "<span class='badge bg-success'>Sudah dikembalikan</span>";
                              break;

                            default:
                              $badge = "<span class='badge bg-warning'>Baru</span>";
                              break;
                          }
                          echo $badge;
                          ?></td>
                        <td><a target="_blank" href="detail-order.php?ambil=<?php echo $rowOrder['id'] ?>" class="btn btn-primary">Detail</a> <a onclick="return confirm('Hapus Data Paket?')" href="order-masuk.php?delete=<?php echo $rowOrder['id'] ?>" class="btn btn-danger">Hapus</a></td>
                      </tr>
                    <?php endwhile ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!--/ Hoverable Table rows -->

            <hr class="my-5" />


          </div>
          <!-- / Content -->

          <!-- Footer -->
          <?php include '../inc/footer.php' ?>
</body>

</html>