<x-guest-layout>
    <div class="text-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Liste des articles publiés de {{ $user->name }}
        </h2>
    </div>

    <div>
        <!-- Articles -->
        @foreach ($articles as $article)
        <div>
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h2 class="text-2xl font-bold">{{ $article->title }}</h2>
                <div class="text-sm text-gray-500 mb-1">
                    Publié le {{ $article->created_at->format('d/m/Y') }} par {{ $article->user->name }}
                </div>
                <div class="mb-2">
                    @foreach ($article->categories as $category)
                        <span class="text-xs text-indigo-600 mr-1">#{{ $category->name }}</span>
                    @endforeach
                </div>
                <p class="text-gray-700 dark:text-gray-300">{{ substr($article->content, 0, 30) }}...</p>

                <a href="{{ route('public.show', [$article->user_id, $article->id]) }}" class="text-red-500 hover:text-red-700">Lire la suite</a>
            </div>
        </div>
        <hr>
        @endforeach
    </div>
</x-guest-layout>
