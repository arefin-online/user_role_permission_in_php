<?php include('header.php'); ?>

<?php include('top.php'); ?>

<?php
if(!isset($_SESSION['user'])) {
    header('location: login.php');
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
        
        // echo '<pre>';
        // print_r($_POST['arr_role_task_id']);
        // echo '</pre>';

        // echo '<pre>';
        // print_r($_POST['arr_access']);
        // echo '</pre>';

        $arr1 = [];
        foreach($_POST['arr_role_task_id'] as $value) {
            $arr1[] = $value;
        }

        $arr2 = [];
        foreach($_POST['arr_access'] as $value) {
            $arr2[] = $value;
        }

        for($i=0;$i<count($arr1);$i++) {
            $statement = $pdo->prepare("UPDATE role_permissions SET access=? WHERE role_id=? AND role_task_id=?");
            $statement->execute([$arr2[$i],$_REQUEST['id'],$arr1[$i]]);
        }

        $success_message = "Role Access is updated successfully.";
        $_SESSION['success_message'] = $success_message;
        header('location: role-view.php');
        exit;
    } catch(Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: role-access.php?id='.$_REQUEST['id']);
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
                Access Setup for Role: <?php echo $name; ?>
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

                    <?php
                    $i=0;
                    $statement = $pdo->prepare("SELECT 
                                                t1.*,
                                                t2.id as task_id,
                                                t2.name as task_name
                                                FROM role_permissions t1
                                                JOIN role_tasks t2
                                                ON t1.role_task_id=t2.id
                                                WHERE t1.role_id=?");
                    $statement->execute([$_REQUEST['id']]);
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $i++;
                        ?>
                        <input type="hidden" name="arr_role_task_id[<?php echo $i; ?>]" value="<?php echo $row['role_task_id']; ?>">
                        <input type="hidden" name="arr_access[<?php echo $i; ?>]" value="0">
                        <div class="form-check">
                            <input name="arr_access[<?php echo $i; ?>]" class="form-check-input" type="checkbox" value="1" id="flexCheckDefault<?php echo $i; ?>" <?php if($row['access'] == 1) {echo 'checked';} ?>>
                            <label class="form-check-label" for="flexCheckDefault<?php echo $i; ?>">
                                <?php echo $row['task_name']; ?>
                            </label>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary" name="form_update">Update</button>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>

<?php include('footer.php'); ?>