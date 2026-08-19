<?php

declare(strict_types=1);

namespace App\Extensions;

use App\Pages\MarkdownProject;
use Hyde\Foundation\Concerns\HydeExtension;

class ProjectsExtension extends HydeExtension
{
    public static function getPageClasses(): array
    {
        return [
            MarkdownProject::class,
        ];
    }
}
