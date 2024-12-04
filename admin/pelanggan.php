<?php 
include '../koneksi.php';
$customer = mysqli_query($koneksi, "SELECT * FROM customer ORDER BY id DESC");

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "DELETE FROM customer WHERE id = '$id'");
    header("location: pelanggan.php?hapus=berhasil");
}


?>

<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
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
                <h5 class="card-header text-center">Data Pelanggan</h5>
                <div class="table-responsive text-nowrap">
                    <div align="right" class="m-3"><a href="tambah-pelanggan.php" class="btn btn-primary">Tambah</a></div>  
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php $no = 1; 
                        while ($rowCustomer = mysqli_fetch_assoc($customer)): ?>
                      <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $rowCustomer['nama_customer'] ?></td>
                        <td><?php echo $rowCustomer['phone'] ?></td>
                        <td><?php echo $rowCustomer['address'] ?></td>
                        <td><a href="tambah-pelanggan.php?edit=<?php echo $rowCustomer['id'] ?>" class="btn btn-primary">Edit</a> <a onclick="return confirm('Hapus Data Customer?')" href="pelanggan.php?delete=<?php echo $rowCustomer['id'] ?>" class="btn btn-danger">Hapus</a></td>
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
