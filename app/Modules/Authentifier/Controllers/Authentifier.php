<?php
namespace Modules\Authentifier\Controllers;

use Core\Controller;
use Core\View;
use Core\Router;

class Authentifier extends Controller{
	public function __construct(){
		parent::__construct();
	}
	
	public function routes(){
		Router::any('authentifier', 'Modules\Authentifier\Controllers\Authentifier@posts');
	}

	public function posts(){
		echo 'authentifier fonctionne';
	}
}
