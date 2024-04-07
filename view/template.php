<?php
require_once __DIR__ . '/../db/middleware.php';
require_once __DIR__ . '/../db/koneksi.php';
auth();
$koneksi = getKoneksi();

$sql = "SELECT nama, role ,email ,foto_profil FROM users WHERE id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$_SESSION['id']]);
$user = $statement->fetch();

$nama = htmlspecialchars($user['nama']);
$email = htmlspecialchars($user['email']);
$role = htmlspecialchars($user['role']);
$foto_profil = htmlspecialchars($user['foto_profil']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>  <?= $title; ?></title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
          name='viewport'/>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="../assets/css/ready.css">
    <link rel="stylesheet" href="../assets/css/demo.css">
</head>
<body>
<div class="wrapper">
    <div class="main-header">
        <div class="logo-header">
            <a href="index.php" class="logo">
                Ready Dashboard
            </a>
            <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="collapse" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
        </div>
        <nav class="navbar navbar-header navbar-expand-lg">
            <div class="container-fluid">

                <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                            <img src="<?= empty($foto_profil) ? '../assets/img/profile.png' : '../db/image/' . $foto_profil; ?>"
                                 alt="user-img" width="36" class="img-circle border"><span><?= $nama ?></span></span>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li>
                                <div class="user-box">
                                    <div class="u-img">
                                        <img src="<?= empty($foto_profil) ? '../assets/img/profile.png' : '../db/image/' . $foto_profil; ?>"
                                             alt="user" class="border">
                                    </div>
                                    <div class="u-text">
                                        <h4><?= $nama ?></h4>
                                        <p class="text-muted"><?= $email ?></p><a href="profile.php"
                                                                                  class="btn btn-rounded btn-danger btn-sm">Lihat
                                            Profil</a></div>
                                </div>
                            </li>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="ubah_password.php"><i class="ti-settings"></i>Ubah
                                Password</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../db/queries/Logout.php"><i
                                        class="fa fa-power-off"></i> Logout</a>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="sidebar">
        <div class="scrollbar-inner sidebar-wrapper">
            <div class="user">
                <div class="photo">
                    <img src="<?= empty($foto_profil) ? '../assets/img/profile.png' : '../db/image/' . $foto_profil; ?>"
                         class="border"></div>
                <div class="info">
                    <a class="" data-toggle="collapse" aria-expanded="true">
								<span>
									<?= $nama ?>
									<span class="user-level"><?= $role ?></span>
								</span>
                    </a>
                </div>
            </div>
            <ul class="nav">
                <?php if ($role == 'admin' || $role == 'owner'): ?>
                <li class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                    <a href="index.php">
                        <i class="la la-dashboard"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <?php if ($role == 'owner'): ?>
                    <li class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'admin.php' || basename($_SERVER['PHP_SELF']) == 'tambah_admin.php' ? 'active' : ''; ?>">
                        <a href="admin.php">
                            <i class="la la-dashboard"></i>
                            <p>Admin</p>
                        </a>
                    </li>
                <?php endif; ?>
                    <li class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'pengasuh.php' || basename($_SERVER['PHP_SELF']) == 'tambah_pengasuh.php' || basename($_SERVER['PHP_SELF']) == 'edit_pengasuh.php' ? 'active' : ''; ?>">
                        <a href="pengasuh.php">
                            <i class="la la-dashboard"></i>
                            <p>Pengasuh</p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($role == 'user'): ?>

                <?php endif; ?>

            </ul>
        </div>
    </div>
    <div class="main-panel">
        <div class="content">
            <?= $content; ?>
        </div>
    </div>
</div>
</body>
<script src="../assets/js/core/jquery.3.2.1.min.js"></script>
<script src="../assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="../assets/js/core/popper.min.js"></script>
<script src="../assets/js/core/bootstrap.min.js"></script>
<script src="../assets/js/plugin/chartist/chartist.min.js"></script>
<script src="../assets/js/plugin/chartist/plugin/chartist-plugin-tooltip.min.js"></script>
<script src="../assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script src="../assets/js/plugin/jquery-mapael/jquery.mapael.min.js"></script>
<script src="../assets/js/plugin/jquery-mapael/maps/world_countries.min.js"></script>
<script src="../assets/js/plugin/chart-circle/circles.min.js"></script>
<script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="../assets/js/ready.min.js"></script>
<script src="../assets/js/demo.js"></script>
</html>