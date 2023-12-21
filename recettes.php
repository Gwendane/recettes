<?php

// Configuration de la base de données
$servername = "votre_hote";
$username = "votre_nom_utilisateur";
$password = "votre_mot_de_passe";
$dbname = "recettes_api";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    
    
die("La connexion a échoué : " . $conn->connect_error);
}

// Récupérer l'action à effectuer depuis la requête

$action = isset($_GET['action']) ? $_GET['action'] : '';

// Exécuter l'action correspondante
switch ($action) {
    
  
case 'getToutesLesRecettes':

  
echo getToutesLesRecettes();

  
break;

    

case 'getRecetteParId':

 
$id = isset($_GET['id']) ? $_GET['id'] : '';
        
      
echo getRecetteParId($id);
        
        
break;


case 'ajouterNouvelleRecette':
        
     
$nom = isset($_POST['nom']) ? $_POST['nom'] : '';

   
$pays = isset($_POST['pays']) ? $_POST['pays'] : '';
        
 
$difficulte = isset($_POST['difficulte']) ? $_POST['difficulte'] : '';
        $detail = isset($_POST['detail']) ? $_POST['detail'] : '';

        

    
echo ajouterNouvelleRecette($nom, $pays, $difficulte, $detail);
        
       
break;

   
default:
        
  
echo json_encode(array('message' => 'Action non valide.'));
        
        
break;
}

// Fermer la connexion à la base de données
$conn->close();

// Fonction pour récupérer toutes les recettes
function getToutesLesRecettes() {
    
 
global $conn;
    $sql = "SELECT * FROM recettes";
    
    
$result = $conn->query($sql);

    $recettes = array();
    
    
while ($row = $result->fetch_assoc()) {
        
        
$recettes[] = $row;
    }

    
    }
return json_encode($recettes);

// Fonction pour récupérer une recette spécifique par son ID

function getRecetteParId($id) {
    
global $conn;
    $sql = "SELECT * FROM recettes WHERE id = $id";
    
   
$result = $conn->query($sql);

    
if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
return json_encode($row);
    } 
 
else {
        
 
return json_encode(array('message' => 'Aucune recette trouvée avec cet ID.'));
    }
}

// Fonction pour ajouter une nouvelle recette

function ajouterNouvelleRecette($nom, $pays, $difficulte, $detail) {
    
global $conn;
    $sql = "INSERT INTO recettes (nom_recette, pays_origine, difficulte, detail_recette)
            VALUES ('$nom', '$pays', $difficulte, '$detail')";

    if ($conn->query($sql) === TRUE) {
        
return json_encode(array('message' => 'Recette ajoutée avec succès.'));
    } else {
        
        
return json_encode(array('message' => 'Erreur lors de l\'ajout de la recette : ' . $conn->error));
    }
}
?>