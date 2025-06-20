<x-guest-layout>
    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('public.index', [$article->user->id, $article->id]) }}"
            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour
        </a>
    </div>

    <div class="text-center flex items-center justify-center mb-4">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mr-4">
            {{ $article->title }}
        </h2>
        @auth
        <form action="{{ route('article.like', $article->id) }}" method="POST" class="flex items-center ml-2">
            @csrf
            <button type="submit" class="flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.719,17.073l-6.562-6.51c-0.27-0.268-0.504-0.567-0.696-0.888C1.385,7.89,1.67,5.613,3.155,4.14c0.864-0.856,2.012-1.329,3.233-1.329c1.924,0,3.115,1.12,3.612,1.752c0.499-0.634,1.689-1.752,3.612-1.752c1.221,0,2.369,0.472,3.233,1.329c1.484,1.473,1.771,3.75,0.693,5.537c-0.19,0.32-0.425,0.618-0.695,0.887l-6.562,6.51C10.125,17.229,9.875,17.229,9.719,17.073 M6.388,3.61C5.379,3.61,4.431,4,3.717,4.707C2.495,5.92,2.259,7.794,3.145,9.265c0.158,0.265,0.351,0.51,0.574,0.731L10,16.228l6.281-6.232c0.224-0.221,0.416-0.466,0.573-0.729c0.887-1.472,0.651-3.346-0.571-4.56C15.57,4,14.621,3.61,13.612,3.61c-1.43,0-2.639,0.786-3.268,1.863c-0.154,0.264-0.536,0.264-0.69,0C9.029,4.397,7.82,3.61,6.388,3.61" clip-rule="evenodd" />
                </svg>
                <span>{{ $article->likes }}</span>
            </button>
        </form>
        @endauth
    </div>

    <div class="text-gray-500 text-sm">
        Publié le {{ $article->created_at->format('d/m/Y') }} par <a
            href="{{ route('public.index', $article->user->id) }}">{{ $article->user->name }}</a>
    </div>

    <div>
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <p class="text-gray-700 dark:text-gray-300">{{ $article->content }}</p>
        </div>
    </div>

    @auth
        <!-- Ajout d'un commentaire -->
        <form action="{{ route('comments.store') }}" method="post" class="mt-6">
            @csrf
            <input type="hidden" name="article_id" value="{{ $article->id }}">
            <input type="hidden" name="redirect_to" value="{{ url()->previous() }}">
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Votre
                    commentaire</label>
                <textarea name="content" id="content" rows="3" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-100"></textarea>
            </div>
            <div class="mt-4">
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Commenter</button>
            </div>
        </form>
    @endauth

    <!-- Liste des commentaires -->
    <div class="mt-8">
        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Commentaires</h3>
        @forelse ($article->comments->sortByDesc('created_at') as $comment)
            <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded">
                <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">
                    {{ $comment->user->name ?? 'Utilisateur supprimé' }} le {{ $comment->created_at->format('d/m/Y H:i') }}
                </div>
                <div class="text-gray-800 dark:text-gray-100">
                    {{ $comment->content }}
                </div>
            </div>
        @empty
            <div class="text-gray-500 dark:text-gray-400">Aucun commentaire pour cet article.</div>
        @endforelse
    </div>

</x-guest-layout>
