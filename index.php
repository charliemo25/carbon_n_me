<?php

require_once "./vendor/autoload.php";

// Rendu des modèles qui sont dans le fichier views.
$loader = new Twig_Loader_Filesystem('./views');
$twig = new Twig_Environment($loader, array(
// En 'cache => false :A chaque réinitialisation de la page il affiche les modifications.
	'cache' => false,
));

// Routage vers les pages.
$router = new AltoRouter();
$router->setBasePath('carbon_n_me/');

$router->map( 'GET', '/', function() {

	global $twig;

	$tableau = ['base', 'category', 'subcategory', 'item', 'color', ];

	$template = $twig->load('home.html.twig');

	$test = "http://localhost/carbon_n_me/test";

  $search = "http://localhost/carbon_n_me/search";

// Action qui rend visible le html du fichier home.html.twig dans la page carbon-n-me.
	echo $template->render(array('data' => $tableau, 'url' => $test));

});

$router->map( 'GET', '/home', function() {

  global $twig;

  $tableau = ['base', 'category', 'subcategory', 'item', 'color', ];

  $template = $twig->load('home.html.twig');

  $test = "http://localhost/carbon_n_me/test";

  $search = "http://localhost/carbon_n_me/search";

// Action qui rend visible le html du fichier home.html.twig dans la page carbon-n-me.
  echo $template->render(array('data' => $tableau, 'url' => $test));

});
//Routage vers la page test.html.twig.

$router->map( 'GET', '/test', function() {

	global $twig;

	$template = $twig->load('test.html.twig');

	echo $template->render(array('data' => 'test'));

});

$router->map( 'POST|GET', '/search/[i:id]', function($id) {

	global $twig;

    include_once 'models/pdo.php';
    include_once 'models/search.php';
    
    if($id<=0){
        header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    }
    
    $marque = "";
    $puiss_admin = "";
    $carburant = "";
    $conso_mixte = "";
    
    if(isset($_REQUEST['marque'])){
        $marque = $_REQUEST['marque'];  
    } elseif(isset($_COOKIE['marque'])){
        $marque = $_COOKIE['marque'];
    }
    
    if(isset($_REQUEST['puiss_admin'])){
        $puiss_admin = $_REQUEST['puiss_admin'];   
    } elseif(isset($_COOKIE['puiss_admin'])){
        $puiss_admin = $_COOKIE['puiss_admin'];
    }
    
    if(isset($_REQUEST['carburant'])){
        $carburant = $_REQUEST['carburant'];  
    } elseif(isset($_COOKIE['carburant'])){
        $carburant = $_COOKIE['carburant'];
    }
    
    if(isset($_REQUEST['conso_mixte'])){
        $conso_mixte = $_REQUEST['conso_mixte'];
    } elseif(isset($_COOKIE['conso_mixte'])){
        $conso_mixte = $_COOKIE['conso_mixte'];
    }
    
    if(isset($_COOKIE['marque']) || isset($_COOKIE['puiss_admin']) || isset($_COOKIE['carburant']) || isset($_COOKIE['conso_mixte'])){
        unset($_COOKIE);
    }
    
    setcookie("marque", $marque, time()+3600);
    setcookie("puiss_admin", $puiss_admin, time()+3600);
    setcookie("carburant", $carburant, time()+3600);
    setcookie("conso_mixte", $conso_mixte, time()+3600);
    
    
    
    
    $recherche = new Search($pdo, $marque, $puiss_admin, $carburant, $conso_mixte, $id);

    $recherche->manage_limit();
    $voiture_tab = $recherche->result();
    
    $nb_voitures = count($voiture_tab);
    $suivant = false;
    
    if($nb_voitures == 50){
        $suivant = true;
    }
    
    $template = $twig->load('search.html.twig');
	echo $template->render(array('voitures' => $voiture_tab, 'page' => $id, "suivant" => $suivant));

});


$router->map( 'GET', '/voiture/[i:id]', function($id) {

    global $twig;

    include_once 'models/pdo.php';
    include_once 'models/getVoiture.php';

    $voiture = new Voiture($pdo, $id);

    $voiture_info = $voiture->getVoiture();
    $energie = $voiture->getEnergie();
    $bonus = $voiture->getBonus();
    $malus = $voiture->getMalus();
    
    $template = $twig->load('voiture.html.twig');
    echo $template->render(array('voiture' => $voiture_info,'energie' => $energie, 'bonus' => $bonus, 'malus' => $malus	));

});


// match current request url
$match = $router->match();

// call closure or throw 404 status
if( $match && is_callable( $match['target'] ) ) {
	call_user_func_array( $match['target'], $match['params'] );
} else {
	// no route was matched
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}


?>
