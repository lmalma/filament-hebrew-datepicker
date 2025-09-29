<?php

namespace EliSheinfeld\HebrewDatePicker;

use EliSheinfeld\HebrewDatePicker\Commands\HebrewDatePickerCommand;
use EliSheinfeld\HebrewDatePicker\Testing\TestsHebrewDatePicker;
use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HebrewDatePickerServiceProvider extends PackageServiceProvider
{
    public static string $name = 'hebrew-date-picker';

    public static string $viewNamespace = 'hebrew-date-picker';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('eli-sheinfeld/hebrew-date-picker');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Publish Assets
        $this->publishes([
            __DIR__ . '/../resources/js' => public_path('js/hebrew-date-picker'),
        ], 'hebrew-date-picker-assets');

        $this->publishes([
            __DIR__ . '/../resources/css' => public_path('css/hebrew-date-picker'),
        ], 'hebrew-date-picker-assets');

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/hebrew-date-picker/{$file->getFilename()}"),
                ], 'hebrew-date-picker-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsHebrewDatePicker);
    }

    protected function getAssetPackageName(): ?string
    {
        return 'hebrew-date-picker';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            AlpineComponent::make('hebrew-date-picker', __DIR__ . '/../resources/js/hebrew-date-picker.js')
                ->loadedOnRequest(),
            Css::make('hebrew-date-picker-styles', __DIR__ . '/../resources/css/index.css')
                ->loadedOnRequest(),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            HebrewDatePickerCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_hebrew-date-picker_table',
        ];
    }
}
