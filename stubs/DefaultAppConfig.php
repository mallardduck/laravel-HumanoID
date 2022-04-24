<?php

namespace App\HumanoID;

use RobThree\HumanoID\WordFormatOption;

final class DefaultAppConfig extends \MallardDuck\LaravelHumanoID\HumanoIDConfig
{
    public function __construct(
    ) {
        parent::__construct(
            'space-words.json',
            '-',
            WordFormatOption::ucfirst()
        );
    }
}
