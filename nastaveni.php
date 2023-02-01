<?php
/* import hlavičky a počáteční nastavení barvy pozadí webu */
include './_hlavicka.php';
if (isset($_POST['odeslat'])) {
    $barva_pozadi = $_POST['barva_pozadi'];
    if ($_SESSION['logged_email'] == "admin@admin.admin") {
        file_put_contents("./db/default.txt", $barva_pozadi);
    }
    /* nastavení cookie */
    setcookie("barva_pozadi", $barva_pozadi, time() + 3600, '/');

    $nazev_skriptu = $_SERVER['PHP_SELF'];
    header("location: $nazev_skriptu");
    die();
}

?>
<!-- sekce s nastavením -->
<h2 class="nastaveni_nadpis">Nastavení</h2>
<hr class="podtrzitko_nastaveni">
<div class="obal_nastaveni">
    <div class="vyber_barev">
        <form action="" method="POST">
            <p class="nadpis_barva">Barva pozadí:</p>
            <!-- select pro výběr barvy pozadí -->
            <select class="select_barvy" name=barva_pozadi>
                <option value="Red" <?php if ($barva_pozadi == "Red") {
                                        echo "selected";
                                    } ?>>Červená</option>
                <option value="Green" <?php if ($barva_pozadi == "Green") {
                                            echo "selected";
                                        } ?>>Zelená</option>
                <option value="Blue" <?php if ($barva_pozadi == "Blue") {
                                            echo "selected";
                                        } ?>>Modrá</option>
                <option value="Yellow" <?php if ($barva_pozadi == "Yellow") {
                                            echo "selected";
                                        } ?>>Žlutá</option>
                <option value="Black" <?php if ($barva_pozadi == "Black") {
                                            echo "selected";
                                        } ?>>Černá</option>
                <option value="Brown" <?php if ($barva_pozadi == "Brown") {
                                            echo "selected";
                                        } ?>>Hnědá</option>
                <option value="White" <?php if ($barva_pozadi == "White") {
                                            echo "selected";
                                        } ?>>Bílá</option>
            </select>
            <br><br>
            <input type="submit" name="odeslat" value="Odeslat">
        </form>
    </div>
</div>
<?php
include './_paticka.php';
?>