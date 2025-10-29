<?php

class SimpleFruitListComponent extends \CBitrixComponent
{
    public function executeComponent()
    {
        $this->arResult = [
            [
                'img' => '/img/apple.png',
                'name' => 'Яблоко',
            ],
            [
                'img' => '/img/apple.png',
                'name' => 'Банан',
            ],
            [
                'img' => '/img/apple.png',
                'name' => 'Апельсин',
            ],
        ];

        $this->IncludeComponentTemplate();
    }
}
