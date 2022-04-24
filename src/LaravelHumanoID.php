<?php

namespace MallardDuck\LaravelHumanoID;

use Illuminate\Support\Facades\File;
use RobThree\HumanoID\HumanoID;
use Symfony\Component\Finder\SplFileInfo;

class LaravelHumanoID
{
    public static ?HumanoID $defaultInstance = null;

    /**
     * @param string $wordSetsBasePath
     * @param class-string<HumanoIDConfig> $configClass
     */
    public function __construct(
        private string $wordSetsBasePath,
        private string $configClass = DefaultConfig::class,
    ) {
    }

    public function hasWordSetsFolder(): bool
    {
        return File::exists($this->wordSetsBasePath);
    }

    public function hasWordSets(): bool
    {
        $files = collect(File::files($this->wordSetsBasePath))
            ->filter(static function (SplFileInfo $fileInfo) {
                return str_ends_with($fileInfo->getFilename(), '.yml') ||
                    str_ends_with($fileInfo->getFilename(), '.yaml') ||
                    str_ends_with($fileInfo->getFilename(), '.json');
            })->values();

        return $files->count() >= 1;
    }

    public function getDefaultGeneratorConfig(): HumanoIDConfig
    {
        return new ($this->configClass)();
    }

    private function loadWordSets(string $wordSetsFilename): array
    {
        $fileExt = pathinfo($wordSetsFilename, PATHINFO_EXTENSION);
        if (! in_array($fileExt, ['yml', 'yaml', 'json'])) {
            throw new \RuntimeException('WordSets file should be a valid YML or JSON file.');
        }
        $isJson = $fileExt === 'json' ? true : false;
        if (! $isJson && ! static::hasYamlLibrary()) {
            throw new \RuntimeException('Attempting to use YAML based wordset file but missing PHP YAML extension.');
        }
        $fullPath = $this->wordSetsBasePath . DIRECTORY_SEPARATOR . $wordSetsFilename;
        if (File::exists($fullPath) === false) {
            throw new \RuntimeException(
                sprintf(
                    'Provided WordSets file does not exist at path `%s`.',
                    $fullPath
                )
            );
        }
        $contents = File::get($fullPath);
        if ($isJson) {
            return json_decode($contents, true);
        }

        return yaml_parse($contents);
    }

    public function getDefaultGenerator(): HumanoID
    {
        if (static::$defaultInstance === null) {
            $config = $this->getDefaultGeneratorConfig();
            $wordSets = $this->loadWordSets($config->wordSetsFilename);
            static::$defaultInstance = new HumanoID(
                wordSets: $wordSets,
                separator: $config->separator,
                format: $config->formatOption
            );
        }

        return static::$defaultInstance;
    }

    private static function hasYamlLibrary(): bool
    {
        return function_exists('yaml_parse') && function_exists('yaml_parse_file');
    }
}
