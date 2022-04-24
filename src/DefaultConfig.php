<?php

namespace MallardDuck\LaravelHumanoID;

use RobThree\HumanoID\WordFormatOption;

final class DefaultConfig extends \MallardDuck\LaravelHumanoID\HumanoIDConfig
{
    public function __construct(
    ) {
        parent::__construct(
            wordSetsFilename: 'space-words.json',
            separator: '-',
            formatOption: WordFormatOption::ucfirst()
        );
    }
}
