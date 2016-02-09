# Module d'authentification Simple MVC


## Introduction

Dans le cadre du 4<sup>ème</sup> semestre de DUT Informatique, nous avons comme projet de réaliser un module d'authentification pour le framework [Simple MVC Framework](http://simplemvcframework.com/php-framework).

Nous prendrons l'exemple du module d'authentification [panique/huge](https://github.com/panique/huge).

Ce projet implique l'utilisation et l'élargissement, notamment des connaissances :
* en PHP
* en MVC
* du framework [Simple MVC Framework](http://simplemvcframework.com/php-framework)
* en base de données (MySQL)

Une analyse du fonctionnement du module d'authentification du framework [panique/huge](https://github.com/panique/huge) nous permettra de comprendre celui-ci et ainsi de concevoir notre propre module d'authentification pour le framework [Simple MVC Framework](http://simplemvcframework.com/php-framework).

L'objectif de ce projet est d'obtenir un module d'authentification moderne et un minimum sécurisé, n'impliquant pas de modification majeure de [Simple MVC Framework](http://simplemvcframework.com/php-framework).

___
## Tâches à effectuer
 * [Liste des tâches à effectuer](TODO)

___
## Analyse
 * [Création d'un module Simple MVC Framework (+ vidéo)](moduleSMVCF)
 * [Analyse de panique/huge : Le module qui nous sert d'exemple](panique/huge)
     * [Les contrôleurs(À corriger!!!)](panique/huge/controller)
     * [Les helpers](panique/huge/helpers)
     * [Base de données](panique/huge/database)

___
## Conception
 * [Général](conception/general)
 * [Les contrôleurs](conception/controller) (vide)
 * [La base de données](conception/database) (vide)
 * [Le paramètrage](conception/paramètrage) (vide)

___
## Sécurité
Toute les recommandations ci-dessous seront obligatoirement implémenté :
 * [Jetons CSRF](token)
 * [Failles XSS](security/xss)
 * [(Bruteforce)Délai echec connexion](security/delaybruteforce)
 * [(Bruteforce)Captcha](security/captchabruteforce)

Des informations sur ce qu'il y a de plus courant, et que l'on peut éviter à notre portée:
 * [WikiHow : Comment créer un script de connexion sécurisée avec PHP et MySQL](http://fr.wikihow.com/cr%C3%A9er-un-script-de-connexion-s%C3%A9curis%C3%A9e-avec-PHP-et-MySQL)


___
## Contacts
 * [Contacts](contact)

____
## Liens
 * [Simple MVC Framework](http://simplemvcframework.com/php-framework)
 * [panique/huge](https://github.com/panique/huge)
 * [Forge](https://forge.univ-artois.fr/alexandre_deloffre/authentificationSimpleMVC)
 * [Groupe Facebook](https://www.facebook.com/groups/SMVCauthentification/)
 * [Sujet](http://www.lgi2a.univ-artois.fr/mediawiki/enseignement/index.php/IUT_de_Lens_:_Projets_tutor%C3%A9s_2015-2016#Projet_1_:_Authentification_.26_Simple-MVC)
 * [Utilisation de Docker(Fred Hemery)](utilisation-de-docker)

____