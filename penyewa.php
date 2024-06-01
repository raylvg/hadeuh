<?php
include("koneksi.php");
session_start();

if(isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
}

if ($_SESSION['Username'] == null) {
    header ("location: index.php");
    exit();
}

// Calculate total price
$query = "SELECT * FROM tbl_nyewa";
$hasil = $db->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/tabel.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index2.php">Expro Hotel</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <a class="nav-link active" aria-current="page" href="#" style="color: white">Selamat Datang <?= $_SESSION["Username"] ?> </a>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="datakamar.php">Data kamar</a></li>
                    <li><a class="dropdown-item" href="index2.php">Data admin</a></li>
                    <li><a class="dropdown-item" href="penyewa.php">Data sewa</a></li>
                    <li><a class="dropdown-item" href="pemesanan.php">Pesan kamar</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <form class="d-flex" method="POST" >      
                            <button type="submit" class="btn btn-dark" name="logout">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <br><br>
    <div class="container mt-5">
        <h3 class="mt-3 fw-bold mb-5">Data Sewa Kamar</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ID Sewa</th>
                    <th>Nama</th>
                    <th>No. Identitas</th>
                    <th>No. Telepon</th>
                    <th>Tanggal Check-in</th>
                    <th>Tanggal Check-out</th>
                    <th>Jumlah Hari</th>
                    <th>Total Harga</th>
                    <th>ID Kamar</th>
                    <th>Jumlah Kamar</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hasil as $data) { ?>
                    <tr>
                        <td><?= $data['id_sewa'] ?></td>
                        <td><?= $data['Nama_lengkap'] ?></td>
                        <td><?= $data['No_identitas'] ?></td>
                        <td><?= $data['No_hp'] ?></td>
                        <td><?= $data['Cekin'] ?></td>
                        <td><?= $data['Cekout'] ?></td>
                        <td><?= $data['Jumlah'] ?></td>
                        <td><?= $data['Total'] ?></td>
                        <td><?= $data['id_kamar'] ?></td>
                        <td><?= $data['jumlah_kamar'] ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="id_sewa" value="<?= $data['id_sewa'] ?>">
                                <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Delete data
if(isset($_POST['delete'])) {
    $id_sewa = $_POST['id_sewa'];
    $query = "DELETE FROM tbl_nyewa WHERE id_sewa = '$id_sewa'";
    $result = $db->query($query);
    if($result) {
        echo '<script>alert("Data deleted successfully!");</script>';
        echo '<script>window.location="penyewa.php";</script>';
    } else {
        echo '<script>alert("Failed to delete data!");</script>';
    }
}
?>
