<?php

// Chemin vers le fichier CSV
$fichier_csv = 'visites.csv';

// Vérifier si le fichier existe, sinon le créer avec l'en-tête
if (!file_exists($fichier_csv)) {
    $en_tete = ['Provenance','Date', 'Heure', 'Adresse IP'];
    $fichier = fopen($fichier_csv, 'w');
    fputcsv($fichier, $en_tete);
    fclose($fichier);
}

// Récupérer les informations de la visite
$date = date('Y-m-d');         // Date au format AAAA-MM-JJ
$heure = date('H:i:s');        // Heure au format HH:MM:SS
//$adresse_ip = $_SERVER['REMOTE_ADDR']; // Adresse IP du visiteur
$adresse_ip = "";
$provenance="inconnue";
if(isset($_GET['provenance'])){
    $provenance=$_GET["provenance"];
}

// Enregistrer les informations dans le fichier CSV
$fichier = fopen($fichier_csv, 'a');
fputcsv($fichier, [$provenance,$date, $heure, "$adresse_ip"]);
fclose($fichier);

// Retourner une image vide pour masquer toute sortie
header('Content-Type: image/png');
echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/wcAAgMBAz8RxokAAAAASUVORK5CYII=');
exit;
?>
