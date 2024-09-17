<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Liste Utilisateurs</title>
</head>
<body>
    <a class="flex justify-center ml-2 mt-2 p-2 px-5 w-min rounded bg-gray-400 duration-300 hover:bg-gray-800 hover:text-white hover:mt-4" href="{{ url('/') }}">Retour</a>

    <div class="w-1/2 bg-white mx-auto p-2 mt-5 ">
    <ul class="list-group">
        @forelse ($users as $user)
        <li class="list-group-item">
            <div class="flex justify-between align-items-center my-5 border rounded">
                <div class="flex gap-6">
                    <div class='min-w-40 my-auto text-center'>{{ $user->lastname}}</div>
                    <div class='min-w-40 my-auto text-center'>{{ $user->firstname }}</div>
                </div>
                <div class="flex justify-center gap-2 p-2 px-5 rounded bg-blue-300">
                    <a href="{{ route('user.show', $user->id) }}">Détail</a>
                </div>
            </div>
        </li>
        @empty
        <li class="list-group-item">
            {{ __('Aucun user connu')}}
        </li>
        @endforelse
    </ul>
</div>

</body>
</html>
