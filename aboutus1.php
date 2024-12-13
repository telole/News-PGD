<?php
include 'config/app.php'; 
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - Kelompok 3</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .card-img-top {
      border-radius: 50%;
      width: 150px;
      height: 150px;
      object-fit: cover;
      margin: 0 auto;
    }
    .team-member-card {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      border: 2px solid #f2f2f2;
      border-radius: 10px;
      padding: 20px;
      background-color: #2d3748;
      color: white;
      height: 350px;
      text-align: center;
    }
    .card-title {
      font-weight: bold;
    }
    .card-body {
      flex-grow: 1; 
    }
  </style>
</head>
<body class="bg-gradient-to-b from-gray-800 to-gray-900 text-gray-200">
  <nav class="bg-gradient-to-b from-gray-800 to-gray-900 text-gray-200">
    <div class="max-w-screen-xl mx-auto px-4 py-4 flex justify-between items-center">
    <a class="text-2xl font-bold text-white">LET'S READ</a>
        <div class="hidden md:flex space-x-6">
            <a href="admin.php" class="text-white hover:text-gray-400">Home</a>
            <a href="createaccount.php" class="text-white hover:text-gray-400">Join Us</a>
            <a href="aboutus.php" class="text-white hover:text-gray-400">About Us</a>
        </div>
        <div class="bg-yellow-500 text-black py-2 px-4 rounded-full">
          Hai, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : "Guest"; ?>
      </div>
  </nav>

  <div class="container mt-5">
    <h1 class="text-4xl text-white text-center font-bold mb-5">About Us - Kelompok 3</h1>
    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="team-member-card">
          <img src="assets/image.png" alt="Suipolah" class="card-img-top">
          <h3 class="card-title">Suipolah (22)</h3>
          <p class="text-gray-400 card-body">Raja UI/UX</p>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="team-member-card">
          <img src="assets/may.png" alt="Aurachan" class="card-img-top">
          <h3 class="card-title">Aurachan (24)</h3>
          <p class="text-gray-400 card-body">Am Plis Naspad Am</p>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="team-member-card">
          <img src="assets/amer.png" alt="Mericans" class="card-img-top">
          <h3 class="card-title">Mericans (25)</h3>
          <p class="text-gray-400 card-body">Mie Ayam yrpp Am</p>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-4 mb-4">
        <div class="team-member-card">
          <img src="assets/iam.jpg" alt="Iamgalak" class="card-img-top">
          <h3 class="card-title">Iamgalak(27)</h3>
          <p class="text-gray-400 card-body">Oke mie ayam wong 6 ya</p>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="team-member-card">
          <img src="assets/gwe.png" alt="Aryangetuk" class="card-img-top">
          <h3 class="card-title">Aryangetuk(28)</h3>
          <p class="text-gray-400 card-body">Raja PHP</p>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="team-member-card">
          <img src="assets/ijo.png" alt="Salsakopling" class="card-img-top">
          <h3 class="card-title">Salsakopling(36)</h3>
          <p class="text-gray-400 card-body">Salsa Kopling</p>
        </div>
      </div>
    </div>
  </div>


</body>
</html>

<?php include 'layout/footer.php' ?>
