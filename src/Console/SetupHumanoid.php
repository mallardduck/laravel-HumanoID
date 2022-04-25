<?php

namespace MallardDuck\LaravelHumanoID\Console;

use Illuminate\Config\Repository;
use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use MallardDuck\LaravelHumanoID\DefaultGeneratorConfig;
use MallardDuck\LaravelHumanoID\HumanoIDManager;

class SetupHumanoid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'humanoid:setup {--D|default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the HumanoID integration package.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $defaultSetup = $this->option('default', false);
        $humanoidResourceDir = resource_path('humanoid');

        // Should run thru the default setup and return...
        if ($defaultSetup) {
            if ($this->isAlreadyFullySetup()) {
                $this->warn("HumanoID setup has detected an existing configuration. Bailing out to prevent breaking things.");
                $this->info("After you've setup HumanoID the first time you should manage the files manually.");

                return self::FAILURE;
            }

            if ($this->isAlreadyPartialSetup()) {
                $this->info("HumanoID setup has detected some prior configs, however it doesn't appear fully configured.");
                $this->warn("Proceeding here will overwrite existing configs and may change HumanoID results");
                if (!$this->confirm("Continue?")) {
                    $this->warn("Seems SUS, bailing..");
                    return self::FAILURE;
                }
            } else {
                $this->info("HumanoID setup has not detected no prior configs - Clean Install");
            }

            // Asks no other prompts - just sets things up per my idea of default...
            // 1. Publish HumanoID word data,
            // 2. Copy stub class in place and correct namespace as needed,
            // 3. Ensure config file is in-place and has values to match defaults.

            return;
        }

        // Asks questions to collect user input, then:
        // 1. Publish HumanoID word data (or at very least create folder),
        // 2. Determine if Stub config class is needed or not,
        //   2.a. Ensure that the user provided config exists,
        //   2.b. Copy stub class in place and correct namespace as needed,
        // 3. Ensure config file is in-place and has values to match provided input.

        return;
    }

    /**
     * For an App's integratoin to be considered "fully configured" it must
     * conform to a few simple best-practices to prevent breakages.
     * These are:
     * - published the word data or provided their own to use,
     * - have the config file created and in their repo,
     * - are NOT using the default GeneratorConfig instance.
     *
     * @return bool
     */
    private function isAlreadyFullySetup(): bool{
        $configuredGeneratorName = HumanoIDManager::resolveDefaultGeneratorClassName(new Repository(config('humanoid')));
        if (
            is_dir(resource_path('humanoid')) // HumanoID resource DIR exists
            && is_file(config_path('humanoid.php')) // the app's config file exists
            && $configuredGeneratorName !== DefaultGeneratorConfig::class // The configured generator isn't the default one.
        ) {
            // TODO: consider checking if the provided generator config's wordset file exists?
            return true;
        }

        return false;
    }

    private function isAlreadyPartialSetup(): bool{
        $configuredGeneratorName = HumanoIDManager::resolveDefaultGeneratorClassName(new Repository(config('humanoid')));
        if (
            is_dir(resource_path('humanoid')) // HumanoID resource DIR exists
            || is_file(config_path('humanoid.php')) // the app's config file exists
            || $configuredGeneratorName !== DefaultGeneratorConfig::class // The configured generator isn't the default one.
        ) {
            // TODO: consider checking if the provided generator config's wordset file exists?
            return true;
        }

        return false;
    }
}
