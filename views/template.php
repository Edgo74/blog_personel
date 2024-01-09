<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $page_description ?>">
    <title><?= $page_title ?></title>
    <link rel="stylesheet" href="<?= URL ?>public/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?= URL ?>public/CSS/main.css">
    <!-- ///A reparer le meme css 2 fois main.css -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

</head>

<body class="d-flex flex-column vh-100">
    <?php require("views/header.php") ?>

    <?php
    if (!empty($_SESSION['alert'])) {
        foreach ($_SESSION['alert'] as $alert) {
            echo "<div class='alert " .  $alert['type'] . "' role='alert'>
                        " . $alert['message'] . "
                    </div>";
        }
        unset($_SESSION['alert']);
    }
    ?>

    <?= $page_content ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <?php if (!empty($page_javascript)) : ?>
        <script src="<?= URL ?>public/bootstrap/js/bootstrap.js"></script>
        <script src="<?= URL ?>public/JavaScript/<?= $page_javascript ?>"></script>
    <?php endif; ?>
</body>

</html>