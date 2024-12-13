<?php
include 'config/database.php';
include 'layout/waslogin.php';

if (isset($_GET['id_berita'])) {
    $id_berita = $_GET['id_berita'];

    $query = "SELECT * FROM portal_berita WHERE id_berita = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id_berita);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $article = $result->fetch_assoc();
    } else {
        echo "Artikel tidak ditemukan!";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tanggal = $_POST['tanggal'];
    $foto = $_FILES['foto']['name'];
    $artikel = $_POST['artikel'];
    $kategori = $_POST['kategori'];

    if ($foto) {
        $target_dir = "assets/"; 
        $target_file = $target_dir . basename($foto);
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            $fotoQueryPart = ", foto = '$foto'";
        } else {
            $fotoQueryPart = "";
        }
    } else {
        $fotoQueryPart = "";
    }

    $updateQuery = "UPDATE portal_berita SET 
                    judul = ?, 
                    penulis = ?, 
                    tanggal = ?, 
                    artikel = ?, 
                    kategori = ? 
                    $fotoQueryPart 
                    WHERE id_berita = ?";
                    
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('sssssi', $judul, $penulis, $tanggal, $artikel, $kategori, $id_berita);
    
    if ($stmt->execute()) {
        header("Location: admin.php?id_berita=$id_berita&success=1");
        exit();
    } else {
        header("Location: admin.php?id_berita=$id_berita&success=0");
        exit();
    }
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

    .header-banner {
        background-color: #F1F5F9; 
        padding: 1rem 0;
        text-align: center;
    }
</style>

<body class="bg-gray-900 text-white">

<div class="flex justify-center items-start py-10">
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg max-w-lg w-full">
    <h1 class="text-3xl font-bold text-center text-white">Update Article</h1>
    <p class="text-white mt-2 text-center">Edit your article details below</p>
        <form action="update.php?id_berita=<?php echo $id_berita; ?>" method="POST" enctype="multipart/form-data">
            <div class="mt-4">
                <label for="judul" class="block text-sm font-medium text-gray-400">Judul Artikel</label>
                <input type="text" id="judul" name="judul" class="mt-1 block w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" value="<?php echo htmlspecialchars($article['judul']); ?>" required placeholder="Masukkan Judul Artikel">
            </div>

            <div class="mt-4">
                <label for="penulis" class="block text-sm font-medium text-gray-400">Penulis</label>
                <input type="text" id="penulis" name="penulis" class="mt-1 block w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" value="<?php echo htmlspecialchars($article['penulis']); ?>" required placeholder="Masukkan Nama Penulis">
            </div>

            <div class="mt-4">
                <label for="tanggal" class="block text-sm font-medium text-gray-400">Tanggal Artikel</label>
                <input type="date" id="tanggal" name="tanggal" class="mt-1 block w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" value="<?php echo $article['tanggal']; ?>" required>
            </div>

            <div class="mt-4">
                <label for="foto" class="block text-sm font-medium text-gray-400">Foto Artikel</label>
                <input type="file" id="foto" name="foto" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:bg-gray-700 file:text-gray-200 file:rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                <small class="text-sm text-gray-500">Max file size: 2MB. Supported formats: JPG, PNG, GIF. Leave blank to keep current image.</small>
            </div>

            <div class="mt-4">
                <label for="artikel" class="block text-sm font-medium text-gray-400">Isi Artikel</label>
                <textarea id="artikel" name="artikel" class="mt-1 block w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" rows="5" required placeholder="Tulis artikel Anda di sini..."><?php echo htmlspecialchars($article['artikel']); ?></textarea>
            </div>

            <div class="mt-4">
                <label for="kategori" class="block text-sm font-medium text-gray-400">Kategori</label>
                <select id="kategori" name="kategori" class="mt-1 block w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    <option value="olahraga" <?php echo $article['kategori'] == 'olahraga' ? 'selected' : ''; ?>>Olahraga</option>
                    <option value="makanan" <?php echo $article['kategori'] == 'makanan' ? 'selected' : ''; ?>>Makanan</option>
                    <option value="kesehatan" <?php echo $article['kategori'] == 'kesehatan' ? 'selected' : ''; ?>>Kesehatan</option>
                    <option value="teknologi" <?php echo $article['kategori'] == 'teknologi' ? 'selected' : ''; ?>>Teknologi</option>
                </select>
            </div>

            <div id="popup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden ">
                <div class="bg-green-50 rounded-lg shadow-lg w-96 p-6 text-center animate-popup">
                    <h2 class="text-xl font-semibold mt-2" id="popupMessage"></h2>
                    <button id="closePopupBtn" class="mt-6 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">OK</button>
                 </div>
            </div>

            <button type="submit" class="w-full mt-6 py-2 bg-yellow-500 text-black font-bold rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500">Update Artikel</button>
        </form>
    </div>
</div>

<footer class="bg-gray-900 text-white py-4 text-center">
    <p>&copy; 2024 LET'S READ. All Rights Reserved.</p>
</footer>

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
                window.location.href = 'admin.php';
            }
        });
</script>
</body>
</html>
