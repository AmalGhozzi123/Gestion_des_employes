<?php
session_start();
if(!isset($_SESSION['matricule'])|| !isset($_SESSION['password']) ){
    header("location:login.php");exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
    table {font-family:Georgia, serif;
            width: 150%;
			max-width: 1350px;
			color: #333;
			border: 1px solid #ccc;
			border-radius: 10px;
			box-shadow: 0 3px 3px rgba(0, 0, 0, 0.1);
			background-color: #fff;
			overflow: hidden;
            position:absolute;
            left:100px;
			top:160px;
		}
		table th, table td {
			padding: 8px;
			text-align: left;
			vertical-align: middle;
			border-top: 1px solid #ccc;
			border-bottom: 1px solid #ccc;
      font-size:15px;
		}
		table th {
			background-color: #f1f1f1;
			color: #666;
			/*text-transform: uppercase;*/
			letter-spacing: 1px;
			font-weight: 600;
			border-top: none;
		}
		table td {
			background-color: #fff;
			color: #333;
      font-weight:200px;
		}
		table tr:nth-child(even) td {
			background-color: #f9f9f9;
		}
		table tr:hover td {
			background-color: #f5f5f5;
		}
		header h4{
    color: #e0ac1c;
  
}

header span {
    color: #031b62;

}
header{text-align:center;
    font-family:Georgia, serif;
  
    }
    .retour {
  display: inline-block;
  padding: 10px 10px;
  background-color:#18022f ;
  color: white;
  font-size: 12px;
  text-decoration: none;
  border-radius: 7px;
  transition: background-color 0.3s ease;
  position:absolute;
  top:0px;
  left:0px;
}
.retour {
  display: inline-block;
  padding: 10px 10px;
  background-color:#18022f ;
  color: white;
  font-size: 12px;
  text-decoration: none;
  border-radius: 7px;
  transition: background-color 0.3s ease;
  position:absolute;
  top:0px;
  left:0px;
}

.retour i {
  margin-right: 10px;
}

.retour:hover {
  background-color:#e0ac1c ;
}
.accept-btn {
  background-color: #3cb371;
  color: #fff;
  padding: 6px 12px;
  border-radius: 4px;
  text-decoration: none;
  border: none;
}

.reject-btn {
  background-color: #dc143c;
  color: #fff;
  padding: 6px 12px;
  border-radius: 4px;
  text-decoration: none;
  border: none;
}


</style>
</head>
<body style="background-color: #eaf0f2">
<a href="Accueilemployé.php" class="retour"><i class="fa fa-chevron-left"></i> Retour</a>  
   <?php

$title="<header><h4><b>Votre <span>Primes</b></span></h4></header>";
// Vérifiez si l'employé est connecté
if (!isset($_SESSION['matricule'])) {
    header('Location: login.php');
    exit();
}

// Récupération du matricule de l'employé connecté
$matricule = $_SESSION['matricule'];

// Connexion à la base de données
try {
    $dbh = new PDO('mysql:host=localhost;dbname=gestion_poste', 'root', '');
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

// Récupération des demandes de congé de l'employé connecté
$stmt = $dbh->prepare("
    SELECT u.nom, u.prenom, pn.mois,pn.annee,pn.nbr_heures,pn.brut
    FROM primes_nuit pn
    JOIN user u ON pn.matricule = u.matricule 
    WHERE u.matricule = '$matricule'
");
$stmt->execute();
$demandes_conge = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Affichage des demandes de congé dans un tableau

echo "<table>";
echo "<tr><th>Nom</th><th>Prénom</th><th>Mois</th><th>Année</th><th>Brut-Total</th></tr>";
foreach ($demandes_conge as $demande) {
    echo "<tr>";
    echo "<td  style='font-weight:300px'>" . $demande['nom'] . "</td>";
    echo "<td>" . $demande['prenom'] . "</td>";
    echo "<td>" . $demande['mois'] . "</td>";
    echo "<td>" . $demande['annee'] . "</td>";
    echo "<td>" . $demande['brut'] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>

<?php
        $container = ob_get_clean();
        include "layout.php";
        ?>
</body>
</html>
