@extends('layouts.app')

@section('content')
@if(session('notification'))
    <div style="
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        font-weight: bold;
        color: {{ session('notification')['type'] === 'success' ? '#155724' : '#721c24' }};
        background-color: {{ session('notification')['type'] === 'success' ? '#d4edda' : '#f8d7da' }};
        border: 1px solid {{ session('notification')['type'] === 'success' ? '#c3e6cb' : '#f5c6cb' }};
    ">
        {{ session('notification')['text'] }}
    </div>
@endif


<form action="{{ route('absence.store') }}" method="post" class="max-w-lg mx-auto p-6 mt-20 bg-white rounded-lg shadow-md">
    @csrf

    <div class="mb-4">
        <label for="motif" class="block text-gray-700 font-semibold">{{ __('Choose a reason') }}</label>
        <select class="border border-gray-300 rounded p-2 w-full" name="motif">
            <option value="">{{ __('Please, choose a reason') }}</option>
            @foreach (Auth::user()->isA('admin') ? $motifs : $motifs->where('is_accessible_salarie', 1) as $motif)
                <option @if(old('motif') == $motif->id) selected @endif value="{{ $motif->id }}">{{ $motif->titre }}</option>
            @endforeach
        </select>
        @error("motif")
            <p class="text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="user" class="block text-gray-700 font-semibold">{{ __('Choose a user') }}</label>
        <select class="border border-gray-300 rounded p-2 w-full" name="user">
            <option value="">{{ __('Please, choose a user') }}</option>
            @foreach (Auth::user()->isA('admin') ? $users : [Auth::user()] as $user)
                <option @if(old('user') == $user->id) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
        @error("user")
            <p class="text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="debut" class="block text-gray-700 font-semibold">{{ __('Start absence date') }}</label>
        <input type="date" class="border border-gray-300 rounded p-2 w-full" name="debut" value="{{ old('debut') }}">
        @error("debut")
            <p class="text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="fin" class="block text-gray-700 font-semibold">{{ __('End absence date') }}</label>
        <input type="date" class="border border-gray-300 rounded p-2 w-full" name="fin" value="{{ old('fin') }}">
        @error("fin")
            <p class="text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <input type="hidden" name="status" value="{{ auth()->user()->isA('admin') ? 'validate' : 'pending' }}" readonly>

    <button type="submit" class="mt-4 w-full bg-blue-500 text-white font-semibold py-2 rounded hover:bg-blue-600">
        {{ __('Create') }}
    </button>
</form>
@endsection
