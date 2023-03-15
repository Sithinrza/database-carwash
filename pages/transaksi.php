<?php
session_start();
if (!isset($_SESSION["id"])){
  header("location: ../index.php");
}

require "../config/connect.php";
$query = "SELECT * FROM paket WHERE idpaket = $_GET[id]";
$data = $con->prepare($query);
$data->execute();
$result = $data->fetch(PDO::FETCH_OBJ);
?>

<!doctype html> 
<html lang="en"> 
    <head> 
        <!-- Required meta tags --> 
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <!-- Bootstrap CSS --> 
        <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384- 
        1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> 
        <!-- MY Style --> 
        <link rel="stylesheet" href="../assets/css/style.css"> 
        <title>cuci mobil</title> 
    </head> 
    <body> 


    <?php 
    include "navbar.php";

    ?> 


  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="text-center mb-4">Transaksi</h4>

            <form action="" method="POST">
              <div class="mb-3">
                <label for="no-transaksi" class="form-label">No. Transaksi</label>
                <input type="text" name="no-transaksi" id="no_transaksi"class="form-control" value="<?= mt_rand()?>" readonly> 
                
              </div>
              <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Transaksi</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="nama" class="form-label">Nama Customer</label>
                <input type="text" name="nama"id="nama" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="paket" class="form-label">Pilih Obat</label>
                <input type="text" name="obat"id="obat" class="form-control" value="<?= $result->nama_paket ?>" readonly>
              </div>
              <div class="mb-3">
                <label for="no-transaksi" class="form-label">Gambar</label>
                <input type="text" name="gambar"id="gambar" class="form-control"value="<?= $result->gambar ?>" readonly>
               
              </div>
              <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="text" name="harga" id="harga" class="form-control"value="<?= $result->harga ?>" readonly>
              </div>
              <div class="mb-3">
                <label for="no-transaksi" class="form-label">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah"class="form-control" value="">
             </div>
      
              <div class="d-grid gap-2">
                <button type="button"  class="btn btn-md btn-secondary"onclick="hitungTotal()">Total harga</button>
              </div>
              <div class="mb-3">
                <label for="no-transaksi" class="form-label">Total</label>
                <input type="text" name="total-harga" id="total-harga"class="form-control" value="">
             </div>

              
              <div class="mb-3">
                <label for="no-transaksi" class="form-label">Pembayaran</label>
                <input type="text" name="pembayaran"id="pembayaran" class="form-control">
              </div>
              <div class="d-grid gap-2">
                <button type="button" class="btn btn-md btn-secondary" onclick="hitungKembalian()">Kembalian</button>
              </div>

              <div class="mb-3">
                <label for="no-transaksi" class="form-label">Kembalian</label>
                <input type="text" name="kembalian"id="kembalian" class="form-control">
              </div>
             <br>

              <div class="d-grid gap-2">
                <button type="submit" name="simpan" class="btn btn-md btn-primary">Simpan Transaksi</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
        <?php 
            include 'footer.php'; 
        ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min .js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> 
        <script> 
            // HITUNG TOTAL HARGA 
            // hitungTotal dari Onclick
            
            function hitungTotal() { 
                let harga = parseInt(document.querySelector('#harga').value); 
                let tambahan = parseInt(document.querySelector('#jumlah').value); 
                let totalHarga = harga * tambahan; 
                document.getElementById("total-harga").value = totalHarga; 
            } 
            // HITUNG KEMBALIAN 
            function hitungKembalian() { 
                let total = parseInt(document.getElementById("total-harga").value); 
                let pembayaran = parseInt(document.getElementById("pembayaran").value); 
                if (pembayaran >= total) { 
                    let kembalian = pembayaran - total; 
                    document.getElementById("kembalian").value = kembalian; 
                } else { 
                    alert("Uang Tidak Cukup"); 
                } 
            } 
            // SIMPAN TRANSAKSI 
        
        </script> 
    </body> 
</html>

<?php

if (isset($_POST["simpan"])){
  $query = "INSERT INTO transaksi(no_transaksi, tanggal, nama_customer, idpaket, harga, iduser, jumlah, totalharga, pembayaran, kembalian) VALUES (?,?,?,?,?,?,?,?,?,?)";
  $data = $con->prepare($query);
  $data->bindParam(1, $_POST["no-transaksi"]);
  $data->bindParam(2, $_POST["tanggal"]);
  $data->bindParam(3, $_POST["nama"]);
  $data->bindParam(4, $result->idpaket);
  $data->bindParam(5, $_POST["harga"]);
  $data->bindParam(6, $_SESSION["id"]);
  $data->bindParam(7, $_POST["jumlah"]);
  $data->bindParam(8, $_POST["total-harga"]);
  $data->bindParam(9, $_POST["pembayaran"]);
  $data->bindParam(10, $_POST["kembalian"]);
  $success = $data->execute();

  if($success){
    echo"
    <script>
      alert('Data berhasil disimpan!');
      window.location='home.php';
    </script>
    ";
  } else{
    echo"
    <script>
      alert('Data gagal disimpan');
      window.location='transaksi.php?id=$_GET[id]';
    </script>
    ";
  }
}
?>

