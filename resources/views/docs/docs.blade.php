@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 mt-10 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-semibold mb-4 text-gray-800">📚 Documentation</h1>

    <!-- Barre de recherche -->
    <input type="text" id="searchInput" placeholder="Rechercher une catégorie..."
           class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 mb-4">

    <div id="categoriesContainer" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($categories as $slug => $category)
            <a href="{{ route('documentation.category', $slug) }}"
               class="category-card block p-4 bg-white shadow rounded-lg hover:bg-gray-100 transition"
               data-title="{{ strtolower($category['title']) }}">
                <h2 class="text-xl font-semibold text-gray-800">{{ $category['title'] }}</h2>
                <p class="text-gray-600 mt-2">Consultez les procédures détaillées.</p>
            </a>
        @endforeach
    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        let searchValue = this.value.toLowerCase();
        let cards = document.querySelectorAll('.category-card');

        cards.forEach(card => {
            let title = card.getAttribute('data-title');
            if (title.includes(searchValue)) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    });
</script>
@endsection
