@extends('layouts.app')

@section('content')
<div class="mx-auto w-1/4  ">
    <form method="POST" action="{{ route('event.store') }}" class="space-y-4">
        @csrf

        <!-- Nom de l'événement -->
        <div class="flex flex-col">
            <label for="name" class="text-sm text-gray-600 mb-1">Nom de l'événement</label>
            <input type="text" name="name" id="name"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
        </div>

        <!-- Catégorie -->
        <div class="flex flex-col">
            <label for="category" class="text-sm text-gray-600 mb-1">Catégorie</label>
            <input type="text" name="category" id="category"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
        </div>

        <!-- Date de début -->
        <div class="flex flex-col">
            <label for="start_date" class="text-sm text-gray-600 mb-1">Date de début</label>
            <input type="datetime-local" name="date_debut" id="date_debut"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
        </div>

        <!-- Date de fin -->
        <div class="flex flex-col">
            <label for="end_date" class="text-sm text-gray-600 mb-1">Date de fin</label>
            <input type="datetime-local" name="date_fin" id="date_fin"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
        </div>

        <!-- Bouton de soumission -->
        <button type="submit"
            class="w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200">
            Ajouter l'événement
        </button>
    </form>

    @if(session('success'))
        <div class="mt-4 text-center text-green-600">
            <p>{{ session('success') }}</p>
        </div>
    @endif
</div>

@endsection
