<?php

namespace MallardDuck\LaravelHumanoID\Tests;

use MallardDuck\LaravelHumanoID\HumanoIDConfig;
use RobThree\HumanoID\WordFormatOption;

final class DefaultTestConfig extends HumanoIDConfig
{
    public function __construct(
    ) {
        parent::__construct(
            wordSetsFilename: 'space-words.json',
            separator: '_',
            formatOption: WordFormatOption::upper()
        );
    }
}
