<?php
/* CLASS CONTENT ADMIN  ==> fetch nom/prenom/info membre ... */
class adminInfo
{
    public $db;
    public $ClassFetch;
    public $arrayMemberInfo = [];
    public $arrayAboType = [];
    public $dateFormat;
    public $firstNameError;
    public $lastNameError;
    public $AboTypeError;
    public $subDateError;
    public $registerDateError;

    function __construct($db)
    {
        $this->db = $db;
        $this->dateFormat = "'%d/%m/%Y'";
        include_once 'fetchClass.php';
        $this->ClassFetch = new fetch($db);
    }

    public function affiche()
    {
        $SQL = "SELECT *, DATE_FORMAT(date_inscription, $this->dateFormat) AS date_register FROM fiche_personne 
                INNER JOIN membre ON fiche_personne.id_perso = membre.id_membre ORDER BY date_inscription DESC";
        $this->ClassFetch->query($SQL, $this->arrayMemberInfo);
        return $this->arrayMemberInfo;

    }

    public function getHistorique()
    {
        if (!empty($_GET['id'])) {
            $id = $this->checkInput($_GET['id']);
            $prepare = $this->db->prepare("SELECT titre , date, id_perso, DATE_FORMAT(date, $this->dateFormat) AS date FROM film 
                                    INNER JOIN historique_membre ON historique_membre.id_film = film.id_film 
                                    INNER JOIN membre ON membre.id_membre = historique_membre.id_membre 
                                    INNER JOIN fiche_personne ON fiche_personne.id_perso = membre.id_fiche_perso 
                                    WHERE fiche_personne.id_perso = ?");

            $prepare->execute(array($id));
            return $prepare->fetchAll();
        } else {
            header("Location: " . 'http://' . $_SERVER["HTTP_HOST"] . '/myCinema/admin');
            return $id = NULL;
        }
    }

    public function checkInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function getInfos()
    {
        if (!empty($_GET['id'])) {
            $id = $this->checkInput($_GET['id']);
            $prepare = $this->db->prepare("SELECT prenom, fiche_personne.nom, email, abonnement.nom AS AboType, 
                                           DATE_FORMAT(date_abo, $this->dateFormat) AS date_abo,   
                                           DATE_FORMAT(date_inscription, $this->dateFormat) AS date_inscription 
                                           FROM fiche_personne 
                                           INNER JOIN membre ON fiche_personne.id_perso = membre.id_fiche_perso 
                                           INNER JOIN abonnement ON abonnement.id_abo = membre.id_abo WHERE fiche_personne.id_perso = ?");

            $prepare->execute(array($id));
            return $prepare->fetchAll();
        } else {
            header("Location: " . 'http://' . $_SERVER["HTTP_HOST"] . '/myCinema/admin');
            return $id = NULL;
        }
    }

    public function setInfo()
    {
        $id = $this->checkInput($_GET['id']);
        if (!empty($_POST)) {
            $ok = true;
            $this->checkInput($_POST["firstName"]);
            $this->checkInput($_POST["lastname"]);
            $this->checkInput($_POST["AboType"]);


            if (empty($_POST['firstName'])) {
                return $this->firstNameError = "Ce champ ne peut pas être vide";
            }

            if (empty($_POST['lastname'])) {
                return $this->lastNameError = "Ce champ ne peut pas être vide";
            }
            if (empty($_POST['AboType'])) {
                return $this->AboTypeError = "Ce champ ne peut pas être vide";
            }
            if (empty($_POST['subDate'])) {
                return $this->subDateError = "Ce champ ne peut pas être vide";
            }

            if (empty($_POST['registerDate'])) {
                return $this->registerDateError = "Ce champ ne peut pas être vide";
            }

            if ($ok === true) {
                $prepare = $this->db->prepare("UPDATE fiche_personne INNER JOIN membre ON fiche_personne.id_perso = membre.id_membre 
                                               INNER JOIN abonnement ON abonnement.id_abo = membre.id_abo
                                               set fiche_personne.prenom = ?, fiche_personne.nom = ? WHERE fiche_personne.id_perso = ?");
                $prepare->execute(array($_POST['firstName'], $_POST['lastname'], $id));
                $prepare = $this->db->prepare("UPDATE membre SET id_abo = ?, date_abo = ?, date_inscription = ? WHERE id_fiche_perso = $id");
                $prepare->execute(array($_POST['AboType'], $_POST['subDate'], $_POST['registerDate']));
                header("Location: " . 'http://' . $_SERVER["HTTP_HOST"] . '/myCinema/admin');
            }
        }


    }

    public function getAboType()
    {
        $SQL = "SELECT * FROM abonnement";
        $this->ClassFetch->query($SQL, $this->arrayAboType);
        return $this->arrayAboType;
    }

}