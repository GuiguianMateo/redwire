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
    <div class="w-1/2 bg-white mx-auto rounded-xl border-2 border-gray-400 p-2 mt-5">
        <div class="flex justify-around my-8">
            <strong class="text-4xl">{{ __('Users listing') }}</strong>
        </div>
        <ul class="list-group">
            @forelse (Auth::user()->isA('admin') ? $users : [Auth::user()] as $user)
                <li class="list-group-item">
                    <div class="flex justify-between align-items-center my-5 border rounded">
                        <div class="min-w-40 my-auto text-center">{{ $user->name }}</div>
                        <div class="flex gap-2">
                            @if ($user->deleted_at === null)
                                @can('user-show')
                                    <a class="flex justify-center gap-2 p-2 px-5 rounded bg-blue-300" href="{{ route('user.show', $user) }}">{{ __('Details') }}</a>
                                @endcan
                                @can('user-edit')
                                    <a class="flex justify-center gap-2 p-2 px-5 rounded bg-orange-300" href="{{ route('user.edit', $user) }}">{{ __('Edit') }}</a>
                                @endcan
                                @can('user-delete')
                                    <form action="{{ route('user.destroy', $user) }}" method="post">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="flex justify-center gap-2 p-2 px-5 rounded bg-red-300">{{ __('Delete') }}</button>
                                    </form>
                                @endcan
                            @else
                                @can('user-restore')
                                    <form action="{{ route('user.restore', $user) }}" method="post">
                                        @csrf @method('GET')
                                        <button type="submit" class="flex justify-center gap-2 p-2 px-5 rounded bg-purple-300">{{ __('Restore') }}</button>
                                    </form>
                                @endcan
                            @endif
                        </div>
                    </div>
                </li>
            @empty
            {{ __('Unknown user') }}
            @endforelse
        </ul>
    </div>
</div>
@endsection
