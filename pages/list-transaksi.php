
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Wash - Daftar Transaksi</title>
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
  <!-- Navbar -->
  <?php include 'navbar.php' ?>
  <!-- End Navbar -->
  <?php
session_start();
if (!isset($_SESSION['id'])) {
  header("location: ../index.php");
}
require "../config/connect.php";
$query = "SELECT * FROM transaksi INNER JOIN paket ON transaksi.idpaket = paket.idpaket WHERE iduser = ?";
$data = $con->prepare($query);
$data->bindParam(1, $_SESSION['id']);
$data->execute();
$results = $data->fetchAll(PDO::FETCH_OBJ);
?>

  <div class="container mt-4">
    <h4>Daftar Transaksi</h4>

    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>No Transaksi</th>
            <th>Tanggal Transaksi</th>
            <th>Nama Customer</th>
            <th>Pilihan Obat</th>
            <th>Harga</th>
            <th>Jumlah Obat</th>
            <th>Total Harga</th>
            <th>Pembayaran</th>
            <th>Kembalian</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($results as $tampil) {
          ?>
          <tr>
            <td><?= $tampil->no_transaksi ?></td>
            <td><?= $tampil->tanggal ?></td>
            <td><?= $tampil->nama_customer ?></td>
            <td><?= $tampil->nama_paket ?></td>
            <td>Rp <?= number_format($tampil->harga, '0') ?></td>
            <td><?= $tampil->jumlah ?></td>
            <td>Rp <?= number_format($tampil->totalharga, '0') ?></td>
            <td>Rp <?= number_format($tampil->pembayaran, '0') ?></td>
            <td>Rp <?= number_format($tampil->kembalian, '0') ?></td>
            <td>
              <form action="" method="POST" class="d-inline">
                <input type="hidden" name="no-transaksi" value="<?= $tampil->no_transaksi ?>">
                <button type="submit" name="hapus" class="btn btn-sm btn-danger">Hapus</button>
              </form>
            </td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  
  <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
if (isset($_POST["hapus"])) {
  $query = "DELETE FROM transaksi WHERE no_transaksi = ?";
  $data = $con->prepare($query);
  $data->bindParam(1, $_POST['no-transaksi']);
  $success = $data->execute();

  if ($success) {
    echo "
    <script>
      alert('Transaksi Berhasil dihapus!');
      window.location='list-transaksi.php';
    </script>
    ";
  } else {
    echo "
    <script>
      alert('Transaksi gagal dihpaus! Ulangi');
      window.location='list-transaksi.php';
    </script>
    ";
  }
}
?>