<?php
// Sidebar partial for admin pages
?>
<?php
// decide which filter is currently selected (used to highlight active item)
$filter = $_GET['filter'] ?? 'all';
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
            <div class="dropdown">
                <a class="nav-link dropdown-toggle<?= in_array($filter, ['all', 'quarrysite', 'ccr']) ? ' active' : '' ?>" href="#" id="dbDropdownMobile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Database
                </a>
                <ul class="dropdown-menu" aria-labelledby="dbDropdownMobile">
                    <li><a class="dropdown-item<?= $filter === 'all' ? ' active' : '' ?>" href="view_registrations.php?filter=all">All registrations</a></li>
                    <!-- <li><a class="dropdown-item<?= $filter === 'quarrysite' ? ' active' : '' ?>" href="view_registrations.php?filter=quarrysite">Quarrysite registrations</a></li> -->
                    <li><a class="dropdown-item<?= $filter === 'ccr' ? ' active' : '' ?>" href="view_registrations.php?filter=ccr">CCR registrations</a></li>
                </ul>
            </div>
            <a class="nav-link" href="logout.php">Logout</a>
        </nav>
    </div>
</div>

<!-- Desktop Sidebar -->
<aside class="col-lg-2 d-none d-lg-block bg-light sidebar p-3">
    <nav class="nav flex-column">
        <a class="nav-link" href="../index.php">New Registration</a>
        <div class="dropdown">
            <a class="nav-link dropdown-toggle<?= in_array($filter, ['all', 'quarrysite', 'ccr']) ? ' active' : '' ?>" href="#" id="dbDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Database
            </a>
            <ul class="dropdown-menu" aria-labelledby="dbDropdown">
                <li><a class="dropdown-item<?= $filter === 'all' ? ' active' : '' ?>" href="view_registrations.php?filter=all">All registrations</a></li>
                <!-- <li><a class="dropdown-item<?= $filter === 'quarrysite' ? ' active' : '' ?>" href="view_registrations.php?filter=quarrysite">Quarrysite registrations</a></li> -->
                <li><a class="dropdown-item<?= $filter === 'ccr' ? ' active' : '' ?>" href="view_registrations.php?filter=ccr">CCR registrations</a></li>
            </ul>
        </div>
        <a class="nav-link" href="logout.php">Logout</a>
    </nav>
</aside>

<!-- 
Database onclick is to be a bootsrap dropdown comprises of, 
 --- all registration,
 --- quarrysite registrations,
 --- CCR registration, as dropdown items nav link.
If all registration onclick,the display on view_registration.php should be the result of select all from registrants.
If CCR registrations onclick,the display on view_registration.php should be the result of select all from attedance where event = Christian Couples Retreat (CCR) and year = current year. 
 -->