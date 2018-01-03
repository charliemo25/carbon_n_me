<?php

class Search{
    
    private $pdo;
    private $marque;
    private $puiss_admin;
    private $carburant;
    private $conso_mixte;
    private $limit_voiture;
    private $offset_voiture;
    private $page;
    
    public function __construct($new_pdo, $new_marque="", $new_puiss_admin="", $new_carburant="", $new_conso_mixte="", $new_page=""){
        $this->pdo = $new_pdo;
        $this->marque = $new_marque;
        $this->puiss_admin = $new_puiss_admin;
        $this->carburant = $new_carburant;
        $this->conso_mixte = $new_conso_mixte;
        $this->page = $new_page;
        $this->limit_voiture = 50;
        $this->offset_voiture = 0;
    }
    
    public function manage_limit(){
        
        if($this->page == 1){
            $this->offset_voiture = 0;
        } else{
            $this->offset_voiture = 50*$this->page;
        }
    }
    
    public function result(){

        $sql = "select * from voiture";
        $verif_where = false;

        if($this->marque!=""){
            $this->marque.='%';
             if(!$verif_where){
                $sql.=" where";
                $verif_where = true;
            } else{
                $sql.=" and";
            }
            $sql.= " marque like :marque";
        }

        if($this->puiss_admin!=""){
            if(!$verif_where){
                $sql.=" where";
                $verif_where = true;
            } else{
                $sql.=" and";
            }
            $sql.= " puiss_admin=:puiss_admin";
        }

        if($this->carburant!=""){
             if(!$verif_where){
                $sql.=" where";
                $verif_where = true;
            } else{
                $sql.=" and";
            }
            $sql.=" type_carb=:carburant";
        }

        if($this->conso_mixte){
             if(!$verif_where){
                $sql.=" where";
                $verif_where = true;
            } else{
                $sql.=" and";
            }
            $sql.=" conso_mixte between 0 and :conso_mixte";    
        }
        
        $sql.=" limit ".$this->limit_voiture." offset ".$this->offset_voiture;
        
        $req = $this->pdo->prepare($sql);

        if($this->marque!=""){ $req -> bindParam(':marque', $this->marque);}
        if($this->puiss_admin!=""){ $req -> bindParam(':puiss_admin', $this->puiss_admin); }
        if($this->carburant!=""){ $req -> bindParam(':carburant', $this->carburant); }
        if($this->conso_mixte!=""){ $req -> bindParam(':conso_mixte', $this->conso_mixte); }

        $req->execute();
        $result = $req->fetchAll();

        return $result;
    }
    
    /*public function pagi(){
        
        $sql = "select * from voiture";
        $sql.=" limit ".$this->limit_voiture." offset ".$this->offset_voiture;
        
        $req = $this->pdo->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();

        return $result;
    }*/
    
}


?>