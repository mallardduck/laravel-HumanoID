<?php

namespace MallardDuck\LaravelHumanoID\Tests;

use RobThree\HumanoID\WordFormatOption;

class DefaultTestConfig extends \MallardDuck\LaravelHumanoID\HumanoIDConfig
{
    public function __construct(
    ) {
        parent::__construct(
            'space-words.json',
            '_',
            WordFormatOption::upper()
        );
    }
}
