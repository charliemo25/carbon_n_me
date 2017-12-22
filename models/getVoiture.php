<?php

function getVoiture($pdo){
	$req = $pdo->prepare('select * from voiture where id_voiture=5');
	$req->execute();
	$result = $req->fetchAll();
	return $result;
}

function getEnergie($pdo){
	$req = $pdo->prepare('select etiquette_energie.label from etiquette_energie inner join voiture on voiture.id_etiquette_energie=etiquette_energie.id_etiquette_energie where voiture.id_voiture=5');
	$req->execute();
	$result = $req->fetchAll();
	return $result;
}

function getBonus($pdo){
	$req = $pdo->prepare('select bonus.montant FROM bonus INNER JOIN voiture on bonus.id_bonus=voiture.id_bonus WHERE voiture.id_voiture=5');
	$req->execute();
	$result = $req->fetchAll();
	return $result;
}

function getMalus($pdo){
	$req = $pdo->prepare('select malus.montant from malus inner join voiture on malus.id_malus=voiture.id_malus where voiture.id_voiture=5');
	$req->execute();
	$result = $req->fetchAll();
	return $result; 
}

?>