<?php
session_start();
include 'config/database.php'; 

global $conn;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username =  $_POST['username'];
    $password = $_POST['password'];
    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    if (mysqli_num_rows($result) > 0) {
        $hasil = mysqli_fetch_assoc($result);
        $psw = $hasil['password'];
        $role = $hasil['role']; 

        if (password_verify($password, $psw)) {
            $_SESSION['login'] = true;
            $_SESSION['role'] = $role;
            $_SESSION['username'] = $hasil['username'];

            if ($role == 'admin') {
                header("Location: admin.php");
                exit();
            } elseif ($role == 'user') {
                header("Location: index.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Password salah!";
        }
    } else {
        $_SESSION['error_message'] = "Username tidak ditemukan!";
    }
}
?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
  <nav class="bg-gradient-to-b from-gray-800 to-gray-900 text-gray-200">
    <div class="max-w-screen-xl mx-auto px-4 py-4 flex justify-between items-center">
      <a class="text-2xl font-bold" href="#">LET'S READ</a>
      <div class="hidden md:flex space-x-6">
        <a href="unlog.php" class="hover:text-gray-400">Home</a>
        <a href="CreateAccount.php" class="hover:text-gray-400">Join Us</a>
        <a href="aboutUs.php" class="hover:text-gray-400">About Us</a>
      </div>
    </div>
  </nav>

  <div class="flex justify-center items-start py-10 bg-gray-100 bg-gradient-to-b from-gray-800 to-gray-900 text-gray-200">
    <div class="bg-white p-8 rounded-lg bg-gray-800 shadow-lg max-w-sm w-full">
      <div class="text-center text-2xl font-bold text-white mb-6">Login to Your Account</div>

      <?php if (isset($_SESSION['error_message'])): ?>
        <div class="bg-red-500 text-white p-2 mb-4 rounded">
            <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        </div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-4">
          <label for="username" class="block text-sm font-medium text-white">Username</label>
          <input type="text" id="username" name="username" class="mt-1 block w-full px-4 py-2 bg-gray-200 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Enter your username" required>
        </div>
        <div class="mb-6">
          <label for="password" class="block text-sm font-medium text-white">Password</label>
          <input type="password" id="password" name="password" class="mt-1 block w-full px-4 py-2 bg-gray-200 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Enter your password" required>
        </div>
        <button type="submit" class="w-full py-2 bg-yellow-500 text-white font-bold rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500">Login</button>
        <p class="text-center mt-4 text-sm text-gray-600">Don't have an account? 
        <a href="CreateAccount.php" class="text-yellow-500 hover:underline">Sign Up</a></p>
      </form>
    </div>
  </div>

  <!-- <footer class="bg-gray-900 text-white py-4 text-center">
    <p>&copy; 2024 LET'S READ. All Rights Reserved.</p>
  </footer> -->
</body>
</html>

<?php include 'layout/footer.php' ?>

