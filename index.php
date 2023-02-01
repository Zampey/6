<?php
include './_hlavicka.php';
?>
<!-- vlastní obsah strany -->
<!-- slideshow -->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indikátory -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>

    <!-- položky -->
    <div class="carousel-inner">
        <div class="item active">
            <img src="./img/carousel/c1.jpg" style="width:100%;">
        </div>
        <div class="item">
            <img src="./img/carousel/c2.jpg" style="width:100%;">
        </div>
        <div class="item">
            <img src="./img/carousel/c3.jpg" style="width:100%;">
        </div>
        <div class="item">
            <img src="./img/carousel/c4.jpg" style="width:100%;">
        </div>
    </div>

    <!-- posuvníky -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Předchozí</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Další</span>
    </a>
</div>

<!-- infopanel -->
<div class="infopanel">
    <div class="infopanel_polozka">
        <div class="infopanel_kruh"><i class="fa-solid fa-warehouse fa-3x infopanel_icon"></i></div>
        <p class="infopanel_popis">Více než <b><?php
                                                pocetProduktuSkladem($pripojeni, $produkty);
                                                ?></b> produktů skladem</p>
    </div>
    <!-- položka z infopanelu -->
    <div class="infopanel_polozka">
        <div class="infopanel_kruh"><i class="fa-solid fa-shop fa-3x infopanel_icon"></i></div>
        <p class="infopanel_popis">Více než <b>78</b> kamenných prodejen</p>
    </div>
    <!-- položka z infopanelu -->
    <div class="infopanel_polozka">
        <div class="infopanel_kruh"><i class="fa-solid fa-truck fa-3x infopanel_icon"></i></div>
        <p class="infopanel_popis">Možnost dopravy <b>zdarma</b></p>
    </div>,
    <!-- položka z infopanelu -->
    <div class="infopanel_polozka">
        <div class="infopanel_kruh"><i class="fa-sharp fa-solid fa-people-group fa-3x infopanel_icon"></i></div>
        <p class="infopanel_popis">Dnešní návštěvnost:<br> <b><?php
                                                                mereniNavstevnosti();
                                                                ?></b> lidí</p>
    </div>

</div>

<?php
include('./_paticka.php');
?>