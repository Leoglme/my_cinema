<!DOCTYPE html>
<html lang="en">
<head>
    <title>MyCinéma Administrator view</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/054fdad312.js" crossorigin="anonymous"></script>
    <link type="text/css" rel="stylesheet" href="../public/style.css">
    <link href="https://fonts.googleapis.com/css?family=Holtwood+One+SC&display=swap" rel="stylesheet">
</head>


<body class="admin__body">

<?php
require '../private/autoloader.php';
Autoloader::__autoload(array("DbConnect", "adminInfo"));
$db = Database::connect();
$adminInfo = new adminInfo($db);
?>

<header class="site-header">
    <div class="container">
        <a href='<?= 'http://' . $_SERVER["HTTP_HOST"] . '/myCinema/admin' ?>' id="branding" class="admin__logo">
            <img src="../public/assets/images/logo.png" alt="" class="logo">
            <div class="logo-copy">
                <h1 class="site-title">My Cinema</h1>
                <small class="site-description">PROJET</small>
            </div>
        </a>

        <div class="mobile-navigation"></div>
    </div>
</header>

<div class="container admin">
    <div class="row">
        <div class="table__header">
            <h1><strong>History Members </strong></h1>
            <a href="http://"<?= $_SERVER["HTTP_HOST"] ?>"/myCinema/admin"  class="btn btn-warning btn-lg"><i class="fas fa-user-plus"></i> Add user</a>
        </div>


        <table class="table table-stripped table-bordered">
            <thead>
            <tr>
                <th>List of movies watched</th>
                <th>Viewing date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach ($adminInfo->getHistorique() as $item) {
                    echo '<tr>';
                    echo '<td>' . $item['titre'] . '</td>';
                    echo '<td>' . $item['date'] . '</td>';

                    echo '<td class="container__admin--btn">';
                    echo '<a href="http://' . $_SERVER["HTTP_HOST"] . '/myCinema/admin" class="admin__btn btn btn-outline-light"><i class="fas fa-eye"></i> See more</a>';
                    echo '<a href="http://' . $_SERVER["HTTP_HOST"] . '/myCinema/admin"  class="admin__btn btn btn-primary"><i class="fas fa-pen"></i> Edit</a>';
                    echo '<a href="http://' . $_SERVER["HTTP_HOST"] . '/myCinema/admin"  class="admin__btn btn btn-danger"><i class="fas fa-trash-alt"></i> Remove</a>';
                    echo '</td>';

                    echo '</tr>';
                }
                ?>

            <?php Database::disconnect(); ?>

            </tbody>
        </table>
    </div>

</div>


</body>
</html>



