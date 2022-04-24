<?php

namespace MallardDuck\LaravelHumanoID;

use RobThree\HumanoID\WordFormatOption;

abstract class HumanoIDConfig
{
    public function __construct(
        public string $wordSetsFilename,
        public ?string $separator = '-',
        public ?WordFormatOption $formatOption = null
    ) {}
}
