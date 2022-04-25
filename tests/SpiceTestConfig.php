<?php

namespace MallardDuck\LaravelHumanoID\Tests;

use MallardDuck\LaravelHumanoID\HumanoIDConfig;
use RobThree\HumanoID\WordFormatOption;

final class SpiceTestConfig extends HumanoIDConfig
{
    public function __construct(
    ) {
        parent::__construct(
            wordSetsFilename: 'spice-words.yaml',
            separator: '|',
            formatOption: WordFormatOption::lower()
        );
    }
}
