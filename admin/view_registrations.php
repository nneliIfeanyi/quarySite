<?php
session_start();

// Check if admin is logged in, otherwise redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

require_once '../includes/db_connect.php';
require_once '../includes/config.php';

$search = $_GET['search'] ?? '';
$filter_sql = '';
$params = [];

if (!empty($search)) {
    $filter_sql = " WHERE full_name LIKE ? OR email LIKE ?";
    $params = ["%$search%", "%$search%"];
}

// Fetch registrants from the database
$stmt = $pdo->prepare("SELECT * FROM registrants" . $filter_sql . " ORDER BY id DESC");
$stmt->execute($params);
$registrants = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Admin Dashboard - Registrations</h2>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

        <form action="view_registrations.php" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search by name or email" name="search" value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
                <a href="view_registrations.php" class="btn btn-outline-secondary">Clear</a>
            </div>
        </form>

        <?php if (empty($registrants)): ?>
            <div class="alert alert-info">No registrants found.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Organization</th>
                            <th>Photo</th>
                            <th>Registration Tag</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registrants as $registrant): ?>
                            <tr>
                                <td><?= htmlspecialchars($registrant['id']) ?></td>
                                <td><?= htmlspecialchars($registrant['full_name']) ?></td>
                                <td><?= htmlspecialchars($registrant['email']) ?></td>
                                <td><?= htmlspecialchars($registrant['phone']) ?></td>
                                <td><?= htmlspecialchars($registrant['organization']) ?></td>
                                <td>
                                    <?php if ($registrant['photo_path']): ?>
                                        <a href="../<?= htmlspecialchars($registrant['photo_path']) ?>" target="_blank">View Photo</a>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($registrant['registration_tag']) ?></td>
                                <td>
                                    <!-- TODO: Implement PDF re-download functionality here -->
                                    <a href="download_tag.php?tag=<?= htmlspecialchars($registrant['registration_tag']) ?>" class="btn btn-sm btn-info">Re-download Tag</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
