<?php

  include 'layout/adminnvabar.php'; 
    $queries = [
        'main_article' => "SELECT id_berita, judul, penulis, tanggal, foto, artikel, kategori FROM portal_berita ORDER BY tanggal DESC LIMIT 1",
        'sidebar' => "SELECT id_berita, judul, penulis, tanggal, kategori, foto FROM portal_berita ORDER BY tanggal DESC LIMIT 4",
        'latest' => "SELECT id_berita, judul, foto, kategori FROM portal_berita ORDER BY tanggal DESC LIMIT 4",
        'sports' => "SELECT id_berita, judul, foto, kategori FROM portal_berita WHERE kategori = 'Olahraga' ORDER BY tanggal DESC",
        'food' => "SELECT id_berita, judul, foto, kategori FROM portal_berita WHERE kategori = 'Makanan' ORDER BY tanggal DESC",
        'health' => "SELECT id_berita, judul, foto, kategori FROM portal_berita WHERE kategori = 'Kesehatan' ORDER BY tanggal DESC",
        'technology' => "SELECT id_berita, judul, foto, kategori FROM portal_berita WHERE kategori = 'Teknologi' ORDER BY tanggal DESC"
    ];

  $results = [];
  foreach ($queries as $key => $query) {
      $results[$key] = $conn->query($query);
  }
  $main_article = $results['main_article']->num_rows > 0 ? $results['main_article']->fetch_assoc() : null;

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id_berita = $_POST['id_berita'];

      if (isset($id_berita) && is_numeric($id_berita)) {
          $sql_delete = "DELETE FROM portal_berita WHERE id_berita = ?";
          $stmt = $conn->prepare($sql_delete);
          $stmt->bind_param('i', $id_berita);

          if ($stmt->execute()) {
              header("Location: admin.php?message=delete_success");
              exit();
          } else {
              echo "Gagal menghapus artikel.";
          }
      }
  }

  if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "<script>
            alert('Anda tidak memiliki akses ke halaman ini.');
           document.location.href = 'index.php';
          </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Berita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-gray-800 to-gray-900">

  <div class="bg-gradient-to-b from-gray-800 to-gray-900 text-gray-200">
      <div class="container mx-auto px-6 py-4 flex justify-between items-center">
          <div class="text-2xl font-bold text-white">Temukan!</div>
          <div class="flex-1 mx-6">
              <div class="relative">
                  <input type="text" class="w-full rounded-full bg-gray-700 text-sm px-4 py-2 text-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500" placeholder="Cari di web...">
                  <button class="absolute right-0 top-0 mt-2 mr-4 text-gray-400">
                      <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l4-4-4-4m4 4H4m16 4v-8" />
                      </svg>
                  </button>
              </div>
          </div>
          <div class="flex items-center space-x-4">
              <span class="text-sm">27°C</span>
              <span class="text-sm">English</span>
          </div>
      </div> 
      <div class="container mx-auto px-6 py-4">
          <div class="grid grid-cols-4 md:grid-cols-8 gap-4">
            <?php 
            $jumlah = 8;

            for ($i = 1; $i <= $jumlah; $i++) {
                echo '
                <a href="#" class="flex flex-col items-center space-y-2 text-gray-300 hover:text-white">
                    <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center">
                        <img src="assets/img2.jpg" alt="Icon ' . $i . '" class="w-6 h-6 rounded-full">
                    </div>
                    <span class="text-sm">ChatGPT</span>
                </a>
                ';
            }
            ?>

          </div>
      </div>
  </div>
  </div>

  <div class="container mx-auto p-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2">
            <div class="relative group bg-gray-800 rounded-lg shadow-md p-4">
                <?php if ($main_article): ?>
                    <p class="text-sm text-gray-400">
                        By <?php echo $main_article['penulis']; ?> | <?php echo $main_article['kategori']; ?> | 6 min read
                    </p>
                    <h2 class="text-2xl font-bold text-gray-200 mb-4"><?php echo $main_article['judul']; ?></h2>
                    <img src="assets/<?php echo $main_article['foto']; ?>" alt="Main Article Image" class="w-full h-64 object-cover mb-4">
                    <p class="text-gray-300"><?php echo substr($main_article['artikel'], 0, 200); ?>...</p>
                    <div class="absolute bottom-2 right-2 space-x-2 opacity-0 group-hover:opacity-100 transition-opacity flex">
                    <button onclick="window.location.href='update.php?id_berita=<?php echo $main_article['id_berita']; ?>';" class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-2 rounded-lg flex items-center">
                        <i class='bx bx-pencil text-xl'></i>
                    </button>
                    <form action="admin.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?')">
                        <input type="hidden" name="id_berita" value="<?php echo $main_article['id_berita']; ?>">
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-2 rounded-lg flex items-center">
                            <i class='bx bx-trash text-xl'></i> 
                        </button>
                    </form>
                </div>
                <?php else: ?>
                    <p class="text-gray-400">No articles found.</p>
                <?php endif; ?>
            </div>
        </div>

        <div>
            <?php while ($sidebar_row = $results['sidebar']->fetch_assoc()): ?>
                <div class="relative group flex items-center bg-gray-800 rounded-lg shadow-md p-3 mb-4">
                    <img src="assets/<?php echo $sidebar_row['foto']; ?>" alt="Sidebar Article" class="w-16 h-16 object-cover rounded-md mr-4">
                    <div>
                        <h6 class="text-sm font-bold text-gray-200"><?php echo $sidebar_row['judul']; ?></h6>
                        <p class="text-xs text-gray-400"><?php echo $sidebar_row['kategori']; ?> | 4 min read</p>
                    </div>

                    <div class="absolute bottom-2 right-2 space-x-2 opacity-0 group-hover:opacity-100 transition-opacity flex">
                    <button onclick="window.location.href='update.php?id_berita=<?php echo $sidebar_row['id_berita']; ?>';" class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-2 rounded-lg flex items-center">
                        <i class='bx bx-pencil text-xl'></i> 
                    </button>
                    <form action="admin.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?')">
                        <input type="hidden" name="id_berita" value="<?php echo $sidebar_row['id_berita']; ?>">
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-2 rounded-lg flex items-center">
                            <i class='bx bx-trash text-xl'></i> 
                        </button>
                    </form>
                </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <h3 class="text-xl font-bold text-white mb-4">Latest Articles</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <?php while ($latest_row = $results['latest']->fetch_assoc()): ?>
            <div class="relative group bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <img src="assets/<?php echo $latest_row['foto']; ?>" alt="Latest Article" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h6 class="text-sm font-bold text-gray-200"><?php echo $latest_row['judul']; ?></h6>
                    <p class="text-xs text-gray-400"><?php echo $latest_row['kategori']; ?> | 3 min read</p>
                </div>
                <div class="absolute bottom-2 right-2 space-x-2 opacity-0 group-hover:opacity-100 transition-opacity flex">
                    <button onclick="window.location.href='update.php?id_berita=<?php echo $latest_row['id_berita']; ?>';" class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-2 rounded-lg flex items-center">
                        <i class='bx bx-pencil text-xl'></i> 
                    </button>
                    <form action="admin.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?')">
                        <input type="hidden" name="id_berita" value="<?php echo $latest_row['id_berita']; ?>">
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-2 rounded-lg flex items-center">
                            <i class='bx bx-trash text-xl'></i> 
                        </button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <div>
        <?php 
        $categories = ['sports' => 'Olahraga', 'food' => 'Makanan', 'health' => 'Kesehatan', 'technology' => 'Teknologi'];
        foreach ($categories as $key => $category): ?>
            <h3 class="text-xl font-bold text-white mb-4"><?php echo $category; ?></h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <?php while ($row = $results[$key]->fetch_assoc()): ?>
                    <div class="relative group bg-gray-800 rounded-lg shadow-md overflow-hidden">
                        <img src="assets/<?php echo $row['foto']; ?>" alt="<?php echo $category; ?>" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h6 class="text-sm font-bold text-gray-200"><?php echo $row['judul']; ?></h6>
                            <p class="text-xs text-gray-400"><?php echo $row['kategori']; ?> | 3 min read</p>
                        </div>
                        <div class="absolute bottom-2 right-2 space-x-2 opacity-0 group-hover:opacity-100 transition-opacity flex">
                            <button onclick="window.location.href='update.php?id_berita=<?php echo $row['id_berita']; ?>';" class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-2 rounded-lg flex items-center">
                                <i class='bx bx-pencil text-xl'></i> 
                            </button>
                            <form action="admin.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?')">
                                <input type="hidden" name="id_berita" value="<?php echo $row['id_berita']; ?>">
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-2 rounded-lg flex items-center">
                                    <i class='bx bx-trash text-xl'></i> 
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endforeach; ?>
    </div>


    <div id="popup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-gray-800 rounded-lg shadow-lg p-6 text-center">
            <h2 class="text-xl text-white mb-4">Akses Ditolak</h2>
            <img src="assets/WhatsApp Video 2024-11-17 at 20.51.48_efb9fa78.mp4" alt="Access Denied" class="mx-auto mb-4">
            <p class="text-white mb-4">Hanya admin yang dapat mengakses halaman ini.</p>
            <button onclick="window.location.href='login.php'" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600">Kembali ke Login</button>
        </div>
    </div>
                    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'): ?>
                document.getElementById('popup').classList.remove('hidden');
            <?php endif; ?>
        });

    </script>


</body>
</html>
<?php include 'layout/footer.php' ?>    
