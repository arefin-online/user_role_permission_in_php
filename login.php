<?php include('header.php'); ?>

<?php
if(isset($_SESSION['user'])) {
    header('location: index.php');
    exit;
}
?>

<?php
if(isset($_POST['form_login'])) {
    try {
        if($_POST['email'] == '') {
            throw new Exception("Email can not be empty");
        }
        if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email is invalid");
        }
        if($_POST['password'] == '') {
            throw new Exception("Password can not be empty");
        }
        $q = $pdo->prepare("SELECT * FROM users WHERE email=?");
        $q->execute([$_POST['email']]);
        $total = $q->rowCount();
        if(!$total) {
            throw new Exception("Email is not found");
        } else {
            $result = $q->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $password = $row['password'];
                if(!password_verify($_POST['password'], $password)) {
                    throw new Exception("Password does not match");
                }
            }
        }
        $_SESSION['user'] = $row;
        header('location: index.php');
    } catch(Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: login.php');
        exit;
    }
}
?>

<div class="container-login">
    <main class="form-signin w-100 m-auto">
        <h1 class="text-center">Login</h1>
        <?php
        if(isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger" role="alert">'.$_SESSION['error_message'].'</div>';
            unset($_SESSION['error_message']);
        }
        ?>
        <form action="" method="post">
            <div class="form-floating">
                <input type="text" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" autocomplete="off">
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" autocomplete="off">
                <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit" name="form_login">Login</button>
        </form>
    </main>
</div>

<?php include('footer.php'); ?>