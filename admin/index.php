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
Autoloader::__autoload(array("DbConnect", "adminInfo", "searchClass"));
$db = Database::connect();
$adminInfo = new adminInfo($db);
$search = new searchResult($db, "adminSearch", "fiche_personne", array("nom", "prenom"), "id_perso");
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

        <div class="main-navigation">

            <nav>
                <form class="form-inline" method="post">
                    <input class="mr-sm-2" name="adminSearch" type="search" placeholder="Search member" aria-label="Search">
                    <button class="my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
                </form>
            </nav>

        </div>

        <div class="mobile-navigation"></div>
    </div>
</header>

<div class="container admin">
    <div class="row">
        <div class="table__header">
            <h1><strong>Members list </strong></h1>
            <a href="" class="btn btn-warning btn-lg"><i class="fas fa-user-plus"></i> Add user</a>
        </div>


        <table class="table table-stripped table-bordered">
            <thead>
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>Mail</th>
                <th>Registration</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($_POST['adminSearch'] === false): ?>
                <?php
                foreach ($adminInfo->affiche() as $item) {
                    echo '<tr>';
                    echo '<td>' . $item['prenom'] . '</td>';
                    echo '<td>' . $item['nom'] . '</td>';
                    echo '<td>' . $item['email'] . '</td>';
                    echo '<td>' . $item['date_register'] . '</td>';

                    echo '<td class="container__admin--btn">';
                    echo '<a href="view.php?id=' . $item['id_perso'] . '" class="admin__btn btn btn-outline-light"><i class="fas fa-eye"></i> See more</a>';
                    echo '<a href="update.php?id=' . $item['id_perso'] . '" class="admin__btn btn btn-primary"><i class="fas fa-pen"></i> Edit</a>';
                    echo '<a href="delete.php?id=' . $item['id_perso'] . '" class="admin__btn btn btn-danger"><i class="fas fa-trash-alt"></i> Remove</a>';
                    echo '</td>';

                    echo '</tr>';
                }
                ?>
            <?php endif; ?>


            <?php if ($_POST['adminSearch'] !== false): ?>
                <?php
                foreach ($search->affiche() as $item) {
                    echo '<tr>';
                    echo '<td>' . $item['prenom'] . '</td>';
                    echo '<td>' . $item['nom'] . '</td>';
                    echo '<td>' . $item['email'] . '</td>';
                    echo '<td>' . $item['nom'] . '</td>';

                    echo '<td class="container__admin--btn">';
                    echo '<a href="view.php?id=' . $item['id_perso'] . '" class="admin__btn btn btn-outline-secondary"><i class="fas fa-eye"></i> See more</a>';
                    echo '<a href="update.php?id=' . $item['id_perso'] . '" class="admin__btn btn btn-primary"><i class="fas fa-pen"></i> Edit</a>';
                    echo '<a href=""><i class="fas fa-trash-alt"></i> Remove</a>';
                    echo '</td>';

                    echo '</tr>';
                }
                ?>
            <?php endif; ?>

            <?php Database::disconnect(); ?>

            </tbody>
        </table>
    </div>

</div>


</body>
</html>



