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
Autoloader::__autoload(array("DbConnect", "adminInfo", "searchClass"));
$db = Database::connect();
$adminInfo = new adminInfo($db);
$adminInfo->setInfo();
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
        <div class="col-lg-6">

            <?php foreach ($adminInfo->getInfos() as $value) {
                echo '<h1><strong>' . ucfirst($value['prenom']) . '  ' . ucfirst($value['nom']) . '</strong></h1><br>';
            } ?>

            <form class="form" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="category">Subscription type: </label>
                    <select class="form-control" id="category" name="AboType">
                        <option value="" selected disabled>Choisir la catégorie</option>
                        <?php
                        foreach ($adminInfo->getAboType() as $value) {
                            if ($value['nom'] === $adminInfo->getInfos()[0]["AboType"])
                                echo ' <option selected="selected">'. $adminInfo->getInfos()[0]["AboType"] .'</option>';
                            else
                                echo '<option value="' . $value['id_abo'] . '">' . $value['nom'] . '</option>';
                        }
                        ?>
                    </select>
                    <span class="text-warning"><?= $adminInfo->AboTypeError ?></span>
                </div>


                <div class="form-group">
                    <label for="subDate">Subscription date: </label>
                    <input type="date" step="0.01" class="form-control" id="subDate" name="subDate" placeholder="subDate"
                           value="<?= implode("-", array_reverse(explode("/", $adminInfo->getInfos()[0]["date_abo"]))) ?>">
                    <span class="text-warning"><?= $adminInfo->subDateError ?></span>
                </div>

                <div class="form-group">
                    <label for="registerDate">Registration date: </label>
                    <input type="date" step="0.01" class="form-control" id="registerDate" name="registerDate" placeholder="registerDate"
                           value="<?= implode("-", array_reverse(explode("/", $adminInfo->getInfos()[0]["date_inscription"]))) ?>">
                    <span class="text-warning"><?= $adminInfo->registerDateError ?></span>
                </div>


                <div class="form-actions user__warning--btn">
                    <a class="btn btn-info" href='<?= 'http://' . $_SERVER["HTTP_HOST"] . '/myCinema/admin/history.php?id=' . $_GET["id"] ?>'><i class="fas fa-address-book"></i>  View History</a>
                </div>

                <div class="form-actions user__warning--btn">
                    <a class="btn btn-warning" href="index.php"><i class="fas fa-backward"></i> Retour</a>
                    <button type="submit" href="index.php" class="btn btn-outline-light ml-4"><i class="fas fa-pen"></i> Modifier</button>
                </div>
        </div>

        <div class="col-lg-6 site">

            <div class="card card__user">
                <img class="card-img-top" src="../public/assets/images/no-user.png" alt="Card image cap">
                <div class="card-body">
                    <?php
                    foreach ($adminInfo->getInfos() as $value) {
                        echo '<input type="text" class="form-control name--inp" id="name" name="firstName" placeholder="firstName"
                                     value="' . ucfirst($value['prenom']) . '">
                               <span class="text-warning">' . $adminInfo->firstNameError . '</span>
                               <input type="text" class="form-control name--inp" id="name" name="lastname" placeholder="lastname"
                                     value="' . ucfirst($value['nom']) . '">
                               <span class="text-warning">' . $adminInfo->lastNameError . '</span>
                               ';
                    }
                    ?><?php Database::disconnect(); ?>
                </div>
            </div>

            </form>
        </div>

    </div>
</div>
</body>
</html>