@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Notifications</h1>

    <ul class="list-group">
        @foreach($notifications as $notification)
        <li class="list-group-item {{ $notification->is_read ? 'text-muted' : '' }}">
            {{ $notification->message }}
            <small class="text-muted d-block">Reçue le {{ $notification->created_at->format('d/m/Y à H:i') }}</small>
            @if(!$notification->is_read)
            <form action="{{ route('notifications.read', $notification->id) }}" method="post" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-sm btn-link text-primary">
                    Marquer comme lu
                </button>
            </form>

            @endif
        </li>
        @endforeach
    </ul>
</div>
@endsection
