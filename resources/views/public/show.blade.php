<x-guest-layout>
    <div class="mb-4">
        <a href="{{ route('public.index', [$article->user->id, $article->id]) }}"
            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour
        </a>
    </div>

    <div class="text-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $article->title }}
        </h2>
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
