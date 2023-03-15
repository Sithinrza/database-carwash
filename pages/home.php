<?php
/**
 * melakukan pengecekkan menggunakan id yang dkirim melalui session
 * apabila id tidak ada di session maka dikembalikan ke halaman index.php
 */
session_start();
//! menandqakan tidak 
if (!isset($_SESSION["id"])){
  
  header("location: ../index.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Wash</title>
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
  <!-- Navbar -->
  <?=
  include "navbar.php";
  ?>
  <!-- End Navbar -->

  <!-- Hero -->
  <section id="hero" class="mb-3">
    <div class="container mt-3">
      <div class="row">
        <div class="col-lg-6">
          <h1 class="mt-5">Car Wash <br>SMK ISFI Banjarmasin</h1>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ullam cum id consequuntur cupiditate dignissimos minus at totam ab blanditiis neque facilis, molestiae beatae veniam quo.</p>

          <a href="#paket" class="btn btn-md btn-primary px-5">Pilih Paket</a>
        </div>
        <div class="col-lg-6">
          <img src="../assets/img/car-wash.png" alt="" class="img-fluid mx-auto d-block" width="400">
        </div>
      </div>
    </div>
  </section>
  <!-- End Hero -->

  <!-- Paket -->
  <!-- Paket -->
  <section id="paket" class="mb-3 py-3 container-fluid bg-light">
    <div class="container mb-4">
      <h3 class="mb-4 mt-2 text-center">Daftar Obat</h3>

      <div class="row">
      <?php
      require "../config/connect.php";
      $query = "SELECT * FROM paket";
      $data = $con->prepare($query);
      $data->execute();
      //data hasil dari db simpan ke varable $results
      $results = $data->fetchAll(PDO::FETCH_OBJ);

      foreach($results as $tampil) {
      ?>

        <div class="col-lg-3 col-md-6 col-sm-12">
          <div class="card my-2 h-100">
            <img src="../assets/img/<?= $tampil->gambar?>" name="gambar" class="card-img-top"  alt="">

                <div class="card-body">
                <h5><?= $tampil->nama_paket?></h5>
                <p><?= $tampil->deskripsi?></p>
                </div>
                <div class="card-footer">
                    <h5>Rp. <?= number_format($tampil->harga, '0') ?></h5>
                    <div class="d-grid gap-2 mt-2">
                        <a href="transaksi.php?id=<?= $tampil->idpaket?>" class="btn btn-sm btn-primary">Pilih</a>
                    </div>
                </div>
            </div>
        </div>

        <?php
        }
        ?>

      </div>
    </div>
  </section>
  <!-- End Paket -->

<?php
include "footer.php";
?>
  <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>