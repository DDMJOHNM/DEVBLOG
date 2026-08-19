<?php

namespace App\Providers;

use App\Extensions\ProjectsExtension;
use App\Pages\MarkdownProject;
use Hyde\Foundation\HydeKernel;
use Hyde\Framework\Concerns\RegistersFileLocations;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    use RegistersFileLocations;

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->make(HydeKernel::class)->registerExtension(ProjectsExtension::class);

        $this->registerSourceDirectories([
            MarkdownProject::class => $this->getSourceDirectoryConfiguration(MarkdownProject::class, '_projects'),
        ]);

        $this->registerOutputDirectories([
            MarkdownProject::class => $this->getOutputDirectoryConfiguration(MarkdownProject::class, 'projects'),
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
