<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Apotek - Login</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        
        <div class="card">
          <div class="card-body">
            <img src="assets/img/car-wash.png" alt="logo" width="150" class="d-block mx-auto img-fluid">
            <h4 class="text-center">Register</h4>
            <form action="" method="POST">
              <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control">
              </div>
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control">
              </div>
              <div class="d-grid gap-2">
                <button type="submit" name="register" class="btn btn-md btn-primary">Register</button>
              </div>
            </form>
          </div>
        </div>

        <div class="mt-2 text-muted text-center">
          Sudah punya akun! <a href="./">Login</a>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
require "config/connect.php";

if (isset($_POST["register"])) {

  $query = "INSERT INTO users(nama, username, password) VALUES(?, ?, ?)";
  $data = $con->prepare($query);
  $data->bindParam(1, $_POST['nama']);
  $data->bindParam(2, $_POST['username']);
  $data->bindParam(3, password_hash($_POST['password'], PASSWORD_DEFAULT));
  $success = $data->execute();

  if ($success) {
    echo "
    <script>
      alert('Register Berhasil!');
      window.location='index.php';
    </script>
    ";
  } else {
    echo "
    <script>
      alert('Register gagal! Ulangi');
      window.location='register.php';
    </script>
    ";
  }
}
?>