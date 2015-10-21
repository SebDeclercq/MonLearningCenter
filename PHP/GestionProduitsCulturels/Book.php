<?php
include_once('ICulturalProduct.php');


class Book implements ICulturalProduct
{
    private $mfgProduct;

    public function getMetadata() {
        $this->mfgProduct = 'Hello I\'m a book :-)';
        return $this->mfgProduct;
    }
}