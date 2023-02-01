<?php
include './_hlavicka.php';
/* počáteční načtení popisu produktu z databáze */
$id = $_GET['id'];
$sql = "SELECT * FROM $produkty WHERE id = ? ";
$dotaz = $pripojeni->prepare($sql);
$dotaz->execute([$id]);
$data = $dotaz->fetchAll();

/* uložení popisu do proměnné */
$obsah = "";
foreach ($data as $polozka) {
    $obsah = $polozka['popis'];
}
?>
<form action="" method="post">
    <textarea name="obsah" cols="1" rows="18"><?php echo $obsah; ?></textarea><br><br>
    <input type="submit" name="ulozit" value="Uložit">
</form>

<?php
/* uložení upraveného obsahu do databáze a přesměrování na předchozí stranu s produktem */
if (isset($_POST['ulozit'])) {
    $obsah = $_POST['obsah'];
    /**Aktualizace záznamů */
    $sql = "UPDATE $produkty SET popis = ? WHERE id = ?";
    $dotaz = $pripojeni->prepare($sql);
    $dotaz->execute([$obsah, $id]);
    header('Location: ./produkt.php?img_num=1&produkt=' . $id);
    die();
}
?>
<?php
include './_paticka.php';
?>

<!--skript, který zobrazí editor textu a načte obsah pole textarea z formuláře-->
<script type="text/javascript" src="./js/tinymce/tinymce.min.js">
</script>
<script type="text/javascript">
    // Aktivijeme editor a provedeme úpravu
    tinymce.init({
        language: 'cs',
        selector: 'textarea[name=obsah]',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table directionality',
            'emoticons template paste textpattern imagetools codesample toc'
        ],
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
        image_advtab: true,
    });
</script>