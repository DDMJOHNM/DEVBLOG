@php($title = 'Projects')
@extends('hyde::layouts.app')
@section('content')

    <main id="content" class="mx-auto max-w-7xl py-12 px-8">
        <header class="lg:mb-12 xl:mb-16">
            <h1 class="text-3xl text-left leading-10 tracking-tight font-extrabold sm:leading-none mb-8 md:mb-12 md:text-4xl md:text-center lg:text-5xl text-gray-700 dark:text-gray-200">
                Projects
            </h1>
            <p class="max-w-3xl mx-auto text-gray-600 dark:text-gray-300 md:text-center">
                Selected project write-ups
            </p>
        </header>

        <div id="project-feed" class="max-w-3xl mx-auto">
            <ol itemscope itemtype="https://schema.org/ItemList">
                @forelse(MarkdownProject::getLatestProjects() as $project)
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="mt-4 mb-8">
                        <meta itemprop="position" content="{{ $loop->iteration }}">
                        @include('components.project-excerpt')
                    </li>
                @empty
                    <li class="text-gray-600 dark:text-gray-300">No projects yet.</li>
                @endforelse
            </ol>
        </div>
    </main>

@endsection
