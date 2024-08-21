<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start or resume session
}

// Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header("Location: /iods/login");
//     exit();
// }


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title><?php echo $title ?? "No Title" ?></title>
    <link rel="icon" href="public/img/favicon/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="public/img/favicon/favicon.ico" type="image/x-icon" />
    <!-- CSS -->
    <link href="public/dist/css/tabler.min.css?1668287865" rel="stylesheet" />
    <link href="public/dist/css/tabler-flags.min.css?1668287865" rel="stylesheet" />
    <link href="public/dist/css/tabler-payments.min.css?1668287865" rel="stylesheet" />
    <link href="public/dist/css/tabler-vendors.min.css?1668287865" rel="stylesheet" />
    <link href="public/dist/css/demo.min.css?1668287865" rel="stylesheet" />
    <link href="public/dist/libs/animate/animate.css?1668287865" rel="stylesheet" />
    <link href="public/dist/libs/litepicker/dist/css/plugins/multiselect.js.css?1668287865" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    <style>
        .sortable:hover {
            cursor: pointer;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <script src="public/dist/js/demo-theme.min.js?1668287865"></script>
    <div class="page">
        <!-- Navbar -->
        <div class="sticky-top">
            <?php
            if (isset($_SESSION['admin_id'])) {
                // Include admin-specific navbar and sidebar
                include('admin_navbar.php');
                include('admin_sidebar.php');
            } elseif (isset($_SESSION['user_id'])) {
                // Include user-specific navbar and sidebar
                include('navbar.php');
                include('sidebar.php');
            } else {
                // Optionally, redirect to login if neither session is set
                header('Location: /iods/login');
                exit;
            }
            ?>
        </div>

        <div class="page-wrapper">
            <!-- Page header -->
            <?php echo $pageheader ?? "" ?>
            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">