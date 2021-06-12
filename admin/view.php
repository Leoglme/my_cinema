<!DOCTYPE>
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

<div class="container admin card__info">

    <div class="row">
        <div class="col-md-6">
            <?php foreach ($adminInfo->getInfos() as $value) {
                echo '<h1><strong>' . ucfirst($value['prenom']) . '  ' . ucfirst($value['nom']) . '</strong></h1><br>';
            } ?>


            <form>
                <?php foreach ($adminInfo->getInfos() as $value) {
                    echo '<div class="form-group"><label class="mr-2">Subscription type:</label>' . ucfirst($value["AboType"]) . '</div>
                      <div class="form-group"><label class="mr-2">Subscription date: </label>' . $value["date_abo"] . '</div>
                      <div class="form-group"><label class="mr-2">Registration date: </label>' . $value["date_inscription"] . '</div>
                      <div class="form-group"><label class="mr-2">Email: </label>' . $value["email"] . '</div>';
                } ?>

            </form>
            <div class="form-actions user__warning--btn">
                <a class="btn btn-info" href='<?= 'http://' . $_SERVER["HTTP_HOST"] . '/myCinema/admin/history.php?id=' . $_GET["id"] ?>'><i class="fas fa-address-book"></i>  View History</a>
            </div>
            <div class="form-actions user__warning--btn">
                <a class="btn btn-warning" href='<?= 'http://' . $_SERVER["HTTP_HOST"] . '/myCinema/admin' ?>'><i class="fas fa-backward"></i> Retour</a>
            </div>


        </div>
        <div class="col-md-6 img__thumbnail">
            <div class="card card__user">
                <img class="card-img-top" src="../public/assets/images/no-user.png" alt="Card image cap">
                <div class="card-body">
                    <?php
                    foreach ($adminInfo->getInfos() as $value) {
                        echo '<h5 class="card-title">' . ucfirst($value['prenom']) . '</h5>
                              <h5 class="card-title">' . ucfirst($value['nom']) . '</h5>';
                    }
                    ?> <?php Database::disconnect(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>