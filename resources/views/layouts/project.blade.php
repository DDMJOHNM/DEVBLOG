{{-- The Project Page Layout --}}
@extends('hyde::layouts.app')
@section('content')

    <main id="content" class="mx-auto max-w-7xl py-16 px-8">
        <article aria-label="Project" id="{{ $page->identifier }}" itemscope itemtype="https://schema.org/CreativeWork"
            @class(['project-article mx-auto', config('markdown.prose_classes', 'prose dark:prose-invert')])>
            <p class="not-prose mb-8">
                <a href="{{ Routes::find('projects') }}" class="text-indigo-500 hover:underline font-medium">
                    &larr; Projects
                </a>
            </p>

            <header aria-label="Header section" role="doc-pageheader">
                <h1 itemprop="headline" class="mb-4">{{ $page->title }}</h1>
                @if($page->matter('stack'))
                    <p class="opacity-75 text-sm">{{ $page->matter('stack') }}</p>
                @endif
            </header>

            <div aria-label="Article body" itemprop="text">
                {{ $content }}
            </div>
            <span class="sr-only">End of article</span>
        </article>
    </main>

@endsection
