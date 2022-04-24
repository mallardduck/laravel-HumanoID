<?php

namespace MallardDuck\LaravelHumanoID;

use Closure;
use Illuminate\Config\Repository as Config;
use Illuminate\Support\Facades\File;
use RobThree\HumanoID\HumanoID;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Yaml;

class LaravelHumanoID
{
    private string $wordSetsBasePath;
    /**
     * @var class-string<HumanoIDConfig>
     */
    private string $configClass;

    /**
     * @param Closure(): Config $configResolver
     */
    public function __construct(
        Closure $configResolver
    ) {
        /**
         * @var Config $config
         */
        $config = $configResolver();
        $this->wordSetsBasePath = rtrim($config->get('humanoid.wordSetsBasePath', resource_path('humanoid/')));
        $this->configClass = $config->get('humanoid.defaultGeneratorConfig', DefaultGeneratorConfig::class);
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
        $fullPath = realpath($this->wordSetsBasePath . DIRECTORY_SEPARATOR . $wordSetsFilename);
        if ($fullPath === false) {
            throw new \RuntimeException(
                sprintf(
                    'Provided WordSets file does not exist at path `%s`.',
                    $this->wordSetsBasePath . DIRECTORY_SEPARATOR . $wordSetsFilename
                )
            );
        }
        $contents = File::get($fullPath);
        if ($fileExt === 'json') {
            return json_decode($contents, true);
        }

        return Yaml::parse($contents);
    }

    public function getDefaultGenerator(): HumanoID
    {
        if (! $this->hasWordSetsFolder()) {
            throw new \RuntimeException('The application is missing the wordsets folder, publish the `humanoid` resources first.');
        }

        $config = $this->getDefaultGeneratorConfig();
        $wordSets = $this->loadWordSets($config->wordSetsFilename);

        return new HumanoID(
            wordSets: $wordSets,
            separator: $config->separator,
            format: $config->formatOption
        );
    }
}
