<?php
include './_hlavicka.php';
?>
<!-- registrační formulář -->
<div class="registr_obal">
    <form action="" method="post">
        <input class="registr_input" type="text" name="jmeno" placeholder="Jméno"><br>
        <input class="registr_input" type="text" name="prijmeni" placeholder="Příjmení"><br>
        <input class="registr_input" type="email" name="email" placeholder="E-mail"><br>
        <input class="registr_input" type="password" name="heslo1" placeholder="Heslo"><br>
        <input class="registr_input" type="password" name="heslo2" placeholder="Heslo znovu"><br>
        <input class="registr_btn" type="submit" name="registrovat" value="Registrovat">
    </form>
</div>

<?php
/* funkce pro registraci */
if (isset($_POST['registrovat'])) {
    $jmeno = htmlspecialchars(trim($_POST['jmeno']));
    $prijmeni = htmlspecialchars(trim($_POST['prijmeni']));
    $email = htmlspecialchars(trim($_POST['email']));
    $heslo1 = htmlspecialchars(trim($_POST['heslo1']));
    $heslo2 = htmlspecialchars(trim($_POST['heslo2']));
    /* ověření správnosti zadaných údajů */
    if ($jmeno == "" or $prijmeni == "" or $email == "" or $heslo1 == "" or $heslo2 == "") {
        echo '<div id="reg_error_div">
        <img src="./img/icon/error.png">
        <p id="field_for_text">Vyplňte všechny položky formuláře!</p>
    </div>';
    } else {
        if ($heslo1 != $heslo2) {
            echo '<div id="reg_error_div">
            <img src="./img/icon/error.png">
            <p>Hesla se musí shodovat</p>
        </div>';
        } else {
            /** Vyhledáme záznamy a zjistíme jejich počet */
            $sql = "SELECT * FROM $uzivatele WHERE email LIKE ?";
            $dotaz = $pripojeni->prepare($sql);
            $dotaz->execute(["$email%"]);
            $data = $dotaz->fetchAll();
            $pocet = sizeof($data);
            if ($pocet == 0) {
                /** Vložení záznamů po ověření do databáze */
                $sql = "INSERT INTO $uzivatele (jmeno, prijmeni, email, heslo) VALUES(?, ?, ?, ?)";
                $dotaz = $pripojeni->prepare($sql);
                $dotaz->execute([$jmeno, $prijmeni, $email, password_hash($heslo1, PASSWORD_DEFAULT)]);
                /* výpis pozitivní hlášky po registraci */
                echo '<div id="reg_success_div">
                    <img src="./img/icon/checked.png">
                    <p>Úspěšně jste se zaregistroval/a</p>
                </div>';
            } else {
                /* výpis negativní hlášky při pokusu o registraci */
                echo '<div id="reg_error_div">
                      <img src="./img/icon/error.png">
                      <p>Tento email je již používán!</p>
                      </div>';
            }
        }
    }
}
include('./_paticka.php');
?>
<script>
    /* změna titulku na registraci */
    document.title = "Registrace";
    $('meta[name="description"]').attr("content", "stránka pro registraci uživatelů");
</script>