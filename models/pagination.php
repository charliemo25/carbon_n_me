<?php 
function pagination($pdo, $marque, $puiss_admin, $carburant, $conso_mixte){
    
    $sql = "select * from voiture";
    $verif_where = false;
    
    if($marque!=""){
        $marque.='%';
         if(!$verif_where){
            $sql.=" where";
            $verif_where = true;
        } else{
            $sql.=" and";
        }
        $sql.= " marque like :marque";
    }
    
    if($puiss_admin!=""){
        if(!$verif_where){
            $sql.=" where";
            $verif_where = true;
        } else{
            $sql.=" and";
        }
        $sql.= " puiss_admin=:puiss_admin";
    }
    
    if($carburant!=""){
         if(!$verif_where){
            $sql.=" where";
            $verif_where = true;
        } else{
            $sql.=" and";
        }
        $sql.=" type_carb=:carburant";
    }
    
    if($conso_mixte){
         if(!$verif_where){
            $sql.=" where";
            $verif_where = true;
        } else{
            $sql.=" and";
        }
        $sql.=" conso_mixte between 0 and :conso_mixte";    
    }
    
    $req = $pdo->prepare($sql);
    
    if($marque!=""){ $req -> bindParam(':marque', $marque);}
    if($puiss_admin!=""){ $req -> bindParam(':puiss_admin', $puiss_admin); }
    if($carburant!=""){ $req -> bindParam(':carburant', $carburant); }
    if($conso_mixte!=""){ $req -> bindParam(':conso_mixte', $conso_mixte); }
    
    $req ->execute();
    $result = $req->fetchAll();
    
    return $result;
}

/*function verifWhere($string){
    $cut = substr($string, -5);
    if($cut != 'where'){
        return ' where';
    } else{
        return ' and';
    }
}*/

?>