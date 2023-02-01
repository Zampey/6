<?php
/* import hlavičky  */
include('./_hlavicka.php');

/* získání parametrů z url adresy  */
$id = $_GET['produkt'];
$img_num = $_GET['img_num'];
if (empty($img_num)) {
    $img_num = 1;
}
?>
<!-- předloha pro jednotlivý výpis produktů -->
<div class="obal_produktu">
    <div class="fotky">
        <?php
        /* výpis fotek produktů */
        $itterator = 1;
        $files = glob('./img/produkty_imgs/' . $id . '/*.jpeg', GLOB_BRACE);
        foreach ($files as $file) {
            echo '<a href="?img_num=' . $itterator . '&produkt=' . $id . '"><div class="responsive">
            <div class="gallery">
                <a target="_blank" href="./img/produkty_imgs/' . $id . '/' . $itterator . '.jpeg" data-lightbox="foto"
                    >
                    <img src="./img/produkty_imgs/' . $id . '/' . $itterator . '.jpeg" alt="Cinque Terre" width="600" height="400">
                </a>
            </div>
        </div></a><br>';
            $itterator++;
        }
        ?>
        <!-- sekce pro fotogalerii s hlavním obrázkem -->
    </div>
    <div class="hlavni_fotka">
        <?php
        echo '<div class="responsive">
        <div class="gallery">
            <a target="_blank" href="./img/produkty_imgs/' . $id . '/' . $img_num . '.jpeg" data-lightbox="foto"
                >
                <img src="./img/produkty_imgs/' . $id . '/' . $img_num . '.jpeg" alt="Cinque Terre" width="600" height="400">
            </a>
        </div>
    </div>';
        ?>
    </div>
    <?php
    /* inicializace potřebných proměnných */
    $nazev = "";
    $cena = "";
    $popis = "";
    $vyrobce = "";
    $skladem = "";

    $sql = "SELECT * FROM $produkty WHERE id = ? ";
    $dotaz = $pripojeni->prepare($sql);
    $dotaz->execute([$id]);
    $data = $dotaz->fetchAll();

    /** deklarace proměnných */
    foreach ($data as $zaznam) {
        $nazev = $zaznam['nazev'];
        $cena = $zaznam['cena'];
        $popis = $zaznam['popis'];
        $vyrobce = $zaznam['vyrobce'];
        $skladem = $zaznam['skladem'];
    }
    ?>
    <!-- sekce pro detailní popis produktu -->
    <div class="informace">
        <?php
        echo ' <div id="nazev" class="nazev_produktu_detail">' . $nazev . '</div>';
        if ($skladem == "true") {
            echo '<span class="je_skladem_detail">Skladem</span>';
        } else {
            echo '<span class="neni_skladem_detail">Není skladem</span>';
        }
        echo '<div id="id_holder" style="display: none">' . $id . '</div>';
        /* sekce pro možnost objednání produktu */
        echo '<div class="cena_objednani_detail"><p>' . $cena . ' Kč</p>
        <input class="pocet_kusu_detail" type="text" id="pk_kosik" style="display:none" value="1">
        <div class="vlozit_btn_detail"><a class="vlozit_odkaz_detail" id="vlozit_btn"  href="">Vložit do košíku</a></div>
        </div>';
        echo '<div class="popis_produktu_detail">' . $popis . '</div>';
        if ($_SESSION['logged_email'] == "admin@admin.admin") {
            echo '<a class="upravit_link" href="./editace.php?id=' . $id . '">Upravit popisek</a>';
        }
        echo '<div class="vyrobce_produktu_detail">Výrobce: ' . $vyrobce . '</div>';
        ?>
    </div>

</div>
<!-- změna titulku strany na název produktu -->
<script>
    let nazevProduktu = document.getElementById('nazev').textContent;
    document.title = nazevProduktu;
    $('meta[name="description"]').attr("content", "stránka pro detailní popis produktu");
</script>
<?php
include('./_paticka.php');
?>