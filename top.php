<?php
$statement = $pdo->prepare("SELECT * FROM role_permissions WHERE role_id=?");
$statement->execute([$_SESSION['user']['role_id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $arr[$row['role_task_id']] = $row['access'];
}
?>
<header class="navbar navbar-custom-color sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="index.php">Admin Panel</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
        data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-nav flex-row">
        <div class="nav-item text-nowrap">
            <a class="nav-link px-3" href="javascript:void;">Logged in as <?php echo $_SESSION['user']['name']; ?></a>
        </div>
        <div class="nav-item text-nowrap">
            <a class="nav-link px-3" href="profile.php"><i class="fas fa-user"></i> Edit Profile</a>
        </div>
        <div class="nav-item text-nowrap">
            <a class="nav-link px-3" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
</header>