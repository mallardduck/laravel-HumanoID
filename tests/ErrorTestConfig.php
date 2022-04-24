<?php

namespace MallardDuck\LaravelHumanoID\Tests;

use RobThree\HumanoID\WordFormatOption;

class ErrorTestConfig extends \MallardDuck\LaravelHumanoID\HumanoIDConfig
{
    public function __construct(
    ) {
        parent::__construct(
            'sparce-forwards.yml',
            '+',
            WordFormatOption::lcfirst()
        );
    }
}
