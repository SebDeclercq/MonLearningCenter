<?php
include_once('ICulturalProduct.php');


class ComputerFile implements ICulturalProduct
{
    private $mfgProduct;

    public function getMetadata() {
        $this->mfgProduct = 'Hello I\'m a file on your computer ! Better delete me and buy me for real !';
        return $this->mfgProduct;
    }
}