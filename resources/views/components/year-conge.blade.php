@props(['conge_annee', 'selectannee', 'users'])
<form method="GET" action="{{ route('dashboard') }}">
    <label for="year">Choisir une année :</label>
    <select name="year" id="year">
        @foreach(range(2025, date('Y') + 10) as $year)
            <option value="{{ $year }}" {{ $year == $selectannee ? 'selected' : '' }}>
                {{ $year }}
            </option>
        @endforeach
    </select>
    <button type="submit">Voir</button>
</form>

<h2>Jours de congés pour l'année {{ $selectannee }} :</h2>
<p>{{ $conge_annee }} jours</p>
