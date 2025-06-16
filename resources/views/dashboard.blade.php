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
                <h2 class="text-2xl font-bold">{{ $article->title }}</h2>
                <p class="text-gray-700">{{ substr($article->content, 0, 30) }}...</p>
                <div class="text-right">
                    <a href="{{ route('articles.edit', $article->id) }}"
                        class="text-red-500 hover:text-red-700">Modifier</a>
                </div>
                {{-- lien pour la suppression --}}
                {{-- <div class="text-right">
                    <a href="{{ route('articles.remove', $article->id) }}"
                        class="text-red-500 hover:text-red-700">Supprimer</a>
                </div> --}}
                {{-- <div class="text-right">
                    <a href="{{ route('articles.remove', $article->id) }}" class="text-red-500 hover:text-red-700"
                        onclick="return confirm('Voulez-vous vraiment supprimer cet article ?');">
                        Supprimer
                    </a>
                </div> --}}

                {{-- <form action="{{ route('articles.remove', $article->id) }}" method="POST"
                    onsubmit="return confirm('Voulez-vous vraiment supprimer cet article ?');" class="text-right">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700">Supprimer</button>
                </form> --}}

                <form id="delete-form-{{ $article->id }}" action="{{ route('articles.remove', $article->id) }}"
                    method="POST" class="text-right">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmDelete({{ $article->id }})"
                        class="text-red-500 hover:text-red-700">
                        Supprimer
                    </button>
                </form>


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
