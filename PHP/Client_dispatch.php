<?php
require_once('transformation_texte.classe.php');
require_once('transformation_date.classe.php');
require_once('transformation_reference.classe.php');

// Classe permettant de "dispatcher" les fonctions a la bonne classe statique. transforme() recupere en arguments le nom de la methode a appeler, prefixee de trois lettres et un underscore (ex. "txt_") servant de nomenclature au dispatcher et les arguments a transmettre a la methode en question. Enfin, transforme() retourne le resultat de la methode appelee.
// dispatcher permet donc d'envoyer les arguments a qui de droit.
class Client
{
    public function dispatch() {
        // Recupere les arguments passes a transforme()
        $args = func_get_args();
        // Le nom de la regle est le premier argument
        $nom_regle = array_shift($args);
        // Les 3 premiers caracteres servent de nomenclature
        $nomenclature = substr($nom_regle,0,3);
        // suivi d'un underscore. Le reste est le nom de la regle
        $regle = substr($nom_regle,4);
        // Si la regle est de la famille texte
        if ($nomenclature == 'txt') {
            // passe les arguments stockes dans $args a la regle $regle de la classe statique transformation_texte et recupere le resultat
            return call_user_func_array(
                "transformation_texte::$regle",
                $args);
        }
        // Si la regle est de la famille date
        elseif ($nomenclature == 'dat') {
            // passe les arguments stockes dans $args a la regle $regle de la classe statique transformation_date et recupere le resultat
            return call_user_func_array(
                "transformation_date::$regle",
                $args);
        }
        // Si la regle est de la famille reference
        elseif ($nomenclature == 'ref') {
            // passe les arguments stockes dans $args a la regle $regle de la classe statique transformation_reference et recupere le resultat
            return call_user_func_array(
                "transformation_reference::$regle",
                $args);
        }
    }
}

$worker = new Client();
echo $worker->dispatch('txt_concatene',['123-456', '567-789'], '@').'<br/>';
echo $worker->dispatch('txt_minisculise','AZertYuIOp').'<br/>';
echo $worker->dispatch('txt_majusculise','AZertYuIOp').'<br/>';
echo $worker->dispatch('dat_regle003', 20151109);
