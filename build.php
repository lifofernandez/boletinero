<?php

//======================================================================
// Sistema de templates para el Radar
//======================================================================

$current = 'curso_posgrado-2017-09'; # Nobre para los archivos de salida...


//-----------------------------------------------------
// Importar dependencias
//-----------------------------------------------------

require_once 'vendor/autoload.php';

use Adamlc\Premailer\Command;
use Adamlc\Premailer\Email;
use Symfony\Component\Yaml\Yaml;

use Aptoma\Twig\Extension\MarkdownExtension;
use Aptoma\Twig\Extension\MarkdownEngine;

//-----------------------------------------------------
// Twig
//-----------------------------------------------------

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);




$engine = new MarkdownEngine\MichelfMarkdownEngine();

$twig->addExtension(new MarkdownExtension($engine));

/*
$twig->addExtension(new Twig_Extensions_Extension_Intl());

// Custom Filter 'slug'

$filter = new Twig_SimpleFilter('slug', function ($string) {

	$string = transliterator_transliterate("Any-Latin; NFD; [:Nonspacing Mark:]
	Remove; NFC; [:Punctuation:] Remove; Lower();", $string);
	$string = preg_replace('/[-\s]+/', '-', $string);
	$string = trim($string, '-');
	return $string;
});

$twig->addFilter($filter);
*/

// Templates
$index = $twig->loadTemplate('boletin.html.twig');


//-----------------------------------------------------
// Cargar contenidos (.json)
//-----------------------------------------------------

$inputFile = "contenidos/".$current.".yml";
$contenidosYaml = Yaml::parse(file_get_contents($inputFile));


//-----------------------------------------------------
// Render 
//-----------------------------------------------------

$outputRaw = $index->render($contenidosYaml);
echo "Construyo arbol HTML a partir de ".$inputFile."\n";
$output = $outputRaw;


//-----------------------------------------------------
// Premailer (packagist.org/packages/adamlc/premailer-cli-wrapper)
// 
//-----------------------------------------------------

if (isset($argv[1]) && ($argv[1] == 'inline' || $argv[1] == 'i')){

	// Path to Premailer Binary
	//$premailer = new Command('~/.gem/ruby/2.3.0/gems/premailer-1.8.6/bin/premailer');
	$premailer = new Command('/usr/local/bin/premailer');

	// Create a new email instance, passing the Command instance
	$email = new Email($premailer);

	// Set the body of the Email
	$email->setBody($outputRaw);

	// Get the parsed body of the email
	$mailHtml = $email->getHtml();
	$mailText = $email->getText();

	$output = $mailHtml;

	//echo "$mailText"."\n";
	echo "CSS Inline !!!\n";
}

//-----------------------------------------------------
// Escribir Archivo
//-----------------------------------------------------

$outputFile = $current.'.html';
file_put_contents($outputFile, $output);

echo "Escribo ".$outputFile."\n";


?>
