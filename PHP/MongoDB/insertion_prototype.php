<?php
// Classe prototype pour l'alimentation de MongoDB (pour test)

interface IPrototype
{
    public function __clone();
}

class Csv implements IPrototype
{
    public static $total = 0;
    public $nom;
    public $sep = ";";
    public $crdate;
    public $lignes;

    public function __construct($nom) {
        $this->nom = $nom;
        $this->crdate = date('H:i:s');
        $this->contactRoot = new Contact;
        self::$total++;
    }
    public function __clone() {
        $this->crdate = date('H:i:s');
        for ($i=0; $i < 20; $i++) {
          $this->lignes[] = clone $this->contactRoot;
        }
        self::$total++;
    }
}

class Contact implements IPrototype
{
  public $nom;
  public $prenom;
  public $email;
  public $dob;
  public $ville;
  public $code_postal;

  public function __construct() {
    $this->nom = "Dupond";
    $this->prenom = "André";
    $this->email = "andre_dupond@gmail.com";
    $this->age = 15;
    $this->dob = null;
    $this->ville = null;
    $this->code_postal = null;
  }

  public function __clone() {
    $random = rand(60,2);
    if ($random <= 15) {
      $this->nom = "Martin";
      if ($random / 2 >= 5) {
        $this->prenom = "Arnaud";
        $this->dob = "01012011";
      }
      else {
        $this->prenom = "Agnès";
      }
      $this->ville = "Lille";
      $this->code_postal = "59000";
    }
    elseif ($random <= 45) {
      if ($random  / 2 >= 30)  {
        $this->nom = "Duran";
        $this->prenom = ["Jean","Paul","Gauthier"];
      }
      else {
        $this->nom = null;
        $this->prenom = "E.T.";
        $this->tel = "maison";
      }
    }
    $this->email = $this->nom.$random.'@gmail.com';
    $this->age = $random;
  }
}

$mongodb = new MongoClient();
$c = $mongodb->test->doc;

$csvRoot = new Csv('mes_contacts.csv');
echo date('H:i:s');
echo "<br/>";
for ($i = 0; $i < 10000; $i++) {
    $nom = 'annuaire'.$i.'.csv';
    $clone = clone $csvRoot;
    $clone->nom = $nom;
    $c->insert($clone);
}

echo Csv::$total;
echo "<br/>";
echo date('H:i:s');
