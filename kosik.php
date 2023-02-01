<?php
include './_hlavicka.php';
?>
<!-- sekce s košíkem -->
<div class="nadpis_kosik">Košík</div>
<div class="kosik_obal">
    <div class="obsah_kosik">
        <?php
        $celkovaCena = 0;
        $idProduktu = "";
        if (isset($_COOKIE['v_kosiku'])) {
            /* určení jestli už je něco vkošíku */
            $polozky = $_COOKIE['v_kosiku'];
            if ($polozky != null and $polozky != "") {
                $rozdeleni = explode(",", $polozky);
                $count = 0;
                /* rozdělení položek z cookie do jednotlivych produktů */
                foreach ($rozdeleni as $polozka) {
                    $detail = explode(":", $polozka);
                    if ($polozka != null) {
                        $idProduktu = $idProduktu . $detail[0] . ",";

                        /** Vyhledáme záznamy */
                        $sql = "SELECT * FROM $produkty WHERE id = ?";
                        $dotaz = $pripojeni->prepare($sql);
                        $dotaz->execute([$detail[0]]);
                        $data = $dotaz->fetchAll();

                        /** Všechny vybrané záznamy vypíšeme */
                        foreach ($data as $zaznam) {
                            echo '<div class="kosik_item">
                        <div class="content_holder">
                    <div class="obrazek_item"><img src="./img/produkty_imgs/' . $zaznam['id'] . '/1.jpeg"></div>
                        <div class=" nazev_item">' . $zaznam['nazev'] . '</div>
                        <div class="cena_item">' . $zaznam['cena'] . ' Kč</div>
                        </div><a href="?rem=' . $count . '"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-trash-fill pull-right " viewBox="0 0 16 16">
                         <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                        </svg></a>
                        </div>
                        ';
                            $count += 1;
                            $celkovaCena += $zaznam['cena'];
                        }
                    }
                }
                echo '<p class="suma">celkem: ' . $celkovaCena . " Kč</p>";
                echo '</div>';
                if (isset($_GET['rem'])) {
                    $val = $_GET['rem'];
                    unset($rozdeleni[$val]);
                    setcookie("v_kosiku", implode(",", $rozdeleni), time() + 3600);
                    header('Location: ./kosik.php');
                    die();
                }
            }
            /* zobrazení sidepanelu košíku pro
            možnost zadat údaje pro doručení */
            echo '<div class="sidepanel_kosik">
            <div class="order_obal">
                <form action="" method="post">
                    <input class="order_input" type="text" name="jmeno" placeholder="Jméno"><br>
                    <input class="order_input" type="text" name="prijmeni" placeholder="Příjmení"><br>
                    <input class="order_input" type="email" name="email" placeholder="E-mail"><br>
                    <input class="order_input" type="text" name="mesto" placeholder="Město"><br>
                    <input class="order_input" type="text" name="ulice" placeholder="Ulice/č.p."><br>
                    <input class="order_input" maxlength="6" type="text" name="psc" placeholder="PSČ"><br>
                    <input class="order_btn" type="submit" name="objednat" value="Odeslat Objednávku">
                </form>
            </div>
        </div>';
        } else {

            echo '</div></div><div class="prazdny_kosik">Váš košík je prázdný</div>';
        }
        /* vyhodnocení objednávacího formuláře */
        if (isset($_POST['objednat'])) {
            $jmeno = $_POST['jmeno'];
            $prijmeni = $_POST['prijmeni'];
            $email = $_POST['email'];
            $mesto = $_POST['mesto'];
            $ulice = $_POST['ulice'];
            $psc = $_POST['psc'];

            /** Vložení záznamů */;
            $sql = "INSERT INTO $objednavky (jmeno,prijmeni,email,mesto,ulice,psc,produkty) VALUES(?, ?, ?, ?, ?,?,?)";
            $dotaz = $pripojeni->prepare($sql);
            $dotaz->execute([$jmeno, $prijmeni, $email, $mesto, $ulice, $psc, $idProduktu]);

            //Odstraní cookie
            setcookie("v_kosiku", NULL, time() - 3600);
            header('Location: ./objednano.php');
            die();
        }
        ?>
    </div>
    <!-- nastavení titulku strany na košík -->
    <script>
        document.title = "Košík";
        $('meta[name="description"]').attr("content", "stránka pro košík");
    </script>
    <?php
    include './_paticka.php';
    ?>