<?php
include '../koneksi.php';
$set = mysqli_query($koneksi, "SELECT * FROM type_of_service ORDER BY id DESC");

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];

  $delete = mysqli_query($koneksi, "DELETE FROM type_of_service WHERE id = '$id'");
  header("location: paket.php?hapus=berhasil");
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
              <h5 class="card-header text-center">Data Paket</h5>
              <div class="table-responsive text-nowrap">
                <div align="right" class="m-3"><a href="tambah-paket.php" class="btn btn-primary">Tambah</a></div>
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Paket</th>
                      <th>Harga</th>
                      <th>Deskripsi</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="table-border-bottom-0">
                    <?php $no = 1;
                    while ($rowSet = mysqli_fetch_assoc($set)): ?>
                      <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $rowSet['service_name'] ?></td>
                        <td><?php echo $rowSet['price'] ?></td>
                        <td><?php echo $rowSet['description'] ?></td>
                        <td><a href="tambah-paket.php?edit=<?php echo $rowSet['id'] ?>" class="btn btn-primary">Edit</a> <a onclick="return confirm('Hapus Data Paket?')" href="paket.php?delete=<?php echo $rowSet['id'] ?>" class="btn btn-danger">Hapus</a></td>
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