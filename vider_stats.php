<?php
// Chemin vers le fichier CSV
$fichier_csv = 'visites.csv';

// Vérifier si le fichier existe
if (file_exists($fichier_csv)) {
    // Générer un nom unique pour l'ancien fichier
    $nouveau_nom = 'archives/visites_' . rand(0, 1000) . '_' . date('Ymd_His') . '.csv';

    // Créer le dossier 'archives' s'il n'existe pas
    if (!file_exists('archives')) {
        mkdir('archives', 0777, true);
    }

    // Renommer le fichier CSV
    if (rename($fichier_csv, $nouveau_nom)) {
        // Réinitialiser un nouveau fichier CSV vide avec l'en-tête
        $en_tete = ['Date', 'Heure', 'Adresse IP'];
        $fichier = fopen($fichier_csv, 'w');
        fputcsv($fichier, $en_tete);
        fclose($fichier);
        echo "Les statistiques ont été vidées et sauvegardées dans $nouveau_nom.";
    } else {
        echo "Erreur lors de la sauvegarde de l'ancien fichier.";
    }
} else {
    echo "Le fichier CSV n'existe pas.";
}
?>
