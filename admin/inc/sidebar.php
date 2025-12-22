<?php
// Sidebar partial for admin pages
?>
<!-- Offcanvas Sidebar (for mobile) -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasSidebarLabel">Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <nav class="nav flex-column sidebar p-3">
            <a class="nav-link" href="../index.php">New Registration</a>
            <a class="nav-link active" href="view_registrations.php">Registrations</a>
            <a class="nav-link" href="logout.php">Logout</a>
        </nav>
    </div>
</div>

<!-- Desktop Sidebar -->
<aside class="col-lg-2 d-none d-lg-block bg-light sidebar p-3">
    <nav class="nav flex-column">
        <a class="nav-link" href="../index.php">New Registration</a>
        <a class="nav-link active" href="view_registrations.php">Registrations</a>
        <a class="nav-link" href="logout.php">Logout</a>
    </nav>
</aside>