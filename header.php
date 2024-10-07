<?php
ob_start();
session_start();
include('config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <link rel="icon" type="image/png" href="uploads/favicon.png">

    <link rel="stylesheet" href="dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/select2.min.css">
    <link rel="stylesheet" href="dist/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="dist/css/sweetalert2.min.css">
    <link rel="stylesheet" href="dist/css/spacing.css">
    <link rel="stylesheet" href="dist/css/custom.css">

    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">

</head>

<?php
$cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
?>

<body class="<?php if($cur_page == 'login.php') {echo 'body-login'; } ?>">