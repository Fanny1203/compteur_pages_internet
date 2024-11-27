<?php
// Chemin vers le fichier CSV
$fichier_csv = 'visites.csv';

// Vérifier si le fichier existe
if (file_exists($fichier_csv)) {
    // Définir les en-têtes HTTP pour le téléchargement
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="visites.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Envoyer le contenu du fichier au navigateur
    readfile($fichier_csv);
    exit;
} else {
    echo "Le fichier CSV n'existe pas.";
}
echo "<a href='affiche_compteur.php'>Retour</a>";
?>
