<?php 
$id=$_COOKIE["idone"]; 

$dbHost="localhost";
$dbuser="root";
$dbpwd="";
$dbname="todolist";
try{
    $dns="mysql:host=".$dbHost.";dbname=".$dbname.";charset=utf8";
    $bdd= new PDO($dns,$dbuser,$dbpwd);

    $tableTodo=$bdd->query("SELECT * FROM todo WHERE idTodo=$id");
    foreach ($tableTodo as $row){
        $toAdd=$row["todoName"];
    }

    $tableAr = $bdd->prepare("INSERT INTO done (doneName) VALUES (?)");
    $tableAr->bindParam(1, $toAdd);
    $tableAr->execute();

    // supprime de la bdd todo une fois l'info ajouter aux archiver
    $sql="DELETE FROM todo WHERE idTodo=$id";
    $deleteResult=$bdd->prepare($sql);
    $deleteResult->execute();

    header('Location:index.php');

}catch(PDOExeption $e){
    echo "DB connexion échoué";
}

?>
<script src="jquery.js"></script>
<script src="script.js"></script>