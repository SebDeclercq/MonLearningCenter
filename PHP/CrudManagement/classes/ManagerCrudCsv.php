<?php
namespace SDQ\CrudManagement;

class ManagerCrudCsv implements IManagerCrud
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
            $sLigne = implode($oSource->getSeparateur(), $aAttributs);
            if (file_exists($oSource->getNom())) {
                file_put_contents($oSource->getNom(), $sLigne.PHP_EOL, FILE_APPEND);
            }
            else {
                $entete = implode($oSource->getSeparateur(),$oSource->getAttributs());
                file_put_contents($oSource->getNom(), $entete.PHP_EOL, FILE_APPEND);
                file_put_contents($oSource->getNom(), $sLigne.PHP_EOL, FILE_APPEND);
            }
        }
    }
    public static function insereMultiple(SourceDonnees $oSource, array $aListeAttributs) {
        foreach ($aListeAttributs as $aAttributs) {
            self::insereEnregistrement($oSource, $aAttributs);
        }
    }
// R
    public static function affichetout(SourceDonnees $oSource) {
        $i = 0;
        foreach (file ($oSource->getNom()) as $sLigne) {
            if ($i != 0) {
                $aEnregistrement = self::litLigne($sLigne, $oSource->getSeparateur(), $oSource->getAttributs());
                $aTotal[$aEnregistrement[$oSource->getClefPrimaire()]] = $aEnregistrement;
            }
            $i++;
        }
        return $aTotal;
    }

    public static function chercheParClef(SourceDonnees $oSource, $clef) {
        $i = 0;
        foreach (file ($oSource->getNom()) as $sLigne) {
            if ($i != 0) {
                $aEnregistrement = self::litLigne($sLigne, $oSource->getSeparateur(), $oSource->getAttributs());
                if ($aEnregistrement[$oSource->getClefPrimaire()] == $clef) {
                    return $aEnregistrement;
                }
            }
            $i++;
        }
    }

    public static function chercheParChamps(SourceDonnees $oSource, array $aDonnees) {
        $i = 0;
        $aListeResultats = [];
        foreach (file ($oSource->getNom()) as $sLigne) {
            if ($i != 0) {
                $aEnregistrement = self::litLigne($sLigne, $oSource->getSeparateur(), $oSource->getAttributs());
                $match = 0;
                foreach ($aDonnees as $sAttribut => $sValeur) {
                    if ($aEnregistrement[$sAttribut] == $sValeur) {
                        $match++;
                    }
                }
                if ($match == count($aDonnees)) {
                    $aListeResultats[] = $aEnregistrement;
                }
            }
            $i++;
        }
        return $aListeResultats;
    }

// U
    public static function modifieEnregistrement(SourceDonnees $oSource, $clef, array $aNouveauxAttributs) {
        $i = 0;
        foreach (file ($oSource->getNom()) as $sLigne) {
            if ($i == 0) {
                $aEnregistrements[] = $sLigne;
            }
            elseif (preg_match('/^\s*$/', $sLigne)) {
                continue;
            }
            else {
                $aLigne = self::litLigne($sLigne, $oSource->getSeparateur(), $oSource->getAttributs());
                if ($aLigne[$oSource->getClefPrimaire()] != $clef) {
                    $aEnregistrements[] = $sLigne;
                }
                else {
                    if (!empty($aNouveauxAttributs)) {
                        foreach ($aNouveauxAttributs as $sAttribut=>$sValeur) {
                            if (in_array($sAttribut, $oSource->getAttributs())) {
                                $aLigne[$sAttribut] = $sValeur;
                            }
                        }
                    }
                    $aEnregistrements[] = implode($oSource->getSeparateur(), $aLigne);
                }
            }
            $i++;
        }
        file_put_contents($oSource->getNom(), $aEnregistrements);
    }
// D
    public static function supprimeTout(SourceDonnees $oSource) {
        $entete = implode($oSource->getSeparateur(),$oSource->getAttributs());
        file_put_contents($oSource->getNom(), $entete."\n");
    }

    public static function supprimeEnregistrement(SourceDonnees $oSource, $clef) {
        $i = 0;
        foreach(file ($oSource->getNom()) as $sLigne) {
            $aEnregistrement = self::litLigne($sLigne, $oSource->getSeparateur(), $oSource->getAttributs());
            if ($aEnregistrement[$oSource->getClefPrimaire()] == $clef) {
                continue;
            }
            elseif (preg_match('/^\s*$/', $sLigne)) {
                continue;
            }
            else {
                $aEnregistrements[] = $sLigne;
            }
        }
        file_put_contents($oSource->getNom(), $aEnregistrements);
    }

    public static function litAttributs(SourceDonnees $oSource) {
        if (file_exists($oSource->getNom())) {
            $ligneEntete = fgets(fopen($oSource->getNom(), 'r')); // Récupère l'entête du fichier
            $aAttributs = explode($oSource->getSeparateur(), strtolower($ligneEntete));
            return $aAttributs;
        }
        else {
            throw new \RuntimeException('Le fichier '.$oSource->getNom().' n\'existe pas');
        }
    }

    protected static function litLigne($sLigne, $sSeparateur, $aChamps) {
        if (!preg_match('/^\s*$/',$sLigne)) {
            $aValeurs = explode($sSeparateur, rtrim($sLigne));
            foreach($aChamps as $index => $sChamp) {
                $aEnregistrement[$sChamp] = $aValeurs[$index];
            }
            return $aEnregistrement;
        }
    }

}
