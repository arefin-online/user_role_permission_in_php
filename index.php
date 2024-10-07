<?php include('header.php'); ?>

<?php
if(!isset($_SESSION['user'])) {
    header('location: login.php');
    exit;
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM roles");
$statement->execute();
$total_roles = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM users");
$statement->execute();
$total_users = $statement->rowCount();
?>

<?php include('top.php'); ?>

<div class="right-part container-fluid">
    <div class="row">
        
        <?php include('sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4 pb-3">

            <h1 class="page-heading">Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="box">
                        <div class="number"><?php echo $total_roles; ?></div>
                        <div class="text">Roles</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box">
                        <div class="number"><?php echo $total_users; ?></div>
                        <div class="text">Users</div>
                    </div>
                </div>
            </div>

            <h2 class="page-heading mt_10">Recent Users</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=0;
                        $statement = $pdo->prepare("SELECT t1.*, t2.id as role_id, t2.name as role_name 
                                                FROM users t1
                                                JOIN roles t2
                                                ON t1.role_id = t2.id
                                                ORDER BY t1.id DESC LIMIT 3");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['role_name']; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div>

<?php include('footer.php'); ?>