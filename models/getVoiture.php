<?php

function getVoiture($pdo){
	$req = $pdo->prepare('select * from voiture where id_voiture=5');
	$req->execute();
	$result = $req->fetchAll();
	return $result;
}

?>