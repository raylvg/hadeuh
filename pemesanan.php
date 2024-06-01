<?php
include "koneksi.php";

session_start();

if(isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
} 

if ($_SESSION['Username'] == null) {
    header("location: index.php");
    exit();
}

if (isset($_POST['btn_data'])) {
    $nama = $_POST['nama'];
    $no_iden = $_POST['iden'];
    $no_hp = $_POST['telepon'];
    $cekin = $_POST['check-in'];
    $cekout = $_POST['check-out'];
    $id = $_POST['jenis_kamar'];
    $jumlahkamar = $_POST['jumlah_kamar'];

   // Rumus selisih tanggal
    $date1 = new DateTime($cekin);
    $date2 = new DateTime($cekout);
    $jangkawaktu = $date1->diff($date2);
    $selisih = $jangkawaktu->days;

    $proses = "SELECT harga FROM tbl_jenis_kamar1 WHERE id_kamar='$id'";
    $result = $db->query($proses);
    $data = mysqli_fetch_assoc($result);
    $hargakamar = $data['harga'];

    // Hitung total
    $total = $hargakamar * $jumlahkamar * $selisih;


    // query disimpan dalam var $sql
    $sql = "INSERT INTO tbl_nyewa (Nama_lengkap, No_identitas, No_hp, Jenis_kamar, cekin, Cekout, Jumlah, Total, id_kamar, jumlah_kamar) VALUES ('$nama','$no_iden','$no_hp','$id','$cekin','$cekout','$selisih','$total','$id','$jumlahkamar')";
    $hasil = $db->query($sql);

    //validasi 
    //jika query berhasil di eksekusi 
    if ($hasil) {
        echo "
        <script> 
            alert('Tambah data Sukses !');
            document.location='penyewa.php'; 
        </script>";
    } else {
        echo "
        <script> 
            alert('Gagal menambahkan data!');
            document.location='nama_halaman_yang_benar.php'; 
        </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Formulir Pemesanan Kamar Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/tabel.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        /* Styling Form */
        form {
            max-width: 500px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
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
                        <form class="d-flex" method="POST">      
                            <button type="submit" class="btn btn-dark" name="logout">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <br><br>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Formulir Pemesanan Kamar Hotel</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap:</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            
            <div class="mb-3">
                <label for="iden" class="form-label">No Identitas:</label>
                <input type="text" class="form-control" id="iden" name="iden" required>
            </div>
            
            <div class="mb-3">
                <label for="telepon" class="form-label">Nomor Telepon:</label>
                <input type="tel" class="form-control" id="telepon" name="telepon" required>
            </div>
            
            <div class="mb-3">
                <label for="check-in" class="form-label">Tanggal Check-in:</label>
                <input type="date" class="form-control" id="check-in" name="check-in" required>
            </div>
            
            <div class="mb-3">
                <label for="check-out" class="form-label">Tanggal Check-out:</label>
                <input type="date" class="form-control" id="check-out" name="check-out" required>
            </div>

            <div class="mb-3">
                <label for="jenis_kamar" class="form-label">Pilihan Tipe Kamar:</label>
                <select class="form-select" id="jenis_kamar" name="jenis_kamar" aria-label="Pilih Tipe Kamar" required>
                    <option selected disabled>-- Pilih Tipe Kamar --</option>
                    <?php
                    $query = "SELECT * FROM tbl_jenis_kamar1";
                    $result = mysqli_query($db, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['id_kamar'] . '">' . $row['jenis_kamar'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="jumlah_kamar" class="form-label">Jumlah Kamar:</label>
                <input type="text" class="form-control" id="jumlah_kamar" name="jumlah_kamar" required>
            </div>

            <div class="d-grid mt-5">
                <button type="submit" class="btn btn-warning btn-login" name="btn_data">Tambah Data</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
