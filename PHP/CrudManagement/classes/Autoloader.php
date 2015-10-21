<?php
namespace SDQ\CrudManagement;

class Autoloader
{
    /**
    * Méthode qui permet l'autoloading de la classe Autoload
    *
    * Cette méthode fait appel à la SPL afin de charger facilement la classe Autoload avec Autoload::register()
    */
    public static function register() {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
    * Méthode d'autoloading
    *
    * @param "string" "classe" Le nom de la classe à charger
    */
    public static function autoload($classe) {
        if (strpos($classe, __NAMESPACE__.'\\') === 0) {
            $classe = str_replace(__NAMESPACE__.'\\', '', $classe);
            require_once($classe.'.php');
        }
    }
}
