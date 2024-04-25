<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $page_description ?>">
    <title><?= $page_title ?></title>
    <link rel="stylesheet" href="<?= URL ?>public/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?= URL ?>public/CSS/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

</head>

<body class="d-flex flex-column vh-100">
    <?php require("views/header.php") ?>

    <?php
    if (!empty($_SESSION['alert'])) {
        echo "<div id = 'alert-container'class='container'>";
        foreach ($_SESSION['alert'] as $alert) {
            echo "<div id = 'cross' class='alert alert-fixed d-flex justify-content-between align-items-center " . $alert['type'] . "' role='alert'>
                " . $alert['message'] . "<i id = 'crossicon'class='fas fa-times'></i>" . "
              </div>";
        }
        echo "</div>";
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

<style>
    .alert-fixed {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
        width: 90%;
        max-width: 400px;
        padding: 20px;
        border: 1px solid;
        border-radius: 5px;
        opacity: 1;
        transition: opacity 0.3s ease, top 0.3s ease;
    }

    #crossicon {
        font-size: 24px;
        cursor: pointer;
    }
</style>

<script>
    let cross = document.querySelector("#cross");

    if (cross) {
        cross.addEventListener("click", function() {
            document.querySelector("#alert-container").style.display = "none";
        })
    }
</script>

</html>