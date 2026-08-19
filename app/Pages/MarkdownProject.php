<?php

declare(strict_types=1);

namespace App\Pages;

use Hyde\Foundation\Kernel\PageCollection;
use Hyde\Pages\Concerns\BaseMarkdownPage;

/**
 * Markdown project write-ups live in `_projects` and compile to `_site/projects`.
 */
class MarkdownProject extends BaseMarkdownPage
{
    public static string $sourceDirectory = '_projects';

    public static string $outputDirectory = 'projects';

    public static string $template = 'layouts.project';

    public function showInNavigation(): bool
    {
        return false;
    }

    /** @return \Hyde\Foundation\Kernel\PageCollection<\App\Pages\MarkdownProject> */
    public static function getLatestProjects(): PageCollection
    {
        return static::all()->sortByDesc(function (self $project): string {
            return (string) ($project->matter('date') ?? '');
        });
    }
}
