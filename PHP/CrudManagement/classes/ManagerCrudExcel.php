<?php
namespace SDQ\CrudManagement;
require_once('PHPExcel/IOFactory.php');

class ManagerCrudExcel implements IManagerCrud
{
// C
    public static function insereEnregistrement(SourceDonnees $oSource, array $aAttributs) {
        try
        {
            $aLignes = self::litFichier($oSource);
        }
        catch(\Exception $e)
        {
            //  echo $e->getMessage()."\n";
            $aLignes = [];
        }
        $idx = count($aLignes)+1;
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
            foreach ($oSource->getAttributs() as $sNomChamp) {
                $aLignes[$idx][$sNomChamp] = $aAttributs[$sNomChamp];
            }
        }
        self::ecritFichier($oSource, $aLignes);
    }

// R
    public static function afficheTout(SourceDonnees $oSource) {
        return self::litFichier($oSource);
    }
    public static function chercheParClef(SourceDonnees $oSource, $clef) {
        $aLignes = self::litFichier($oSource);
        foreach ($aLignes as $aLigne) {
            if ($aLigne[$oSource->getClefPrimaire()] == $clef) {
                return $aLigne;
            }
        }
    }
    public static function chercheParChamps(SourceDonnees $oSource, array $aDonnees) {
        $aEnregistrements = [];
        $aLignes = self::litFichier($oSource);
        foreach ($aLignes as $idx => $aLigne) {
            if ($idx != 0) {
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
        }
        return $aEnregistrements;
    }

// U
    public static function modifieEnregistrement(SourceDonnees $oSource, $clef, array $aNouveauxAttributs) {
        $aLignes = self::litFichier($oSource);
        foreach ($aLignes as $idx => $aLigne) {
            if ($idx == 0) {
                $aEnregistrements[] = $aLigne;
            }
            else {
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
        }
        self::ecritFichier($oSource, $aEnregistrements);
    }

// D
    public static function supprimeEnregistrement(SourceDonnees $oSource, $clef) {
        $aLignes = self::litFichier($oSource);
        foreach ($aLignes as $aLigne) {
            if ($aLigne[$oSource->getClefPrimaire()] == $clef) {
                continue;
            }
            else {
                $aEnregistrements[] = $aLigne;
            }
        }
        self::ecritFichier($oSource, $aEnregistrements);
    }

    public static function supprimeTout(SourceDonnees $oSource) {
        $aLignes = [];
        self::ecritFichier($oSource, $aLignes);
    }




    protected static function litFichier(SourceDonnees $oSource) {
        $oPhpExcel = \PHPExcel_IOFactory::load($oSource->getNom());
        // Crée un array multidimensionnel avec un premier niveau ligne par ligne
        // et un secon cellule par cellule
        $i = 0;
        foreach ($oPhpExcel->getSheet(0)->getRowIterator() as $ligne) {
            if ($i != 0) {
                $aLignes[$i] = [];
                foreach ($ligne->getCellIterator() as $cellule) {
                    $aLignes[$i][] = $cellule->getValue();
                }
                // Effectue la transposition d'un array à un array associatif
                foreach ($oSource->getAttributs() as $idx => $sAttribut) {
                    $aLignes[$i][$sAttribut] = $aLignes[$i][$idx];
                    unset($aLignes[$i][$idx]);
                }
            }
            $i++;
        }
        return $aLignes;
    }
    protected static function ecritFichier(SourceDonnees $oSource, $aLignes) {
        $oPhpExcel = new \PHPExcel;
        $oPhpExcel->setActiveSheetIndex(0);
        // $oPhpExcel->getActiveSheet()->SetCellValue('CASE','VALEUR');
        $lettre = 'A';
        $chiffre = 1;
        foreach ($oSource->getAttributs() as $sAttribut) {
            $oPhpExcel->getActiveSheet()->SetCellValue($lettre.$chiffre, $sAttribut);
            $lettre++;
        }
        if (!empty($aLignes)) {
            $chiffre = 2;
            foreach ($aLignes as $aLigne) {
                $lettre = 'A';
                foreach ($aLigne as $idx => $sValeur) {
                    $oPhpExcel->getActiveSheet()->SetCellValue($lettre.$chiffre, $sValeur);
                    $lettre++;
                }
                $chiffre++;
            }
        }
        $oWriterExcel = new \PHPExcel_Writer_Excel2007($oPhpExcel);
        $oWriterExcel->save($oSource->getNom());
    }
}
