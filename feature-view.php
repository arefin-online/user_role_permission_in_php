<?php include('header.php'); ?>

<?php include('top.php'); ?>

<?php
if(!isset($_SESSION['user'])) {
    header('location: login.php');
    exit;
}
?>

<?php
if($arr[1] == 0) {
    header('location: index.php');
    exit;
}
?>

<div class="right-part container-fluid">
    <div class="row">
        
        <?php include('sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4 pb-3">

            <h1 class="page-heading">
                All Features
                <?php if($arr[2] == 1): ?>
                <a href="feature-add.php" class="btn btn-primary btn-sm right"><i class="fas fa-plus"></i> Add New</a>
                <?php endif; ?>
            </h1>
            <?php
            if(isset($_SESSION['success_message'])) {
                echo '<div class="alert alert-success" role="alert">'.$_SESSION['success_message'].'</div>';
                unset($_SESSION['success_message']);
            }
            ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $i=0;
                        $statement = $pdo->prepare("SELECT * FROM features ORDER BY id ASC");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td>
                                    <?php if($arr[3] == 1): ?>
                                    <a href="feature-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <?php endif; ?>

                                    <?php if($arr[4] == 1): ?>
                                    <a href="feature-delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?')">Delete</a>
                                    <?php endif; ?>
                                </td>
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