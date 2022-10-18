<?php

declare(strict_types=1);

namespace MallardDuck\LaravelHumanoID;

use Closure;
use Composer\InstalledVersions;
use Illuminate\Config\Repository as Config;
use Illuminate\Support\Facades\File;
use RobThree\HumanoID\HumanoID;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Yaml;

class HumanoIDManager
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
        $this->wordSetsBasePath = $config->get('wordSetsBasePath', resource_path('humanoid'));
        $this->configClass = static::resolveDefaultGeneratorClassName($config);
    }

    /**
     * Provided with the Apps config repo this will determine the default generator config class name.
     *
     * @param Config $appConfig
     *
     * @return string
     */
    public static function resolveDefaultGeneratorClassName(Config $appConfig): string
    {
        $generatorConfig = DefaultGeneratorConfig::class;
        if ($appConfig->has('defaultGeneratorConfig')) {
            $potentialConfig = $appConfig->get('defaultGeneratorConfig');
            $potentialConfig = class_exists($potentialConfig) ?
                $potentialConfig :
                $appConfig->get('namespace', '\\App') .  '\\HumanoID\\' . trim($generatorConfig);
        } else {
            $potentialConfig = $appConfig->get('namespace', '\\App') .  '\\HumanoID\\MyAppConfig';
        }
        if (class_exists($potentialConfig)) {
            $generatorConfig = $potentialConfig;
        }

        return $generatorConfig;
    }

    public function hasWordSetsFolder(): bool
    {
        return File::exists($this->wordSetsBasePath);
    }

    public function hasWordSets(): bool
    {
        $files = collect(File::files($this->wordSetsBasePath))
            ->filter(static function (SplFileInfo $fileInfo) {
                return in_array(pathinfo($fileInfo->getFilename(), PATHINFO_EXTENSION), [
                    'yaml',
                    'yml',
                    'json',
                ]);
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

    public static function getHumanoIDVendorPath(): string
    {
        static $vendorPath;
        if (! isset($vendorPath)) {
            $vendorPath = realpath(InstalledVersions::getInstallPath('robthree/humanoid'));
        }

        return $vendorPath;
    }
}
