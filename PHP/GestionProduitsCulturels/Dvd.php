<?php
include_once('ICulturalProduct.php');


class Dvd implements ICulturalProduct
{
    private $mfgProduct;

    public function getMetadata() {
        $this->mfgProduct = 'Hello I\'m a dvd :-)';
        return $this->mfgProduct;
    }
}