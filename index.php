<?php
session_start(); //session ga boleh d enter nanti error
include 'koneksi.php';

function loginQuery($koneksi, $kolom, $params)
{
    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE $kolom='$params'");
    if (mysqli_num_rows($query) > 0) {
        return $query;
    } else {
        return false;
    }
}

if (isset($_POST['login'])) {
    $email      = $_POST['email'];
    $password   = $_POST['password'];

    $queryLogin = loginQuery($koneksi, "username", $email);
    $queryEmail = loginQuery($koneksi, "email", $email);

    //login dengan username
    if ($queryLogin) {
        $rowLogin = mysqli_fetch_assoc($queryLogin);
        if ($password == $rowLogin['password']) {
            $_SESSION['name'] = $rowLogin['name'];
            $_SESSION['id']    = $rowLogin['id'];
            $_SESSION['id_level'] = $rowLogin['id_level'];
            header("location: admin/index.php");
        } else {
            header("location: login.php?login=gagal");
        }
    } elseif ($queryEmail) {
        $rowLogin = mysqli_fetch_assoc($queryEmail);
        if ($password == $rowLogin['password']) {
            $_SESSION['name'] = $rowLogin['name'];
            $_SESSION['id']    = $rowLogin['id'];
            $_SESSION['id_level'] = $rowLogin['id_level'];
            header("location: admin/index.php");
        } else {

            header("location: login.php?login=gagal");
        }
    }
    //login denhan email
    if (mysqli_num_rows($queryLogin) > 0) {
    } else {
        header("location: login.php?login=failed");
    }
}

?>

<!DOCTYPE html>


<html
    lang="en"
    class="light-style customizer-hide"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login Laundry Sukacita</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="asset/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="asset/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="asset/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="asset/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="asset/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="asset/assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="asset/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="asset/assets/js/config.js"></script>
</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="index.html" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <svg height="100px" width="100px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path style="fill:#A7E5CB;" d="M503.916,245.221v43.116c0,11.906-9.651,21.558-21.558,21.558h-10.779l-32.337,174.843 c-1.213,10.918-10.442,19.178-21.426,19.178H94.184c-10.985,0-20.213-8.26-21.426-19.178L40.421,309.895H29.642 c-11.906,0-21.558-9.651-21.558-21.558v-43.116c0-11.906,9.651-21.558,21.558-21.558h10.779l0,0 c0-47.625,38.607-86.232,86.232-86.232h99.168C235.809,88.231,279.305,51.2,331.453,51.2h32.337 c59.531,0,107.789,48.258,107.789,107.789v64.674h10.779C494.264,223.663,503.916,233.315,503.916,245.221z"></path>
                                            <path style="fill:#64AF8F;" d="M503.916,245.221v43.116c0,11.906-9.651,21.558-21.558,21.558h-10.779l-3.987,21.558H44.408 l-3.987-21.558H29.642c-11.906,0-21.558-9.651-21.558-21.558v-43.116c0-11.906,9.651-21.558,21.558-21.558h452.716 C494.264,223.663,503.916,233.315,503.916,245.221z"></path>
                                            <path style="fill:#84D88B;" d="M299.116,180.547H180.547c-41.671,0-75.453-33.781-75.453-75.453l0,0 c0-53.578,43.433-97.011,97.011-97.011h75.453c47.625,0,86.232,38.607,86.232,86.232v21.558 C363.789,151.592,334.834,180.547,299.116,180.547z"></path>
                                            <path style="fill:#93D6BB;" d="M503.916,245.221v43.116c0,11.906-9.651,21.558-21.558,21.558H29.642 c-11.906,0-21.558-9.651-21.558-21.558v-43.116c0-11.906,9.651-21.558,21.558-21.558h452.716 C494.264,223.663,503.916,233.315,503.916,245.221z"></path>
                                            <path style="fill:#FF9CAB;" d="M331.453,51.2h32.337c59.53,0,107.789,48.26,107.789,107.789v64.674H223.663v-64.674 C223.663,99.46,271.923,51.2,331.453,51.2z"></path>
                                            <path style="fill:#FFE77C;" d="M406.905,223.663L406.905,223.663c0,23.813-19.304,43.116-43.116,43.116h-97.011 c-18.781,0-34.758-12.009-40.67-28.766c-3.036-8.606-11.182-14.35-20.309-14.35H40.421l0,0c0-47.625,38.607-86.232,86.232-86.232 h194.021C368.298,137.432,406.905,176.039,406.905,223.663z"></path>
                                            <path d="M83.537,317.979H29.642C13.297,317.979,0,304.681,0,288.337v-43.116c0-16.344,13.297-29.642,29.642-29.642h3.038 c4.114-48.236,44.69-86.232,93.973-86.232h10.779c4.465,0,8.084,3.618,8.084,8.084c0,4.466-3.62,8.084-8.084,8.084h-10.779 c-40.361,0-73.673,30.758-77.732,70.063h239.417c4.466,0,8.084,3.618,8.084,8.084s-3.618,8.084-8.084,8.084h-56.138 c0.584,1.146,1.097,2.34,1.533,3.574c4.932,13.98,18.213,23.373,33.047,23.373h97.011c19.317,0,35.032-15.715,35.032-35.032 c0-43.091-35.056-78.147-78.147-78.147h-94.688c-0.106,0.002-0.21,0.002-0.317,0h-55.901c-4.465,0-8.084-3.618-8.084-8.084 c0-4.466,3.62-8.084,8.084-8.084h49.638c6.619-25.097,21.538-47.3,42.506-63.053c7.182-5.396,14.983-9.949,23.189-13.534 c14.646-6.399,30.241-9.645,46.352-9.645h32.337c63.892,0,115.874,51.981,115.874,115.874v32.337c0,4.466-3.618,8.084-8.084,8.084 s-8.084-3.618-8.084-8.084v-32.337c0-54.978-44.727-99.705-99.705-99.705h-32.337c-13.868,0-27.285,2.791-39.879,8.292 c-7.057,3.083-13.768,7.001-19.95,11.644c-16.89,12.691-29.22,30.236-35.399,50.126h84.449c52.006,0,94.316,42.31,94.316,94.316 c0,28.231-22.969,51.2-51.2,51.2h-97.011c-21.676,0-41.084-13.728-48.294-34.161c-1.89-5.356-6.988-8.955-12.685-8.955H29.642 c-7.43,0-13.474,6.044-13.474,13.474v43.116c0,7.43,6.044,13.474,13.474,13.474h53.895c4.465,0,8.084,3.618,8.084,8.084 S88.001,317.979,83.537,317.979z M105.849,123.959c0.382,0,0.766-0.027,1.155-0.082c4.419-0.633,7.49-4.729,6.858-9.148 c-0.453-3.166-0.682-6.407-0.682-9.634c0-49.033,39.892-88.926,88.926-88.926h75.453c17.964,0,34.85,5.925,48.836,17.134 c3.483,2.792,8.57,2.231,11.364-1.253c2.792-3.483,2.231-8.571-1.253-11.364C319.863,7.346,298.928,0,277.558,0h-75.453 C144.155,0,97.011,47.145,97.011,105.095c0,3.99,0.285,8.002,0.846,11.925C98.433,121.051,101.891,123.959,105.849,123.959z M331.453,495.832H94.183c-6.875,0-12.632-5.152-13.391-11.985c-0.022-0.194-0.05-0.386-0.085-0.578L54.351,340.761 c-0.812-4.39-5.032-7.293-9.42-6.479c-4.39,0.812-7.292,5.029-6.479,9.42L64.76,485.945C66.57,500.821,79.164,512,94.183,512 h237.269c4.466,0,8.084-3.618,8.084-8.084S335.918,495.832,331.453,495.832z M97.011,406.905c0,4.466,3.62,8.084,8.084,8.084h52.147 l4.505,36.035c0.511,4.09,3.994,7.082,8.012,7.082c0.334,0,0.673-0.022,1.012-0.064c4.43-0.554,7.573-4.595,7.019-9.025 l-4.253-34.028h74.379v35.032c0,4.466,3.62,8.084,8.084,8.084c4.466,0,8.084-3.618,8.084-8.084v-35.032h56.589 c4.466,0,8.084-3.618,8.084-8.084s-3.618-8.084-8.084-8.084h-56.589v-35.032c0-4.466-3.618-8.084-8.084-8.084 c-4.465,0-8.084,3.618-8.084,8.084v35.032h-76.4l-4.505-36.035c-0.554-4.429-4.597-7.573-9.024-7.019 c-4.43,0.554-7.573,4.595-7.019,9.025l4.253,34.029h-50.126C100.63,398.821,97.011,402.44,97.011,406.905z M354.014,355.768 c-4.432-0.556-8.471,2.589-9.025,7.019l-10.779,86.232c-0.554,4.43,2.589,8.471,7.019,9.025c0.341,0.042,0.679,0.064,1.013,0.064 c4.017,0,7.5-2.992,8.012-7.082l10.779-86.232C361.586,360.362,358.443,356.321,354.014,355.768z M406.905,414.989 c4.466,0,8.084-3.618,8.084-8.084s-3.618-8.084-8.084-8.084h-32.337c-4.466,0-8.084,3.618-8.084,8.084s3.618,8.084,8.084,8.084 H406.905z M482.358,215.579h-43.116c-4.466,0-8.084,3.618-8.084,8.084s3.618,8.084,8.084,8.084h43.116 c7.43,0,13.474,6.044,13.474,13.474v43.116c0,7.43-6.044,13.474-13.474,13.474h-10.637c-0.101-0.002-0.202-0.002-0.302,0H115.874 c-4.465,0-8.084,3.618-8.084,8.084s3.62,8.084,8.084,8.084h345.988l-30.569,165.29c-0.036,0.192-0.065,0.384-0.085,0.578 c-0.759,6.833-6.516,11.985-13.392,11.985h-54.026c-4.466,0-8.084,3.618-8.084,8.084s3.618,8.084,8.084,8.084h54.026 c15.022,0,27.615-11.18,29.425-26.056l31.064-167.965h4.053c16.344,0,29.642-13.298,29.642-29.642v-43.116 C512,228.877,498.702,215.579,482.358,215.579z"></path>
                                        </g>
                                    </svg>
                                </span>
                                <span class="app-brand-text demo text-body fw-bolder">Sukacita</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Laundry Sukacita 👋</h4>
                        <p class="mb-4">Semoga Harimu Cerah</p>

                        <form id="formAuthentication" class="mb-3" action="" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email or Username</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="Enter your email or username"
                                    autofocus />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    <a href="auth-forgot-password-basic.html">
                                        <small>Forgot Password?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="password"
                                        class="form-control"
                                        name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" name="login" type="submit">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    <!-- / Content -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="asset/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="asset/assets/vendor/libs/popper/popper.js"></script>
    <script src="asset/assets/vendor/js/bootstrap.js"></script>
    <script src="asset/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="asset/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="asset/assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>