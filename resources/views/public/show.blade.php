<x-guest-layout>
    <div class="mb-4">
        <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
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
        Publié le {{ $article->created_at->format('d/m/Y') }} par <a href="{{ route('public.index', $article->user->id) }}">{{ $article->user->name }}</a>
    </div>

    <div>
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <p class="text-gray-700 dark:text-gray-300">{{ $article->content }}</p>
        </div>
    </div>

    <!-- Section des commentaires -->
    <div class="mt-8">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Commentaires</h3>

        <!-- Formulaire pour ajouter un commentaire -->
        @auth
            <form action="{{ route('comments.store', $article->id) }}" method="POST" class="mb-6">
                @csrf
                <div class="mb-4">
                    <textarea name="content" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" placeholder="Votre commentaire..."></textarea>
                </div>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg">
                    Publier
                </button>
            </form>
        @else
            <p class="text-gray-600 dark:text-gray-400 mb-4">
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500">Connectez-vous</a> pour laisser un commentaire.
            </p>
        @endauth

        <!-- Liste des commentaires -->
        <div class="space-y-4">
            @forelse($article->comments as $comment)
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
                    <div class="flex items-start space-x-4">
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $comment->user->name }}
                                </h4>
                                <span class="text-xs text-gray-500">
                                    {{ $comment->created_at->format('d/m/Y H:i') }}
                                </span>
                            </div>
                            <p class="mt-2 text-gray-700 dark:text-gray-300">
                                {{ $comment->content }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">
                    Aucun commentaire pour le moment. Soyez le premier à commenter !
                </p>
            @endforelse
        </div>
    </div>
</x-guest-layout>
