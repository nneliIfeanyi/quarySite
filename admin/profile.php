<?php
session_start();

// Check if admin is logged in, otherwise redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

require_once '../includes/db_connect.php';
require_once '../includes/config.php';

$registrant_id = $_GET['id'] ?? null;

if (!$registrant_id || !is_numeric($registrant_id)) {
    header('Location: view_registrations.php');
    exit();
}

// Fetch registrant from the database
$stmt = $pdo->prepare("SELECT * FROM registrants WHERE id = ?");
$stmt->execute([$registrant_id]);
$registrant = $stmt->fetch();

if (!$registrant) {
    header('Location: view_registrations.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrant Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                    <div>
                        <h2 class="h4 mb-0">Registrant Profile</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="view_registrations.php">Registrations</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($registrant['title'] . ' ' . $registrant['surname'] . ' ' . $registrant['othernames']) ?></li>
                            </ol>
                        </nav>
                    </div>
                    <a href="view_registrations.php" class="btn btn-outline-secondary">Back to List</a>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 offset-md-4 text-center mb-3">
                                <?php
                                // Determine image to display: custom photo, otherwise gender-based placeholder
                                $photoPath = null;
                                if (!empty($registrant['photo']) && file_exists(__DIR__ . '/../uploads/' . $registrant['photo'])) {
                                    $photoPath = '../uploads/' . $registrant['photo'];
                                } else {
                                    // fallback based on gender
                                    $gender = strtolower($registrant['gender'] ?? '');
                                    if ($gender === 'female' || $gender === 'f') {
                                        $photoPath = '../assets/img/female.png';
                                    } else {
                                        $photoPath = '../assets/img/male.png';
                                    }
                                }
                                ?>
                                <img src="<?= htmlspecialchars($photoPath) ?>" alt="Registrant Photo" class="img-fluid rounded mb-3" style="max-height:200px; object-fit:cover;">
                                <div class="small text-muted">Registrant ID: <?= htmlspecialchars($registrant['registration_tag']) ?></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted">Full Name</h6>
                                <p class="h5"><?= htmlspecialchars($registrant['title'] . ' ' . $registrant['surname'] . ' ' . $registrant['othernames']) ?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted">Email</h6>
                                <p class="h5"><?= htmlspecialchars($registrant['email']) ?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted">Phone</h6>
                                <p class="h5"><?= htmlspecialchars($registrant['phone']) ?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted">Age Range</h6>
                                <p class="h5"><?= htmlspecialchars($registrant['age'] ?? 'N/A') ?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted">Gender</h6>
                                <p class="h5"><?= htmlspecialchars($registrant['gender'] ?? 'N/A') ?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted">Marital Status</h6>
                                <p class="h5"><?= htmlspecialchars($registrant['marital_status'] ?? 'N/A') ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted">Trained As</h6>
                                <p class="h5"><?= htmlspecialchars($registrant['trained_as'] ?? 'N/A') ?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted">Occupation</h6>
                                <p class="h5"><?= htmlspecialchars($registrant['occupation']) ?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted">State of Residence</h6>
                                <p class="h5"><?= htmlspecialchars($registrant['state_of_residence']) ?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted">L.G.A</h6>
                                <p class="h5"><?= htmlspecialchars($registrant['lga'] ?? 'N/A') ?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted">Denomination</h6>
                                <p class="h5"><?= htmlspecialchars($registrant['church_assembly'] ?? 'N/A') ?></p>
                            </div>
                            <div class="col-md-12 mb-3">
                                <h6 class="text-muted">Address</h6>
                                <p class="h5"><?= htmlspecialchars($registrant['residence'] ?? 'N/A') ?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted">Registration Date</h6>
                                <p class="h5"><?= htmlspecialchars($registrant['registration_date'] ?? 'N/A') ?></p>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex gap-2">
                            <a href="download_tag.php?id=<?= rawurlencode($registrant['registration_tag']) ?>" class="btn btn-success">Download Tag</a>
                            <button type="button" class="btn btn-danger btn-delete" data-id="<?= htmlspecialchars($registrant['id']) ?>" data-name="<?= htmlspecialchars($registrant['title'] . ' ' . $registrant['surname'] . ' ' . $registrant['othernames']) ?>">Delete Registration</button>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modalEl = document.getElementById('confirmDeleteModal');
            var modal = new bootstrap.Modal(modalEl);
            var btn = document.querySelector('.btn-delete');
            if (btn) {
                btn.addEventListener('click', function() {
                    var id = this.getAttribute('data-id');
                    var name = this.getAttribute('data-name');
                    document.getElementById('deleteRegistrantId').value = id;
                    document.getElementById('deleteRegistrantName').textContent = name;
                    modal.show();
                });
            }
        });
    </script>
</body>

</html>