<?php

declare(strict_types=1);

namespace MallardDuck\LaravelHumanoID;

use RobThree\HumanoID\WordFormatOption;

final class DefaultGeneratorConfig extends HumanoIDConfig
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
