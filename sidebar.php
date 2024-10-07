<nav id="sidebarMenu" class="col-md-3 col-lg-3 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">

            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="index.php">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
            </li>

            <?php if($arr[1] == 1): ?>
            <li class="nav-item">
                <a class="nav-link" href="feature-view.php">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Features
                </a>
            </li>
            <?php endif; ?>

            <?php if($arr[5] == 1): ?>
            <li class="nav-item">
                <a class="nav-link" href="role-view.php">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Roles
                </a>
            </li>
            <?php endif; ?>

            <?php if($arr[6] == 1): ?>
            <li class="nav-item">
                <a class="nav-link" href="user-view.php">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Users
                </a>
            </li>
            <?php endif; ?>

        </ul>
    </div>
</nav>