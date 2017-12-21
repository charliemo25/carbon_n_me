<?php 

function pagination($pdo, $marque){
    $req = $pdo->prepare("select * from voiture where marque=:marque");
    $req -> bindParam(':marque', $marque);
    $req ->execute();
    $result = $req->fetchAll();
    return $result;
}

?>