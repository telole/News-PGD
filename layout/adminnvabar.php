<?php
include 'config/app.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Olympics News Page</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

  <style>
    /* .navbar-custom {
      background-color: #000;
      color: #fff;
    }
    .navbar-custom .navbar-nav .nav-link, .navbar-custom .navbar-brand {
      color: #fff;
    }
    .header-banner {
      background-color: whitesmoke;
      padding: 0.5rem 0;
      text-align: center;
    }
    .main-article img {
      width: 100%;
      height: auto;
      border-radius: 5px;
    }
    .main-article h2 {
      font-size: 2rem;
      font-weight: bold;
    }
    .main-article p {
      font-size: 0.9rem;
      color: gray;
    }
    .sidebar-article h6 {
      font-size: 1rem;
      font-weight: bold;
    }
    .section-title {
      font-weight: bold;
      margin-top: 2rem;
      font-size: 1.5rem;
      text-transform: uppercase;
    }
    .latest-articles .card-title, .news-videos .card-title, .basketball-news .card-title {
      font-size: 0.9rem;
      font-weight: bold;
    }
    .footer-custom {
      background-color: #222;
      color: #fff;
      padding: 2rem;
    }
    .footer-custom a {
      color: #aaa;
    }
    .basketball-news {
  flex-wrap: nowrap; }

.basketball-news .col-md-3 {
  flex: 0 0 auto; 
  width: 25%;
}

.basketball-news::-webkit-scrollbar {
  height: 8px;
}

.basketball-news::-webkit-scrollbar-thumb {
  background-color: darkgray;
  border-radius: 10px;
}

.basketball-news::-webkit-scrollbar-track {
  background: #f1f1f1;
}
.footer-custom {
      background-color: #222;
      color: #fff;
      padding: 1rem;
      text-align: center;
      position: fixed;
      bottom: 0;
      width: 100%;
} */

    
  </style>
</head>
<body>
<nav class="bg-gradient-to-b from-gray-800 to-gray-900 text-gray-200">
    <div class="max-w-screen-xl mx-auto px-4 py-4 flex justify-between items-center">
        <a class="text-2xl font-bold text-white">LET'S READ</a>
        <div class="hidden md:flex space-x-6">
            <a href="admin.php" class="text-white hover:text-gray-400">Home</a>
            <a href="userlist.php" class="text-white hover:text-gray-400">User List</a>
            <a href="aboutus1.php" class="text-white hover:text-gray-400">About Us</a>
        </div>
        
        <div class="flex items-center space-x-2">
            <div class="bg-yellow-500 text-black py-2 px-4 rounded-full">
                Hai, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : "Guest"; ?>
            </div>
            <i class="bx bxs-plus-circle text-black py-2 rounded-full px-4  bg-yellow-500 "><a href="Add.php" class=>Tambah Article!</a></i>
        </div>
    </div>
</nav>
