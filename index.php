<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Фітнес Зал</title>
    <link rel="stylesheet" type="text/css" href="css/style.css?<? echo time(); ?>">
</head>

<body>
    <div class="wrapper">

        <?php include('layout/header.php'); ?>

        <main class="main">
            <?php
            $action = $_GET['action'] ?? 'home';

            if ($action === 'about') {
                include 'layout/views/about.php';
            } elseif ($action === 'registration') {
                include 'layout/views/registration.php';
            } elseif ($action === 'registration_successful') {
                include 'layout/views/registration_successful.php';
            } else {
                include 'layout/views/main.php';
            }
            ?>

            <?php


            ?>
        </main>

        <?php include('layout/right_menu.php'); ?>

        <?php include('layout/footer.php'); ?>
    </div>

    <script src="js/main.js" defer></script>

</body>

</html>