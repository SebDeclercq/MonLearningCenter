<?php
include_once('Creator.php');
include_once('ICulturalProduct.php');
class ConcreteCreator extends Creator
{
    private $culturalProduct;

    protected function factoryMethod(CulturalProduct $product) {
        $this->culturalProduct = $product;
        return ($this->culturalProduct->getProperties());
    }

}