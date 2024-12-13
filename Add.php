<?php
include 'config/database.php';
include 'layout/adminnvabar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tanggal = $_POST['tanggal'];
    $foto = $_FILES['foto']['name'];
    $artikel = $_POST['artikel'];
    $kategori = $_POST['kategori'];

    $target_dir = "assets/"; 
    $target_file = $target_dir . basename($foto);

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
        $query = "INSERT INTO portal_berita (judul, penulis, tanggal, foto, artikel, kategori) 
                  VALUES ('$judul', '$penulis', '$tanggal', '$foto', '$artikel', '$kategori')";

        if ($conn->query($query) === TRUE) {
            header("Location: Add.php?success=1");
            exit();
        } else {
            header("Location: Add.php?success=0");
            exit();
        }
    } else {
        header("Location: Add.php?success=0");
        exit();
    }
    

}

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "<script>
            alert('Anda tidak memiliki akses ke halaman ini.');
            window.location.href = 'login.php';
          </script>";
    exit();
}
?>

<style>
    @keyframes rotateIn {
        0% {
            transform: rotate(-180deg) scale(0);
            opacity: 0;
        }
        50% {
            transform: rotate(0deg) scale(1.2);
            opacity: 1;
        }
        100% {
            transform: scale(1);
        }
    }

    @keyframes fadeInScale {
        0% {
            transform: scale(0.8);
            opacity: 0;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .animate-check {
        animation: rotateIn 0.8s ease-out forwards;
    }

    .animate-popup {
        animation: fadeInScale 0.5s ease-out forwards;
    }

    body {
        background-color: #f3f4f6; 
    }

    .bg-gray-800 {
        background-color: #2d2d2d;
    }

    .text-gray-200 {
        color: #d1d5db; 
    }

    .text-gray-800 {
        color: #1f2937; 
    }

    .text-gray-600 {
        color: #4b5563; 
    }

    .bg-gray-200 {
        background-color: #e5e7eb; 
    }

    .focus\:ring-yellow-500:focus {
        ring-color: #f59e0b; 
    }

    .bg-yellow-500 {
        background-color: #f59e0b; 
    }

    .bg-yellow-600 {
        background-color: #d97706; 
    }
    
    .popup-container {
        max-width: 400px;
    }

    .bg-green-50 {
        background-color: #f0fdf4; 
    }

    .text-green-500 {
        color: #10b981; 
    }

    .bg-green-500 {
        background-color: #10b981;
    }

    .hover\:bg-green-600:hover {
        background-color: #059669; 
    }

    .text-white {
        color: #ffffff; 
    }

    .text-xl {
        font-size: 1.25rem;
    }
</style>

<div class="flex bg-gray-900 justify-center items-start py-10">
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg max-w-lg w-full">
        <div class="text-center text-2xl font-bold text-white mb-6">Create a New Article</div>
        <form action="Add.php" method="POST" enctype="multipart/form-data">
            <div class="mt-4">
                <label for="judul" class="block text-sm font-medium text-white">Judul Artikel</label>
                <input type="text" id="judul" name="judul" class="mt-1 block w-full px-4 py-2 bg-gray-200 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" required placeholder="Masukkan Judul Artikel">
            </div>

            <div class="mt-4">
                <label for="penulis" class="block text-sm font-medium text-white">Penulis</label>
                <input type="text" id="penulis" name="penulis" class="mt-1 block w-full px-4 py-2 bg-gray-200 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" required placeholder="Masukkan Nama Penulis">
            </div>

            <div class="mt-4">
                <label for="tanggal" class="block text-sm font-medium text-white">Tanggal Artikel</label>
                <input type="date" id="tanggal" name="tanggal" class="mt-1 block w-full px-4 py-2 bg-gray-200 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
            </div>

            <div class="mt-4">
                <label for="foto" class="block text-sm font-medium text-white">Foto Artikel</label>
                <div class="relative mt-1">
                    <input type="file" id="foto" name="foto" class="block w-full text-sm text-white file:mr-4 file:py-2 file:px-4 file:bg-gray-200 file:text-gray-700 file:rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                </div>
                <small class="text-sm text-white">Max file size: 2MB. Supported formats: JPG, PNG, GIF.</small>
            </div>

            <div class="mt-4">
                <label for="artikel" class="block text-sm font-medium text-white">Isi Artikel</label>
                <textarea id="artikel" name="artikel" class="mt-1 block w-full px-4 py-2 bg-gray-200 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" rows="5" required placeholder="Tulis artikel Anda di sini..."></textarea>
            </div>

            <div class="mt-4">
                <label for="kategori" class="block text-sm font-medium text-white">Kategori</label>
                <select id="kategori" name="kategori" class="mt-1 block w-full px-4 py-2 bg-gray-200 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    <option value="olahraga">Olahraga</option>
                    <option value="makanan">Makanan</option>
                    <option value="kesehatan">Kesehatan</option>
                    <option value="teknologi">Teknologi</option>
                </select>
            </div>

            <button type="submit" class="w-full mt-6 py-2 bg-yellow-500 text-white font-bold rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500">Submit Artikel</button>
        </form>
    </div>
</div>


<div id="popup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-green-50 rounded-lg shadow-lg w-96 p-6 text-center animate-popup">
        <div class="flex justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h2 class="text-xl font-semibold mt-2" id="popupMessage"></h2>
        <div class="flex justify-center gap-4 mt-6">
            <button id="closePopupBtn" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">OK</button>
            <button id="backIndex" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Article</button>
        </div>
    </div>
</div>

<footer class="bg-gray-800 text-white py-4 text-center">
    <p>&copy; 2024 LET'S READ. All Rights Reserved.</p>
</footer>

<script>
    const popup = document.getElementById('popup');
    const popupMessage = document.getElementById('popupMessage');
    const backIndex = document.getElementById('backIndex');
    const closePopupBtn = document.getElementById('closePopupBtn');

    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');

    if (success === '1') {
        popupMessage.innerText = "Article Submitted Successfully";
        popup.classList.remove('hidden');
    } else if (success === '0') {
        popupMessage.innerText = "Cannot Add Article";
        popup.classList.remove('hidden');
    }

    closePopupBtn.addEventListener('click', () => {
        popup.classList.add('hidden');
        if (success === '1') {
            window.location.href = 'Add.php';
        }
    });

    backIndex.addEventListener('click', () => {
        popup.classList.add('hidden');
        if (success === '1') {
            window.location.href = 'admin.php';
        }
    });
</script>

</body>
</html>
