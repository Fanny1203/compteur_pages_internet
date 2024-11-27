<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage des visites</title>
    <!-- Lien vers le fichier CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Affichage des visites</h1>
    <?php



// Chemin vers le fichier CSV
$fichier_csv = 'visites.csv';



//************************* */ Demande de vidage? */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vider'])) {
    if (file_exists($fichier_csv)) {
        // Générer un nom unique pour l'ancien fichier
        $nom_sauvegarde = 'archives/visites_' . rand(0, 1000) . '_' . date('Ymd_His') . '.csv';
    
        // Créer le dossier 'archives' s'il n'existe pas
        if (!file_exists('archives')) {
            mkdir('archives', 0777, true);
        }
    
        // Renommer le fichier CSV
        if (rename($fichier_csv, $nom_sauvegarde)) {
            // Pas besoin de refaire un fichier vide, ce sera fait quand on appelle compteur
            header('location: affiche_compteur.php?jeviensde=vider&nom_sauvegarde='.$nom_sauvegarde);
        } else {
            echo "Erreur lors de la sauvegarde de l'ancien fichier.";
        }
    } else {
        echo "Le fichier CSV n'existe pas.";
    }
}

//On vient d'un vidage?
if(isset($_GET['jeviensde'])){
    if($_GET["jeviensde"]=="vider"){
        echo "<p><i>Les statistiques ont été vidées et sauvegardées dans ".$_GET["nom_sauvegarde"]."</i></p>";
    }   
}



//**************affichage */
// Vérifier si le fichier existe (et le recharger si on vient de le vider)
echo "<h2>Admin</h2>";
if (file_exists($fichier_csv)) {
    echo '<div class="buttons-container">
        <form method="get" action="telecharger_csv.php"">
            <button type="submit">Télécharger le fichier CSV</button>
          </form>
        <form method="post" action="">
            <button name="vider" type="submit" onclick="return confirm(\'Voulez-vous vraiment vider les statistiques ?\')">Vider les statistiques</button>
          </form>
          </div>';


    // STATS TOTALES

    echo "<h2>Statistiques synthétiques</h2>";
    $pageVisits = [];
    if (($handle = fopen($fichier_csv, "r")) !== false) {
        $numligne=0;
        // Lire les lignes une par une sauf la première
        while (($row = fgetcsv($handle)) !== false) {
            if($numligne==0){$numligne++;continue;}
            if (!empty($row) && isset($row[0])) {
                $page = $row[0]; // provenance
                if (!isset($pageVisits[$page])) {
                    $pageVisits[$page] = 0;
                }
                $pageVisits[$page]++;
            }
        }
        fclose($handle);
    } else {
        echo "Impossible d'ouvrir le fichier CSV.";
    }
    echo "<table border='1'>";
    foreach ($pageVisits as $provenance => $count) {
        echo "<tr><td>$provenance </td><td> $count visite(s)</td></tr>";
    }
    echo "</table>";



    echo "<h2>Statistiques détaillées</h2>";
    echo "<table border='1'>";
    $fichier = fopen($fichier_csv, 'r');
    $numligne=0;
    while (($ligne = fgetcsv($fichier)) !== false) {
        $td="td";
        if($numligne==0){$td="th";}
        echo "<tr><$td>" . htmlspecialchars($ligne[0]) . "</$td><$td>". htmlspecialchars($ligne[1]) . "</$td><$td>". htmlspecialchars($ligne[2]) . "</$td></tr>";
        $numligne++;
    }
    fclose($fichier);
    echo "</table>";

    
}
else{
    echo "<h2>Fichier csv non créé : probablement parce qu'aucune visite n'a encore été enregistrée.</h2>";
}
?>
</body>
</html>