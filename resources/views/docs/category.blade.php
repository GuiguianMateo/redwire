@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 mt-10 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-semibold mb-4 text-gray-800">📄 {{ $category['title'] }}</h1>

    <!-- Ajout des documents directement dans la vue -->
    @if($categorySlug === 'conges-payes')

    @elseif($categorySlug === 'arrets-maladie')

    @elseif($categorySlug === 'autres-absences')

    @endif

    <!-- Inclusion dynamique de la documentation -->
    @includeIf("docs.details.$categorySlug")

    <a href="{{ route('documentation.index') }}" class="inline-block mt-4 text-blue-500 hover:underline">← Retour à la documentation</a>
</div>
@endsection
