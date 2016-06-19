<?php

//======================================================================
// Sistema de templates para el Radar
//======================================================================


//-----------------------------------------------------
// Importar librerias
//-----------------------------------------------------

// composer require twig/twig:~1.0
// composer require twig/extensions
require_once 'vendor/autoload.php';


/*
* Esto va si se isntala de a mano
* require_once '../vendor/Twig-1.24.0/lib/Twig/Autoloader.php';
* Twig_Autoloader::register();
*/



//-----------------------------------------------------
// Twig
//-----------------------------------------------------

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);
//$twig->addExtension(new Twig_Extensions_Extension_Intl());

// // Custom Filter 'slug'
// $filter = new Twig_SimpleFilter('slug', function ($string) {
// 	// $string = transliterator_transliterate("Any-Latin; NFD; [:Nonspacing Mark:]
// 	// Remove; NFC; [:Punctuation:] Remove; Lower();", $string);
// 	// $string = preg_replace('/[-\s]+/', '-', $string);
// 	// $string = trim($string, '-');
// 	// return $string;
// });
// $twig->addFilter($filter);

// Templates
$index = $twig->loadTemplate('boletin.html.twig');



//-----------------------------------------------------
// Cargar Feeds .json
//-----------------------------------------------------

$current = 'boletin_2016-06';

$contenidosJson = file_get_contents("contenidos/".$current.".json");
$contenidos = json_decode($contenidosJson,true); // 'true' devuelve  array



//-----------------------------------------------------
// Render
//-----------------------------------------------------

$output = $index->render($contenidos);

$file = $current.'.html';
file_put_contents($file, $output);



?>