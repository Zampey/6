<?php
/* funkce pro login uživatele */
function login($pripojeni, $uzivatele)
{
    if (isset($_GET['prihlasit'])) {
        $email = $_GET['email'];
        $heslo = $_GET['heslo'];

        /** Vyhledáme záznamy */
        $sql = "SELECT * FROM $uzivatele WHERE email = ?";
        $dotaz = $pripojeni->prepare($sql);
        $dotaz->execute([$email]);
        $data = $dotaz->fetchAll();

        /* ověření uživatele podle hesla a emailu */
        foreach ($data as $zaznam) {
            if ($zaznam['email'] == $email and password_verify($heslo, $zaznam['heslo'])) {
                $_SESSION['login'] = true;
                $_SESSION['logged_name'] = $zaznam['jmeno'];
                $_SESSION['logged_surname'] = $zaznam['prijmeni'];
                $_SESSION['logged_email'] = $zaznam['email'];

                header('Refresh: 0 ./index.php');
                die();
            }
        }
    }
    /* odhlášení přesměrování*/
    if (isset($_GET['odhlasit'])) {
        $_SESSION['login'] = false;
        header('Refresh: 0 ./index.php');
        die();
    }
    /* nastavení přesměrování */
    if (isset($_GET['nastaveni'])) {
        header('Refresh: 0 ./nastaveni.php');
        die();
    }
}

/* vyhledá všechny produkty které jsou skladem */
function pocetProduktuSkladem($pripojeni, $produkty)
{
    /** Vyhledáme záznamy a zjistíme jejich počet */
    $sql = "SELECT * FROM $produkty WHERE skladem LIKE ?";
    $dotaz = $pripojeni->prepare($sql);
    $dotaz->execute(["true"]);
    $data = $dotaz->fetchAll();
    $pocet = sizeof($data);
    echo $pocet;
}

/* měří a upravuje DENNÍ návštěvnost webu */
function mereniNavstevnosti()
{
    $soubor1 = './db/navstevnost.txt';
    $obsah1 = file_get_contents($soubor1);

    $soubor2 = './db/navstevy_celkem.txt';
    $obsah2 = file_get_contents($soubor2);
    if (!isset($_SESSION['navsteva'])) {
        $_SESSION['navsteva'] = 'ano';
        $obsah1++;
        file_put_contents($soubor1, $obsah1);
        $obsah2++;
        file_put_contents($soubor2, $obsah2);
    }
    echo $obsah1;
}

/* kontroluje celkovou návštěvnost webu */
function celkoveNavstevy()
{
    $file = './db/navstevy_celkem.txt';
    $celkova_navstevnost = file_get_contents($file);
    echo $celkova_navstevnost;
}

/* funkce pro získání aktuálního data a času*/
function currentDateTime()
{
    date_default_timezone_set('Europe/Prague');
    $date = date('d-m-y h:i:s');
    echo $date;
}
