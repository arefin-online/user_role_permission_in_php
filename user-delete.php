<?php include('header.php'); ?>

<?php
if(!isset($_SESSION['user'])) {
    header('location: login.php');
    exit;
}
?>

<?php
if($arr[6] == 0) {
    header('location: index.php');
    exit;
}
?>

<?php
// If this id is super admin's id, then you can not delete the item
if($_REQUEST['id'] == 1) {
    header('location: user-view.php');
    exit;
} else {
    $statement = $pdo->prepare("SELECT * FROM users WHERE id=?");
    $statement->execute([$_GET['id']]);
    $total = $statement->rowCount();
    if(!$total) {
        header('location: user-view.php');
        exit;
    }
}
?>

<?php
$statement = $pdo->prepare("DELETE FROM users WHERE id=?");
$statement->execute([$_REQUEST['id']]);

$success_message = "User is deleted successfully.";
$_SESSION['success_message'] = $success_message;
header('location: user-view.php');
exit;
?>