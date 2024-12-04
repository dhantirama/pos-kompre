<?php
include '../koneksi.php';
if (isset($_POST['simpan'])) {
    $nama_level  = $_POST['nama_level'];

    $insert = mysqli_query($koneksi, "INSERT INTO level (nama_level) VALUES ('$nama_level')");
    header("location: level.php?tambah=berhasil");
}

$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryLevel = mysqli_query($koneksi, "SELECT * FROM level WHERE id = '$id'");
$rowLevel = mysqli_fetch_assoc($queryLevel);

if (isset($_POST['edit'])) {
    $nama_level  = $_POST['nama_level'];

    $update = mysqli_query($koneksi, "UPDATE level SET nama_level='$nama_level' WHERE id = '$id'");
    header("location: level.php?edit=berhasil");
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
                    <h5 class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Level</h5>
                    <form action="" method="post">
                        <div class="card-body">
                          <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">Level</label>
                            <div class="col-md-10">
                              <input class="form-control" type="text" name="nama_level" value="<?php echo isset($_GET['edit']) ? $rowLevel['nama_level'] : '' ?>" id="nama" />
                            </div>
                          </div>
                        </div>
                        <div class="m-3">
                            <button class="btn btn-success" type="submit" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>">Simpan</button>
                            <button class="btn btn-warning" name=""><a href="level.php">Kembali</a></button>
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
