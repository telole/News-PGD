<?php
session_start();
include 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (username, email, password, role) VALUES ('$username', '$email', '$password', 'user')";
    if ($conn->query($sql)) {
        $_SESSION['success_message'] = "Account created successfully";
        header("Location: createAccount.php?success=1");
        exit();
    } else {
        $_SESSION['error_message'] = "Account gagal dibuat";
        header("Location: createAccount.php?success=0");
        exit();
    }
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .footer-custom {
            background-color: #222;
            color: #fff;
            padding: 1rem;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .alert-card {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            text-align: center;
        }
        @keyframes fadeInScale {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .animate-popup {
            animation: fadeInScale 0.5s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gray-100">

<body class="bg-gray-100">
  <nav class="bg-gradient-to-b from-gray-800 to-gray-900 text-gray-200">
    <div class="max-w-screen-xl mx-auto px-4 py-4 flex justify-between items-center">
      <a class="text-2xl font-bold" href="#">LET'S READ</a>
      <div class="hidden md:flex space-x-6">
        <a href="index.php" class="hover:text-gray-400">Home</a>
        <a href="aboutUs.php" class="hover:text-gray-400">About Us</a>
      </div>
    </div>
  </nav>



    <div class="flex justify-center items-start py-10 bg-gray-100 bg-gradient-to-b from-gray-800 to-gray-900 text-gray-200">
        <div class=" p-8 rounded-lg text-white bg-gray-800 shadow-lg max-w-sm w-full">
            <div class="text-center text-2xl font-bold text-white mb-6">Create an Account</div>
            <form action="" method="POST">
                <div class="mt-4">
                    <label for="username" class="block text-sm font-medium text-white">Username</label>
                    <input type="text" id="username" name="username" class="mt-1 block w-full px-4 py-2 bg-gray-200 text-gray-900 rounded-md" required>
                </div>
                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-white">Email</label>
                    <input type="email" id="email" name="email" class="mt-1 block w-full px-4 py-2 bg-gray-200 text-gray-900 rounded-md" required>
                </div>
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-white">Password</label>
                    <input type="password" id="password" name="password" class="mt-1 block w-full px-4 py-2 bg-gray-200 text-gray-900 rounded-md" required>
                </div>
                <button type="submit" class="w-full mt-6 py-2 bg-yellow-500 text-white font-bold rounded-md">Create Account</button>
            </form>
        </div>
    </div>

    <div id="popup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden ">
        <div class="bg-green-50 rounded-lg shadow-lg w-96 p-6 text-center animate-popup">
            <h2 class="text-xl font-semibold mt-2" id="popupMessage"></h2>
            <button id="closePopupBtn" class="mt-6 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">OK</button>
        </div>
    </div>

    <!-- <footer class="bg-black text-white py-4 text-center">
      <p>&copy; 2024 LET'S READ. All Rights Reserved.</p>
    </footer> -->

    <script>
        const popup = document.getElementById('popup');
        const popupMessage = document.getElementById('popupMessage');
        const closePopupBtn = document.getElementById('closePopupBtn');

        const urlParams = new URLSearchParams(window.location.search);
        const success = urlParams.get('success');

        if (success === '1') {
            popupMessage.innerText = "Account created successfully!";
            popup.classList.remove('hidden');
        } else if (success === '0') {
            popupMessage.innerText = "Account creation failed!";
            popup.classList.remove('hidden');
        }

        closePopupBtn.addEventListener('click', () => {
            popup.classList.add('hidden');
            if (success === '1') {
                window.location.href = 'Login.php';
            }
        });
    </script>
</body>
</html>


<?php include 'layout/footer.php' ?>

