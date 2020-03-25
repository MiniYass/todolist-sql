<?php 

$dbHost="localhost";
$dbuser="root";
$dbpwd="";
$dbname="todolist";

try{
    $dns="mysql:host=".$dbHost.";dbname=".$dbname.";charset=utf8";
    $bdd= new PDO($dns,$dbuser,$dbpwd);

    $table=$bdd->query("SELECT * FROM todo");
    $architab=$bdd->query("SELECT * FROM done");

    // ajout dans la liste a faire : 

    if( isset($_POST['addtodo'])  ){
           
        $tache=strip_tags($_POST['addTache']);
     
        $tache=trim($tache,"/\\w|\\s+/");

        $tableAj = $bdd->prepare("INSERT INTO todo (todoName) VALUES (?)");
        $tableAj->bindParam(1, $tache);
        $tableAj->execute(); 
        header('Location:index.php'); 
    }
    // ajout dans la liste deja faite : 
    if(isset($_POST['addDone'])){
    // verifie l'id de la checkbox et va chercher les donnée dans la table correspondante
    $idCheck=$_POST["checkDo"];
    $checkedVal=$bdd->query("SELECT * FROM todo WHERE idTodo=$idCheck");
        foreach ($checkedVal as $row){
            $toAdd=$row["todoName"];
        }
        // insert la valeur dans la table des archive
        $tableAr = $bdd->prepare("INSERT INTO done (doneName) VALUES (?)");
        $tableAr->bindParam(1, $toAdd);
        $tableAr->execute();
           
        // supprime de la bdd todo une fois l'info ajouter aux archiver
        $sql="DELETE FROM todo WHERE idTodo=$idCheck";
        $deleteResult=$bdd->prepare($sql);
        $deleteResult->execute();
        header('Location:index.php'); 
    }
    
}catch(PDOExeption $e){
    echo "DB connexion échoué";
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>To do list</title>
</head>
<body>
<h3>A faire</h3>
<form action="" method="post">

<?php 
    foreach ($table as $row){
        echo"<label for='checkDo'>".$row["todoName"]."</label>
        <input type='checkbox' onclick=checkArchi(".$row['idTodo'].") name='checkDo' id=".$row['idTodo']." value=".$row["idTodo"]."> </br>";
    }
?>
<input type="submit" name="addDone" id="addDone" value="enregistré">
</form>

<h3>archiver</h3>
<?php 
    foreach ($architab as $row){
        echo"<label class='labDone' for=".$row['idDone'].">".$row["doneName"]."</label>
        <input type='checkbox' onclick=checkAfr(".$row['idDone'].") name='checkdone' id=".$row['idDone']." checked> </br>";
    }
?>

<h3>ajouter une tâche</h3>
<form action="" method="post">
    <label for="addTache">entrez une tâche</label>
    <input type="textarea" name="addTache" id="addTache">

    <input type="submit" name="addtodo" value="ajouter">
</form>
   <script src="jquery.js"></script>

    <script src="script.js"></script>
</body>
</html>