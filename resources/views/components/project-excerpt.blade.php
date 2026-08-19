@php /** @var \App\Pages\MarkdownProject $project */ @endphp
<article itemprop="item" itemscope itemtype="https://schema.org/CreativeWork">
    <meta itemprop="identifier" content="{{ $project->identifier }}">
    @if($project->getCanonicalUrl())
        <meta itemprop="url" content="{{ $project->getCanonicalUrl() }}">
    @endif

    <header>
        <a href="{{ $project->getRoute() }}" class="block w-fit">
            <h2 itemprop="headline" class="text-2xl font-bold text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white transition-colors duration-75">
                {{ $project->title }}
            </h2>
        </a>
    </header>

    @if($project->matter('stack'))
        <p class="opacity-75 text-sm mt-1">{{ $project->matter('stack') }}</p>
    @endif

    @if($project->matter('description'))
        <section role="doc-abstract" aria-label="Excerpt">
            <p itemprop="description" class="leading-relaxed my-1">
                {{ $project->matter('description') }}
            </p>
        </section>
    @endif

    <footer>
        <a href="{{ $project->getRoute() }}" class="text-indigo-500 hover:underline font-medium">
            View project
        </a>
    </footer>
</article>
