<?php
session_save_path('./save_session');
include('./funkce.php');
include('./pripojeni_db.php');
ob_start();
session_start();
if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = false;
}
if (!$_SESSION['login']) {
    $_SESSION['logged_name'] = "";
    $_SESSION['logged_surname'] = "";
    $_SESSION['logged_email'] = "";
}
if (!isset($_COOKIE['barva_pozadi'])) {
    $barva_pozadi = file_get_contents("./db/default.txt");
} else {
    $barva_pozadi = $_COOKIE['barva_pozadi'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <!--import potřebných scriptů  -->
    <!--import css stylů  -->
    <title>NEOPLEX</title>
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/9eabf2a53b.js" crossorigin="anonymous"></script>
    <!-- css styly -->
    <link rel="stylesheet" href="./css/header_fnc.css">
    <link rel="stylesheet" href="./css/main_page.css">
    <link rel="stylesheet" href="./css/zbozi.css">
    <link rel="stylesheet" href="./css/tail.css">
    <link rel="stylesheet" href="./css/produkt.css">
    <link rel="stylesheet" href="./css/kosik.css">
    <link rel="stylesheet" href="./css/fotogalerie.css">
    <link rel="stylesheet" href="./css/lightbox.css">
    <link rel="stylesheet" href="./css/404.css">
    <link rel="stylesheet" href="./css/nastaveni.css">
</head>
<?php
echo '<body style="background-color:' . $barva_pozadi . '">';
?>
<!-- hlavička -->
<div class="header_package">
    <!-- Horní nabídka 1. úroveň -->
    <div class="top_line">
        <div class="obal_phone_mail">
            <div class="phone">
                <i class="fa-solid fa-phone phone_icon"></i>
                <p>+420 784 457 622</p>
            </div>
            <div class="mail">
                <i class="fa-regular fa-envelope mail_icon"></i>
                <span>info@neoplex.cz</span>
            </div>
        </div>
        <div class="dop_rek">
            <a class="reklamace" href=""><span>Reklamace</span></a>
            <a class="doprava" href=""><span>Doprava a platba </span></a>
        </div>
    </div>

    <!-- Horní nabídka 2. úroveň -->
    <div class="top_header">
        <a class="header_logo_link" href="./index.php"><img class="header_logo" src="https://see.fontimg.com/api/renderfont4/EaXpg/eyJyIjoiZnMiLCJoIjo5MSwidyI6MTAwMCwiZnMiOjkxLCJmZ2MiOiIjRjBFQUVBIiwiYmdjIjoiIzVCM0IzQiIsInQiOjF9/TkVPUExFWA/a-absolute-empire.png"></a>
        <div class="links">
            <!-- sekce pro zobrazení uživatele -->
            <div class="account">
                <a href="./kosik.php"><i class="fa-solid fa-basket-shopping top_header_icon fa-lg basket-out"></i></a>
                <label for="user_checkbox"><i class="fa-solid fa-user user top_header_icon fa-lg" for="user_checkbox"></i></label>
                <input type="checkbox" id="user_checkbox" class="hidden_checkbox" />
                <div class="dropdown-content">
                    <?php
                    /* kontrola přihlášeného uživatele */
                    if ($_SESSION['login'] == true) {
                        echo '<p class="logged_credentials">' . $_SESSION['logged_name'] . ' ' . $_SESSION['logged_surname'] . '</p>';
                        echo '<form class="login_form" method="get">';
                        echo '<input type="submit" name="nastaveni" value="Nastavení"><br>';

                        echo '<input type="submit" name="odhlasit" value="Odhlásit"></form>';
                    } else {
                        /* pokud není přihlášen zobrazí se
                        přihlašovací formulář */
                        echo '<form class="login_form" method="get">
                            <input type="text" name="email" placeholder="Email"><br>
                            <input type="password" name="heslo" placeholder="Heslo"><br>
                            <input type="submit" name="prihlasit" value="Přihlásit">
                        </form><a class="registr_link" href="./registrace.php">Registrace</a>';
                    }
                    login($pripojeni, $uzivatele);
                    ?>
                </div>
            </div>
            <!-- horní nabídka pro možnost navigace  -->
            <div class="nav">
                <label class="menu_label" for="toggle">&#9776;</label>
                <input type="checkbox" id="toggle" class="hidden_checkbox" />
                <div class="menu">
                    <a class="top_header_link" href="./zbozi.php?type=pocitace">Počítače</a>
                    <a class="top_header_link" href="./zbozi.php?type=notebooky">Notebooky</a>
                    <a class="top_header_link" href="./zbozi.php?type=telefony">Telefony</a>
                    <a class="top_header_link" href="./zbozi.php?type=prislusenstvi">Příslušenství</a>
                    <a class="top_header_link basket-in-a" href="./kosik.php">.<i class="fa-solid fa-basket-shopping top_header_icon fa-lg basket-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="vlastni_obsah">