<?php
/**
 * Routes - all standard routes are defined here.
 *
 * @author David Carr - dave@daveismyname.com
 * @version 2.2
 * @date updated Sept 19, 2015
 */

/** Create alias for Router. */
use Core\Router;
use Helpers\Hooks;

/** Define routes. */
Router::any('test1', 'Controllers\Welcome@index');
Router::any('test', 'Controllers\Welcome@test');

/** Route pour Afficher liste*/
Router::any('', 'Controllers\Article@articlesList');
Router::any('articles_list', 'Controllers\Article@articlesList');

/** Route pour un article*/
Router::any('article_details', 'Controllers\Article@articleDetails');

/** Route pour creation*/
Router::any('article_creation_form', 'Controllers\Article@creationForm');
Router::post('article_creation_action', 'Controllers\Article@creationAction');


/** Route pour modif*/
Router::any('article_update_form', 'Controllers\Article@updateForm');
Router::post('update_action', 'Controllers\Article@updateAction');

/** Route pour delete*/
Router::any('article_delete', 'Controllers\Article@delete');




/** Module routes. */
$hooks = Hooks::get();
$hooks->run('routes');

/** If no route found. */
Router::error('Core\Error@index');

/** Turn on old style routing. */
Router::$fallback = false;

/** Execute matched routes. */
Router::dispatch();
