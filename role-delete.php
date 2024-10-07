<?php include('header.php'); ?>

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
// If this id is super admin's id, then you can not delete the item
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
$statement = $pdo->prepare("DELETE FROM roles WHERE id=?");
$statement->execute([$_REQUEST['id']]);

$statement = $pdo->prepare("DELETE FROM role_permissions WHERE role_id=?");
$statement->execute([$_REQUEST['id']]);

$success_message = "Role is deleted successfully.";
$_SESSION['success_message'] = $success_message;
header('location: role-view.php');
exit;
?>