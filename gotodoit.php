<?php 
$id=$_COOKIE["idoit"]; 

$dbHost="localhost";
$dbuser="root";
$dbpwd="";
$dbname="todolist";

try{
    $dns="mysql:host=".$dbHost.";dbname=".$dbname.";charset=utf8";
    $bdd= new PDO($dns,$dbuser,$dbpwd);

    $tableDone=$bdd->query("SELECT * FROM done WHERE idDone=$id");
    foreach ($tableDone as $row){
        $toAdd=$row["doneName"];
    }

//  insert la valeur chercher par l'id
    $tableAj = $bdd->prepare("INSERT INTO todo (todoName) VALUES (?)");
    $tableAj->bindParam(1, $toAdd);
    $tableAj->execute(); 

// supprime de la table archiver
    $sql="DELETE FROM done WHERE idDone=$id";
    $deleteArchi=$bdd->prepare($sql);
    $deleteArchi->execute();

    header('Location:index.php');

}catch(PDOExeption $e){
    echo "DB connexion échoué";
}

?>
<script src="jquery.js"></script>
<script src="script.js"></script>
