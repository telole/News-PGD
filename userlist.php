<?php
include 'layout/adminnvabar.php';

$sql = "SELECT * FROM user";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_role'])) {
    $userId = $_POST['id_user'];
    $newRole = $_POST['role'];

    $updateSql = "UPDATE user SET role = ? WHERE id_user = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("si", $newRole, $userId);

    if ($stmt->execute()) {
        echo "<script>alert('Role updated successfully');</script>";
        echo "<script>window.location.href = 'userlist.php';</script>";
    } else {
        echo "<script>alert('Failed to update role');</script>";
    }
    $stmt->close();
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
    <title>Manage Members</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-200 min-h-screen">
    <header class="bg-gray-800 text-gray-200">
    </header>

    <main class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-100">Manage Members</h1>
        </div>

        <div class="overflow-x-auto bg-gray-800 rounded-lg shadow">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-700 text-gray-200 text-left">
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-300">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='hover:bg-gray-700'>
                                <td class='px-4 py-3'>" . htmlspecialchars($row['username']) . "</td>
                                <td class='px-4 py-3'>" . ucfirst(htmlspecialchars($row['role'])) . "</td>
                                <td class='px-4 py-3'>
                                    <form method='POST' class='flex space-x-2'>
                                        <input type='hidden' name='id_user' value='" . $row['id_user'] . "'>
                                        <select name='role' class='border border-gray-600 bg-gray-700 text-gray-200 rounded px-2 py-1'>
                                            <option value='user'" . ($row['role'] === 'user' ? ' selected' : '') . ">user</option>
                                            <option value='admin'" . ($row['role'] === 'admin' ? ' selected' : '') . ">Admin</option>
                                        </select>
                                        <button type='submit' name='update_role' class='bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition'>
                                            Update
                                        </button>
                                    </form>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr>
                                <td colspan='3' class='text-center py-6 text-gray-400'>
                                    No members found
                                </td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="mt-8 p-4 bg-gray-800 rounded-md border border-gray-700">
            <h2 class="text-lg font-semibold text-white">Access Control</h2>
            <p class="text-gray-400 mt-2">
                Manage team members of your organization and set their access levels.
                <br>
                <strong class="text-white">Admin role:</strong> Admins have access to organization settings, billing, and member management.
                <br>
                <strong class="text-white">Member role:</strong> Members can access services but cannot edit organization settings.
            </p>
        </div>
    </main>
</body>
</html>
<?php
$conn->close();
include 'layout/footer.php';
?>
