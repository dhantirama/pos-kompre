<?php
include '../koneksi.php';
if (isset($_POST['simpan'])) {
  $name       = $_POST['name'];
  $username   = $_POST['username'];
  $email      = $_POST['email'];
  $password   = $_POST['password'];
  $id_level   = $_POST['id_level'];

  $insert = mysqli_query($koneksi, "INSERT INTO user (name, username, email, password, id_level) VALUES ('$name', '$username', '$email', '$password', '$id_level')");
  header("location: user.php?tambah=berhasil");
}

$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($koneksi, "SELECT * FROM user WHERE id = '$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

if (isset($_POST['edit'])) {
  $name       = $_POST['name'];
  $username   = $_POST['username'];
  $email      = $_POST['email'];
  $id_level   = $_POST['id_level'];

  if ($_POST['password']) {
    $password = $_POST['password'];
  } else {
    $password = $rowEdit['password'];
  }

  $update = mysqli_query($koneksi, "UPDATE user SET name='$name', username='$username', email='$email', password='$password', id_level='$id_level' WHERE id = '$id'");
  header("location: user.php?edit=berhasil");
}

$queryLvl = mysqli_query($koneksi, "SELECT * FROM level");


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
                  <h5 class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> User</h5>
                  <form action="" method="post">
                    <div class="card-body">
                      <div class="mb-3 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">Nama</label>
                        <div class="col-md-10">
                          <input class="form-control" type="text" name="name" value="<?php echo isset($_GET['edit']) ? $rowEdit['name'] : '' ?>" id="name" />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">Username</label>
                        <div class="col-md-10">
                          <input class="form-control" type="text" name="username" value="<?php echo isset($_GET['edit']) ? $rowEdit['username'] : '' ?>" id="username" />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-email-input" class="col-md-2 col-form-label">Email</label>
                        <div class="col-md-10">
                          <input class="form-control" type="email" value="<?php echo isset($_GET['edit']) ? $rowEdit['email'] : '' ?>" id="email" name="email" />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-password-input" class="col-md-2 col-form-label">Password</label>
                        <div class="col-md-10">
                          <input class="form-control" type="password" id="password" name="password" />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="exampleFormControlSelect1" class="col-md-2 col-form-label">Level</label>
                        <div class="col-md-10">
                          <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" name="id_level">
                            <option selected>-- Pilih Level --</option>
                            <?php while ($rowLevel = mysqli_fetch_assoc($queryLvl)) : ?>
                              <option <?php echo isset($_GET['edit']) ? ($rowLevel['id'] == $rowEdit['id_level'] ? 'selected' : '') : '' ?> value="<?php echo $rowLevel['id'] ?>"><?php echo $rowLevel['nama_level'] ?></option>
                            <?php endwhile ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="m-3">
                      <button class="btn btn-success" type="submit" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>">Simpan</button>
                      <button class="btn btn-warning" name=""><a href="user.php">Kembali</a></button>
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