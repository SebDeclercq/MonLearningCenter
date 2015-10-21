<?php
include_once('ConcreteCreator.php');
include_once('Book.php');
include_once('Dvd.php');
include_once('ComputerFile.php');

class Client
{
    private $culturalProducts;

    public function __construct() {
        $this->culturalProducts[] = new Book();
        $this->culturalProducts[] = new Dvd();
        $this->culturalProducts[] = new ComputerFile();        
    }

    public function getCulturalProducts () {
        return $this->culturalProducts;
    }

}


