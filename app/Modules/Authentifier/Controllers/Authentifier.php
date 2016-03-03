<?php
namespace Modules\Authentifier\Controllers;

use Core\Controller;
use Core\View;
use Core\Router;
use Helpers\Request;
use Helpers\Session;
use Modules\Authentifier\Models\LoginModel;

class Authentifier extends Controller{
	public function __construct(){
		parent::__construct();
		// Initialisation d'une session
		Session::init();

		// Tester si une session 'concurrente' existe, auquel cas on deconnecte l'utilisateur
		Authentifier::checkSessionConcurrency();

		// Tester si l'utilisateur est non connecté et a un cookie "Rester connecté"
		if(!LoginModel::userIsLoggedIn() /* && TODO teste le cookie "Rester connecté"*/){
			// TODO renvoyer vers la route loginWithCookie
		}

	}
	
	public function routes(){
		Router::any('authentifier', 'Modules\Authentifier\Controllers\Authentifier@posts');
	}

	/* TODO il doit être possible de mettre les fonctions utiles ci-dessous dans un helper interne au module*/

	private static function checkSessionConcurrency(){
		// TODO tester dans la base de donnée l'id de session de l'utilisateur
	}



	/**
	 * Retourne la valeur d'un champ souhaité d'un cookie
	 * @param mixed $key La clé du champ souhaité
	 * @return mixed La valeur du champ souhaité ou rien (si inexistant)
	 */
	public static function cookie($key)
	{
		if (isset($_COOKIE[$key]))
			return $_COOKIE[$key];
        return null;
	}
}
