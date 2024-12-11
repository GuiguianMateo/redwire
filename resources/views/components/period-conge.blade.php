@props(['users','congeMonth','congeYear'])

<p>Vos jours de congé actuel : {{$users->jour_conge}}</p>
<p>Vos jours de congé dans 1 mois : {{$congeMonth}}</p>
<p>Vos jours de congé dans 1 an : {{$congeYear}}</p>
