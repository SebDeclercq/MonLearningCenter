<?php
namespace SDQ\CrudManagement;

class ManagerCrudPerinorm implements IManagerCrud
{
    private function __construct() {} // Empêche l'instanciation de la "classe statique"
// C
    public static function insereEnregistrement(SourceDonnees $oSource, array $aAttributs) {
        $match = 0;
        foreach ($aAttributs as $sAttribut => $sValeur) {
            if (in_array($sAttribut, $oSource->getAttributs())) {
                $match++;
            }
        }
        $listeAttrs = implode(', ', $oSource->getAttributs());
        if ($match != count($oSource->getAttributs())) {
            throw new \InvalidArgumentException('Attribut(s) manquant(s). Attributs à insérer : '.$listeAttrs);
        }
        else {
            $aEnregistrements = self::litFichier($oSource);
            $aEnregistrements[] = $aAttributs;
            self::ecritFichier($oSource, $aEnregistrements);
        }
    }
    public static function insereMultiple(SourceDonnees $oSource, array $aListeAttributs) {
        foreach ($aListeAttributs as $aAttributs) {
            self::insereEnregistrement($oSource, $aAttributs);
        }
    }
// R
    public static function affichetout(SourceDonnees $oSource) {
        return self::litFichier($oSource);
    }

    public static function chercheParClef(SourceDonnees $oSource, $clef) {
        $aEnregistrements = self::litFichier($oSource);
        foreach ($aEnregistrements as $aEnregistrement) {
            if ($aEnregistrement[$oSource->getClefPrimaire()] == $clef) {
                return $aEnregistrement;
            }
        }
    }

    public static function chercheParChamps(SourceDonnees $oSource, array $aDonnees) {
        $aEnregistrements = [];
        $aLignes = self::litFichier($oSource);
        foreach ($aLignes as $aLigne) {
            $match = 0;
            foreach ($aDonnees as $sAttribut => $sValeur) {
                if ($aLigne[$sAttribut] == $sValeur) {
                    $match++;
                }
            }
            if ($match == count($aDonnees)) {
                $aEnregistrements[] = $aLigne;
            }
        }
    return $aEnregistrements;
    }

// U
    public static function modifieEnregistrement(SourceDonnees $oSource, $clef, array $aNouveauxAttributs) {
        $aLignes = self::litFichier($oSource);
        foreach ($aLignes as $aLigne) {
            if ($aLigne[$oSource->getClefPrimaire()] != $clef) {
                $aEnregistrements[] = $aLigne;
            }
            else {
                if (!empty($aNouveauxAttributs)) {
                    foreach ($aNouveauxAttributs as $sAttribut=>$sValeur) {
                        if (in_array($sAttribut, $oSource->getAttributs())) {
                            $aLigne[$sAttribut] = $sValeur;
                        }
                    }
                }
                $aEnregistrements[] = $aLigne;
            }
        }
        self::ecritFichier($oSource, $aEnregistrements);
    }
// D
    public static function supprimeEnregistrement(SourceDonnees $oSource, $clef) {
        $aLignes = self::litFichier($oSource);
        foreach ($aLignes as $aLigne) {
            if ($aLigne[$oSource->getClefPrimaire()] != $clef) {
                $aEnregistrements[] = $aLigne;
            }
            else {
                continue;
            }
        }
        self::ecritFichier($oSource, $aEnregistrements);
    }

    public static function supprimeTout(SourceDonnees $oSource) {
        $aLignes = [];
        file_put_contents($oSource->getNom(), $aLignes);
    }



    protected static function litFichier(SourceDonnees $oSource) {
        if (file_exists($oSource->getNom())) {
            $fichier = file_get_contents($oSource->getNom());
        }
        else {
            throw new \InvalidArgumentException ('Le fichier '.$oSource->getNom().'n\'existe pas');
        }

        $aLignes = explode($oSource->getSeparateurEnregistrement(), $fichier);
        foreach ($aLignes as $sLigne) {
            if (!preg_match('/^\s*$/',$sLigne)) {
                $aValeurs = explode($oSource->getSeparateur(), rtrim($sLigne));
                foreach($oSource->getAttributs() as $index => $sChamp) {
                    $sValeur = preg_replace('/(?>[^=]+=)/','',$aValeurs[$index]);
                    $aEnregistrement[$sChamp] = $sValeur;
                }
                $aEnregistrements[] = $aEnregistrement;
            }
        }
        return $aEnregistrements;
    }

    protected static function ecritFichier(SourceDonnees $oSource, $aEnregistrements) {
        foreach ($aEnregistrements as $aEnregistrement) {
            $sEnregistrement = '';
            foreach ($aEnregistrement as $sAttribut => $sValeur) {
                $sEnregistrement .= $sAttribut.'='.$sValeur.$oSource->getSeparateur();
            }
            $sEnregistrement = rtrim($sEnregistrement, $oSource->getSeparateur());
            $aSortie[] = $sEnregistrement;
        }
        $sSortie = implode($oSource->getSeparateurEnregistrement(), $aSortie);
        file_put_contents($oSource->getNom(), $sSortie.PHP_EOL);
    }

}
