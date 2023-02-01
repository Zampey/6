<?php
/* základní rozdělení kategorií a import hlavičky */
include './_hlavicka.php';
$kategorie = array();
$kategorie["pocitace"] = 1;
$kategorie["notebooky"] = 2;
$kategorie["telefony"] = 3;
$kategorie["prislusenstvi"] = 4;
$type = $_GET['type'];
?>
<!-- struktura pro menu s možností filtrace produktů -->
<div class="obal_produkty">
    <!-- samotný výpis produktů dané kategorie -->
    <div class="vypis_produktu">
        <?php
        /** Výpis záznamů */
        $sql = "SELECT * FROM $produkty WHERE kategorie=" . $kategorie[$type];
        $data = $pripojeni->query($sql)->fetchAll();
        /** Všechny záznamy vypíšeme */
        foreach ($data as $zaznam) {
            $nahledak = "./img/produkty_imgs/" . $zaznam["id"] . "/1.jpeg";
            echo '<a class"y" href="./produkt.php?img_num=1&produkt=' . $zaznam['id'] . '">
            <div class="produkt">
                <div class="nahled_obal">
                <img class="produkt_nahled" src="' . $nahledak . '">
                </div>
                <hr class="podtrzitko">';
            /* kontrola jestli je daný produkt skladem */
            if ($zaznam['skladem'] == "true") {
                echo '<div class="dostupnost"><span class="je_skladem">Skladem</span></div>';
            } else {
                echo '<div class="dostupnost"><span class="neni_skladem">Není skladem</span></div>';
            }
            /* výpis parametrů produktu */
            echo '<br><p class="nazev_produktu">' . $zaznam['nazev'] . '</p>';
            echo '<hr class="podtrzitko" style="width:200px;margin:auto">';
            echo '<p class="cena_produktu">' . $zaznam['cena'] . ' Kč</p>';
            echo '<hr class="podtrzitko" style="width:200px;margin:auto">';
            echo '<div class="popis_div"><p class="popis_produktu">' . $zaznam['popis'] . '</p></div>';
            echo '<div class="vice"><a href="./produkt.php?img_num=1&produkt=' . $zaznam['id'] . '">Více</a></div>';
            echo '</div></a>';
        }
        ?>
    </div>
</div>
<?php
include('./_paticka.php');
?>
<script>
    /* změna titulku na zboží */
    document.title = "Zboží";
    $('meta[name="description"]').attr("content", "stránka pro výpis zboží z dané kategorie");
</script>