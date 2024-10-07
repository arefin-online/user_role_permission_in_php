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
if(isset($_POST['form_submit'])) {
    try {
        if($_POST['name'] == '') {
            throw new Exception("Name can not be empty");
        }

        $statement = $pdo->prepare("INSERT INTO roles (name) VALUES (?)");
        $statement->execute([$_POST['name']]);
        $last_id = $pdo->lastInsertId();

        $statement = $pdo->prepare("SELECT * FROM role_tasks ORDER BY id ASC");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC); 
        foreach ($result as $row) {
            $statement = $pdo->prepare("INSERT INTO role_permissions (role_id,role_task_id,access) VALUES (?,?,?)");
            $statement->execute([$last_id,$row['id'],0]);
        }

        $success_message = "Role is added successfully.";
        $_SESSION['success_message'] = $success_message;
        header('location: role-view.php');
        exit;
    } catch(Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: role-add.php');
        exit;
    }
}
?>

<div class="right-part container-fluid">
    <div class="row">
        
        <?php include('sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4 pb-3">

            <h1 class="page-heading">
                Add Role
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
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary" name="form_submit">Submit</button>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>

<?php include('footer.php'); ?>