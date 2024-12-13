<?php
include 'layout/waslogin.php';

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

