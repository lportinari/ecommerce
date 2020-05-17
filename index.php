<?php 
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page();

	$page->setTpl("index");

});

$app->get('/admin', function() {

	//Valida se o usuário está logado
	User::verifyLogin();
    
	$page = new PageAdmin();

	$page->setTpl("index");

});

$app->get('/admin/login', function(){

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl('login');

});

//Rota para o método post para a página de login
$app->post('/admin/login', function(){

	//Validação do usuário na classe User
	User::login($_POST["login"], $_POST["password"]);

	//Redirecionando para a homepage da administração
	header("Location: /admin");
	exit;

});

//Rota para o Logout da sessão de usuário
$app->get('/admin/logout', function(){

	User::logout();

	header("Location: /admin/login");
	exit;

});

$app->run();

 ?>