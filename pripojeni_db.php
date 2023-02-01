<?php

/** Parametry pro připojení k databázi SQLite */
$databaze = './db/database.sqlite';
$uzivatele = 'uzivatele';
$produkty = 'produkty';
$objednavky = 'objednavky';

/** Vytvoření připojení */
$pripojeni = new PDO("sqlite:" . $databaze); // Když databáze neexituje, tak se vytvoří
$pripojeni->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Nastavíme zachycení vyjímky
$pripojeni->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Nastavíme styl výpisu

/** Vytvoření tabulky pro uživatele */
$sql = 'CREATE TABLE IF NOT EXISTS ' . $uzivatele . ' (
        id INTEGER PRIMARY KEY,
        jmeno TEXT,
        prijmeni TEXT,
        email TEXT,
        heslo TEXT,
        prava TEXT
    )';
$pripojeni->exec($sql);

/** Vytvoření tabulky pro objednávky */
$sql = 'CREATE TABLE IF NOT EXISTS ' . $objednavky . ' (
    id INTEGER PRIMARY KEY,
    jmeno TEXT,
    prijmeni TEXT,
    email TEXT,
    mesto TEXT,
    ulice TEXT,
    psc TEXT,
    produkty TEXT
)';
$pripojeni->exec($sql);

/** Vytvoření tabulky pro produkty */
$sql = 'CREATE TABLE IF NOT EXISTS ' . $produkty . ' (
    id INTEGER PRIMARY KEY,
    nazev TEXT,
    cena INTEGER,
    popis TEXT,
    vyrobce TEXT,
    skladem TEXT,
    kategorie INTEGER,
    obrazky TEXT
)';
$pripojeni->exec($sql);
addAdminLogin($pripojeni, $uzivatele);

/* funkce pro automatické přidání admin účtu do databáze */
function addAdminLogin($pripojeni, $uzivatele)
{
    $jmeno = "admin";
    $prijmeni = "admin";
    $email = "admin@admin.admin";
    $heslo = password_hash("admin", PASSWORD_DEFAULT);
    $prava = "admin";

    $sql = "SELECT * FROM $uzivatele WHERE email = ? ";
    $dotaz = $pripojeni->prepare($sql);
    $dotaz->execute([$email]);
    $data = $dotaz->fetchAll();
    if (sizeof($data) < 1) {
        $sql = "INSERT INTO $uzivatele (jmeno,prijmeni,email,heslo,prava) VALUES(?, ?,?,?,?)";
        $dotaz = $pripojeni->prepare($sql);
        $dotaz->execute([$jmeno, $prijmeni, $email, $heslo, $prava]);
    }
}
