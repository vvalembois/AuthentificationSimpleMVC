<?php
namespace Modules\Authentifier\Controllers;

use Core\Controller;
use Core\Router;
use Core\View;
use Helpers\Session;
use Helpers\Url;
use Modules\Authentifier\Models\LoginModel;
use Modules\Feedback\Helpers\Feedback;


class Authentifier extends Controller{

	protected $feedback;
	protected $user;
    protected $required_user_type;

	public function __construct($required_user_type = 0){
		parent::__construct();
		// Initialisation d'une session
		Session::init();

		// Tester si une session 'concurrente' existe, auquel cas on deconnecte l'utilisateur
		Authentifier::checkSessionConcurrency();

		if(!isset($this->feedback))
			$this->feedback = new Feedback();

		// Tester si l'utilisateur est non connecté et a un cookie "Rester connecté"
		if(!Login::userLoggedIn() /* && TODO teste le cookie "Rester connecté"*/){
			// TODO renvoyer vers la route loginWithCookie
		}

        // set the required user type
        $this->required_user_type = $required_user_type;

	}


	protected function setUser(){
        $user = LoginModel::findByLogin();
        if($user instanceof LoginModel && $user->checkSessionId(Session::id()))
		    $this->user = $user;
	}
	
	public function routes(){
		Router::any('authentifier', 'Modules\Authentifier\Controllers\Authentifier@test');
	}

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


    /**
     * You need to use this function on the begin of your controller method which required a certain account type
     * You can initialise a default required account type with the constructor parameter $required_user_type or use a new with this method param
     * @param int|false $required_user_type the required user type for have right to continue
     * @return bool true if the users have required right, else false
     */
    protected function checkAccountTypeRequired($required_user_type = false){
        if(!$required_user_type)
            $required_user_type = $this->required_user_type;
        $this->setUser();
        if($required_user_type <= 0 || ($this->user instanceof LoginModel && $this->user->getUserAccountType() >= $required_user_type))
            return true;
        $this->feedback->add('You can\'t visit this part of the site without the good right level', FEEDBACK_TYPE_FAIL);
        Url::previous();
        return false;
    }

    protected function render($path, $data = false, $error = false){
        $this->checkAccountTypeRequired();
        View::render($path, $data = false, $error = false);
    }

    protected function renderModule($path, $data = false, $error = false){
        $this->checkAccountTypeRequired();
        View::renderModule($path, $data = false, $error = false);
    }

    protected function renderTemplate($path, $data = false, $error = false){
        $this->checkAccountTypeRequired();
        View::renderTemplate($path, $data = false, $error = false);
    }

}
