<?php include('header.php'); ?>

<?php
if(!isset($_SESSION['user'])) {
    header('location: login.php');
    exit;
}
?>

<?php
if($arr[4] == 0) {
    header('location: index.php');
    exit;
}
?>

<?php
$statement = $pdo->prepare("DELETE FROM features WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$success_message = "Feature is deleted successfully.";
$_SESSION['success_message'] = $success_message;
header('location: feature-view.php');
exit;
?>