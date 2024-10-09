@extends('layouts.app')

@section('content')
    <div class="bg-gray-200 p-px">
        @if (session('message'))
            <div class="alert mt-4 p-4 rounded-md
                        @if(session('message')['type'] === 'success')
                            bg-green-100 text-green-800 border border-green-200
                        @elseif(session('message')['type'] === 'error')
                            bg-red-100 text-red-800 border border-red-200
                        @else
                            bg-gray-100 text-gray-800 border border-gray-200
                        @endif">
                {{ session('message')['text'] }}
            </div>
        @endif
        <div class="w-4/6 bg-white mx-auto rounded-xl border-2 border-gray-400 p-2 mt-5 ">
            <div class="flex justify-around my-8">
                <a class="flex justify-center p-2 px-5 rounded bg-gray-400 duration-300 hover:bg-gray-800 hover:text-white" href="{{ url('/') }}">{{ __("Back") }}</a>
                <strong class="text-4xl">{{ __("Absences listing") }}</strong>
                <a class="flex justify-center p-2 px-5 rounded bg-green-500" href="{{ route('absence.create') }}">{{ __("Create") }}</a>
            </div>
            <ul class="list-group">
            @php
                $absencesNotPending = $absences->where('status', '!=', 'pending');
                $userAdmin = Auth::user()->isA('admin') ? $absencesNotPending : $absencesNotPending->where('user_id', Auth::user()->id);
            @endphp

            @forelse ($userAdmin as $absence)
                <li class="list-group-item">
                    <div class="flex justify-between align-items-center my-5 border rounded">
                        <div class="flex">
                            <div class='min-w-48 my-auto text-center'>{{ $absence->motif->titre }}</div>
                            <div class='min-w-48 my-auto text-center'>{{ $absence->date_debut }}</div>
                            <div class='min-w-48 my-auto text-center'>{{ $absence->user->name }}</div>
                            <div class='min-w-48 my-auto text-center'>{{ __($absence->status) }}</div>
                        </div>
                        <div class="flex gap-2">
                            @if ($absence->deleted_at === null)
                                @can('absence-show')
                                    <a class="flex justify-center gap-2 p-2 px-5 rounded bg-blue-300" href="{{ route('absence.show', $absence) }}">{{ __("Details") }}</a>
                                @endcan
                                @can('absence-edit')
                                    <a class="flex justify-center gap-2 p-2 px-5 rounded bg-orange-300" href="{{ route('absence.edit', $absence) }}">{{ __("Edit") }}</a>
                                @endcan
                                @can('absence-delete')
                                    <form action="{{ route('absence.destroy', $absence) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex justify-center gap-2 p-2 px-5 rounded bg-red-300">{{ __("Delete") }}</button>
                                    </form>
                                @endcan
                            @else
                                @can('absence-restore')
                                    <form action="{{ route('absence.restore', $absence) }}" method="post">
                                        @csrf
                                        @method('GET')
                                        <button type="submit" class="flex justify-center gap-2 p-2 px-5 rounded bg-purple-300">{{ __("Restore") }}</button>
                                    </form>
                                @endcan
                            @endif
                        </div>
                    </div>
                </li>
                @empty
                    {{ __('Unknown absence ') }}
                @endforelse
            </ul>
        </div>
    </div>
@endsection
