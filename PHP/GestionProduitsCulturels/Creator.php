<?php
abstract class Creator 
{
    protected abstract function factoryMethod(CulturalProduct $product);

    public function startFactory($initProduct) {
        $culturalProduct = $initProduct;
        $mfg = $this->factoryMethod($culturalProduct);
        return $mfg;
    }
}
