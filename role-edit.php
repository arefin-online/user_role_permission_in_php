<?php include('header.php'); ?>

<?php include('top.php'); ?>

<?php
if(!isset($_SESSION['user'])) {
    header('location: login.php');
    exit;
}
?>

<?php
if($arr[5] == 0) {
    header('location: index.php');
    exit;
}
?>

<?php
// If this id is super admin's id, then you can not edit the item
if($_REQUEST['id'] == 1) {
    header('location: role-view.php');
    exit;
} else {
    $statement = $pdo->prepare("SELECT * FROM roles WHERE id=?");
    $statement->execute([$_GET['id']]);
    $total = $statement->rowCount();
    if(!$total) {
        header('location: role-view.php');
        exit;
    }
}
?>


<?php
if(isset($_POST['form_update'])) {
    try {
        if($_POST['name'] == '') {
            throw new Exception("Name can not be empty");
        }

        $statement = $pdo->prepare("UPDATE roles SET name=? WHERE id=?");
        $statement->execute([$_POST['name'],$_REQUEST['id']]);

        $success_message = "Role is updated successfully.";
        $_SESSION['success_message'] = $success_message;
        header('location: role-view.php');
        exit;
    } catch(Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: role-edit.php?id='.$_REQUEST['id']);
        exit;
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM roles WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $name = $row['name'];
}
?>

<div class="right-part container-fluid">
    <div class="row">
        
        <?php include('sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4 pb-3">

            <h1 class="page-heading">
                Edit Role
                <a href="role-view.php" class="btn btn-primary btn-sm right"><i class="fas fa-eye"></i> Show All</a>
            </h1>
            <?php
            if(isset($_SESSION['error_message'])) {
                echo '<div class="alert alert-danger" role="alert">'.$_SESSION['error_message'].'</div>';
                unset($_SESSION['error_message']);
            }
            if(isset($_SESSION['success_message'])) {
                echo '<div class="alert alert-success" role="alert">'.$_SESSION['success_message'].'</div>';
                unset($_SESSION['success_message']);
            }
            ?>
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                    </div>
                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary" name="form_update">Update</button>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>

<?php include('footer.php'); ?>