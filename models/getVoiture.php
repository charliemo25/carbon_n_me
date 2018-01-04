<?php

class Voiture {

	private $pdo;
	private $id;

	public function __construct($new_pdo, $new_id){
		$this->pdo = $new_pdo;
		$this->id = $new_id;
	}

	public function getVoiture(){
		$req = $this->pdo->prepare('select * from voiture where id_voiture=:id');
		$req->bindParam(':id', $this->id);
		$req->execute();
		$result = $req->fetchAll();
		return $result;
	}

	public function getEnergie(){
		$req = $this->pdo->prepare('select etiquette_energie.label from etiquette_energie inner join voiture on voiture.id_etiquette_energie=etiquette_energie.id_etiquette_energie where voiture.id_voiture=:id');
		$req->bindParam(':id', $this->id);
		$req->execute();
		$result = $req->fetchAll();
		return $result;
	}

	public function getBonus(){
		$req = $this->pdo->prepare('select bonus.montant FROM bonus INNER JOIN voiture on bonus.id_bonus=voiture.id_bonus WHERE voiture.id_voiture=:id');
		$req->bindParam(':id', $this->id);
		$req->execute();
		$result = $req->fetchAll();
		return $result;
	}

	public function getMalus(){
		$req = $this->pdo->prepare('select malus.montant from malus inner join voiture on malus.id_malus=voiture.id_malus where voiture.id_voiture=:id');
		$req->bindParam(':id', $this->id);
		$req->execute();
		$result = $req->fetchAll();
		return $result; 
	}
    
    public function getMaxCo2(){
		$req = $this->pdo->prepare('select distinct dscom, marque, co2 from voiture order by co2 desc limit 5');
		$req->bindParam(':id', $this->id);
		$req->execute();
		$result = $req->fetchAll();
		return $result;
	}

}

?>