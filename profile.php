<?php include('header.php'); ?>

<?php include('top.php'); ?>

<?php
if(!isset($_SESSION['user'])) {
    header('location: login.php');
    exit;
}
?>

<?php
if(isset($_POST['form_profile'])) {
    try {
        if($_POST['name'] == '') {
            throw new Exception("Name can not be empty");
        }
        if($_POST['email'] == '') {
            throw new Exception("Email can not be empty");
        }
        if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email is invalid");
        }
        $statement = $pdo->prepare("SELECT * FROM users WHERE email=? AND id!=?");
        $statement->execute([$_POST['email'],$_SESSION['user']['id']]);
        $total = $statement->rowCount();
        if($total) {
            throw new Exception("Email already exists");
        }

        if($_POST['password'] == '' && $_POST['confirm_password'] == '') {
            $hash_password = $_SESSION['user']['password'];
        } else {
            if($_POST['password'] != $_POST['confirm_password']) {
                throw new Exception("Password does not match");
            }
            $hash_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        $statement = $pdo->prepare("UPDATE users SET name=?,email=?,password=? WHERE id=?");
        $statement->execute([$_POST['name'],$_POST['email'],$hash_password,$_SESSION['user']['id']]);
        
        $success_message = "Profile has been updated successfully";

        $_SESSION['user']['name'] = $_POST['name'];
        $_SESSION['user']['email'] = $_POST['email'];

        $_SESSION['success_message'] = $success_message;
        header('location: profile.php');
        exit;
    } catch(Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: profile.php');
        exit;
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM roles WHERE id=?");
$statement->execute([$_SESSION['user']['role_id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $role_name = $row['name'];
}
?>

<div class="right-part container-fluid">
    <div class="row">

        <?php include('sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4 pb-3">

            <h1 class="page-heading">Edit Profile</h1>
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
                        <input type="text" class="form-control" name="name" value="<?php echo $_SESSION['user']['name']; ?>">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" value="<?php echo $_SESSION['user']['email']; ?>">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Role</label>
                        <input type="text" class="form-control" name="" value="<?php echo $role_name; ?>" disabled>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password">
                    </div>
                    <div class="col-md-12 mb-3">
                        <input type="submit" value="Update" name="form_profile" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>

<?php include('footer.php'); ?>