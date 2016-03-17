<?php
namespace Modules\Authentifier\Controllers;

use Core\Controller;
use Core\View;
use Core\Router;
use Helpers\Request;
use Helpers\Session;
use Modules\Feedback\Helpers\Feedback;
use Modules\Authentifier\Models\LoginModel;
use Modules\Authentifier\Models\UserModel;



class Authentifier extends Controller{

	protected $feedback;
	protected $userSQL;
	protected $userData;
	protected $account_type_required;
	public function __construct(){
		parent::__construct();
		// Initialisation d'une session
		Session::init();

		// Tester si une session 'concurrente' existe, auquel cas on deconnecte l'utilisateur
		Authentifier::checkSessionConcurrency();

		if(!isset($this->feedback))
			$this->feedback = new Feedback();

		$this->userSQL = new UserModel();

		$this->$account_type_required=0;

		// Tester si l'utilisateur est non connecté et a un cookie "Rester connecté"
		if(!Login::userLoggedIn() /* && TODO teste le cookie "Rester connecté"*/){
			// TODO renvoyer vers la route loginWithCookie
		}

		// Get user session
		if(Login::userLoggedIn()){
			$this->userData = $this->userSQL->selectProfile(Session::get('user_id'));
		}

	}
	
	public function routes(){
		Router::any('authentifier', 'Modules\Authentifier\Controllers\Authentifier@test');
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

	public function getUserStatus()
	{
		if(Login::userLoggedIn())
			return "Logged  ".$this->userData['user_name'];
		else
			return "Vous n'êtes pas connecté.";
	}

	public function getUserInfo(){
		return $this->userData;
	}

	public function checkAccountRequired(){
		if($this->account_type_required<=$this->userData['user_account_type']){
			return true;
		}
		return false;
	}

}
