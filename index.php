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

//Routage vers la page test.html.twig.

$router->map( 'GET', '/test', function() {

	global $twig;

	$template = $twig->load('test.html.twig');

	echo $template->render(array('data' => 'test'));

});

$router->map( 'POST|GET', '/search', function() {

	global $twig;

    include_once 'models/pdo.php';
    include_once 'models/pagination.php';
    $marque = $_REQUEST["marque"];
    $puiss_admin = $_REQUEST['puiss_admin'];
    $carburant = $_REQUEST['carburant'];
    $conso_mixte = $_REQUEST['conso_mixte'];
    $voiture_tab = pagination($pdo, $marque, $puiss_admin, $carburant, $conso_mixte);
	$template = $twig->load('search.html.twig');

	echo $template->render(array('voitures' => $voiture_tab));

});

$router->map( 'GET', '/voiture', function() {


global $twig;

$template = $twig->load('voiture.html.twig');

echo $template->render(array('data' => 'voiture'));

include_once 'models/pdo.php';
include_once 'models/getVoiture.php';
$voiture = getVoiture($pdo);
var_dump($voiture);


});

//Routage vers la page nav.html.twig.
/*
$router->map( 'GET', '/nav', function() {

global $twig;

$template = $twig->load('nav.html.twig');

echo $template->render(array('data' => 'nav');

});
*/

























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
