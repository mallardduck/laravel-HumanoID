<?php

namespace MallardDuck\LaravelHumanoID\Tests;

use RobThree\HumanoID\WordFormatOption;

class ErrorTestConfig extends \MallardDuck\LaravelHumanoID\HumanoIDConfig
{
    public function __construct(
    ) {
        parent::__construct(
            'space-words.yml',
            '_',
            WordFormatOption::ucfirst()
        );
    }
}
