<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
    <!-- Message flash -->
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mt-6 mb-6 text-center">
            {{ session('success') }}
        </div>
    @endif
    <!-- Articles -->
    @foreach ($articles as $article)
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-2">{{ $article->title }}</h2>
                <div class="text-sm text-gray-500 mb-1">
                    Créé le {{ $article->created_at->format('d/m/Y') }}
                </div>
                <div class="mb-2">
                    @foreach ($article->categories as $category)
                        <span class="text-xs text-black mr-1 bg-gray-300 px-4 py-2 inline-block rounded-full font-bold">#{{ $category->name }}</span>
                    @endforeach
                </div>
                <p class="text-gray-700 mb-4">{{ substr($article->content, 0, 30) }}...</p>
                <div class="flex justify-end space-x-2 mt-4">
                    <a href="{{ route('articles.edit', $article->id) }}"
                        class="inline-block px-4 py-2 bg-blue-600 text-white font-semibold rounded shadow hover:from-indigo-600 hover:to-pink-600 transition duration-200">
                        ✏️ Modifier
                    </a>
                    <form id="delete-form-{{ $article->id }}" action="{{ route('articles.remove', $article->id) }}"
                        method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete({{ $article->id }})"
                            class="px-4 py-2 bg-red-600 text-white font-semibold rounded shadow hover:bg-red-700 transition duration-200">
                            🗑️ Supprimer
                        </button>
                    </form>
                </div>


            </div>
        </div>
    @endforeach

    <!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(articleId) {
        Swal.fire({
            title: 'Es-tu sûr ?',
            text: "Cette action supprimera l'article définitivement.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + articleId).submit();
            }
        });
    }
</script>

</x-app-layout>
