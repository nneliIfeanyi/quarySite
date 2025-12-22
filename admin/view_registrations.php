<?php
session_start();

// Check if admin is logged in, otherwise redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

require_once '../includes/db_connect.php';
require_once '../includes/config.php';

// Fetch all registrants from the database
$stmt = $pdo->prepare("SELECT * FROM registrants ORDER BY id DESC");
$stmt->execute();
$registrants = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/2.1.6/css/dataTables.bootstrap5.css" rel="stylesheet">
    <style>
        /* Sidebar styles */
        .sidebar {
            min-height: 100vh;
        }

        .sidebar .nav-link {
            color: #495057;
        }

        .sidebar .nav-link.active {
            background-color: #e9ecef;
            border-radius: 6px;
            font-weight: 600;
        }

        .content-area {
            padding-top: 1rem;
            padding-bottom: 3rem;
        }

        @media (max-width: 767.98px) {
            .sidebar {
                min-height: auto;
            }
        }
    </style>
</head>

<body>
    <?php require_once __DIR__ . '/inc/nav.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once __DIR__ . '/inc/sidebar.php'; ?>

            <!-- Main content -->
            <main class="col-lg-10 ms-sm-auto px-4 content-area">
                <!-- breadcrumb and title -->
                <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                    <div>
                        <h2 class="h4 mb-0">Registrations</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Registrations</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- end breadcrumb and title -->
                <!-- success and error messages -->
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($_SESSION['success_message']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($_SESSION['error_message']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>
                <!-- end messages -->
                <?php if (empty($registrants)): ?>
                    <div class="alert alert-info">No registrants found.</div>
                <?php else: ?>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="registrantsTable" class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Full Name</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">RL-Code</th>
                                            <th scope="col" class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($registrants as $registrant): ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= htmlspecialchars($registrant['title'] . ' ' . $registrant['surname'] . ' ' . $registrant['othernames']) ?></td>
                                                <td><?= htmlspecialchars($registrant['phone']) ?></td>
                                                <td><?= htmlspecialchars($registrant['registration_tag']) ?></td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group" aria-label="Actions">
                                                        <a href="profile.php?id=<?= htmlspecialchars($registrant['id']) ?>" class="btn btn-sm btn-outline-primary">View</a>
                                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-id="<?= htmlspecialchars($registrant['id']) ?>" data-name="<?= htmlspecialchars($registrant['title'] . ' ' . $registrant['surname'] . ' ' . $registrant['othernames']) ?>">Delete</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php require_once __DIR__ . '/inc/footer.php'; ?>

                <!-- Delete confirmation modal -->
                <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form method="POST" action="delete_registration.php">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmDeleteLabel">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete <strong id="deleteRegistrantName"></strong>?</p>
                                    <input type="hidden" name="id" id="deleteRegistrantId" value="">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
                <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
                <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
                <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script>
                <script>
                    $(document).ready(function() {
                        $('#registrantsTable').DataTable({
                            responsive: true,
                            pageLength: 10,
                            lengthMenu: [5, 10, 25, 50, 100]
                        });

                        // Delete modal handling
                        var confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));

                        $(document).on('click', '.btn-delete', function() {
                            var id = $(this).data('id');
                            var name = $(this).data('name');
                            $('#deleteRegistrantId').val(id);
                            $('#deleteRegistrantName').text(name);
                            confirmDeleteModal.show();
                        });
                    });
                </script>
</body>

</html>