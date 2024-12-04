<?php
include '../koneksi.php';
if (isset($_POST['simpan'])) {
    $nama_customer  = $_POST['nama_customer'];
    $phone          = $_POST['phone'];
    $address        = $_POST['address'];

    $insert = mysqli_query($koneksi, "INSERT INTO customer (nama_customer, phone, address) VALUES ('$nama_customer', '$phone', '$address')");
    header("location: pelanggan.php?tambah=berhasil");
}

$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryCustomer = mysqli_query($koneksi, "SELECT * FROM customer WHERE id = '$id'");
$rowCustomer = mysqli_fetch_assoc($queryCustomer);

if (isset($_POST['edit'])) {
    $nama_customer  = $_POST['nama_customer'];
    $phone          = $_POST['phone'];
    $address        = $_POST['address'];

    $update = mysqli_query($koneksi, "UPDATE customer SET nama_customer='$nama_customer', phone='$phone', address='$address' WHERE id = '$id'");
    header("location: pelanggan.php?edit=berhasil");
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
                    <h5 class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> User</h5>
                    <form action="" method="post">
                        <div class="card-body">
                          <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">Nama</label>
                            <div class="col-md-10">
                              <input class="form-control" type="text" name="nama_customer" value="<?php echo isset($_GET['edit']) ? $rowCustomer['nama_customer'] : '' ?>" id="nama" />
                            </div>
                          </div>
                          <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">Telepon</label>
                            <div class="col-md-10">
                              <input class="form-control" type="text" name="phone" value="<?php echo isset($_GET['edit']) ? $rowCustomer['phone'] : '' ?>" id="phone" />
                            </div>
                          </div>
                          <div class="mb-3 row">
                            <label for="html5-email-input" class="col-md-2 col-form-label">Alamat</label>
                            <div class="col-md-10">
                              <input class="form-control" type="text" value="<?php echo isset($_GET['edit']) ? $rowCustomer['address'] : '' ?>" id="address" name="address" />
                            </div>
                          </div>
                        </div>
                        <div class="m-3">
                            <button class="btn btn-success" type="submit" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>">Simpan</button>
                            <button class="btn btn-warning"name=""><a href="pelanggan.php">Kembali</a></button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
             <?php include '../inc/footer.php' ?>
  </body>
</html>
