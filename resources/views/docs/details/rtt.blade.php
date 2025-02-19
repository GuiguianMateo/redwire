@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 mt-10 bg-white rounded-lg shadow-md">
    <!-- Bouton Retour -->


    <h1 class="text-2xl font-semibold mb-4 text-gray-800">Gestion des RTT</h1>

    <p class="text-gray-600 mb-6">Consultez les détails et procédures associés aux jours de Réduction du Temps de Travail.</p>

    <!-- Bloc de documentation sur les RTT -->
    <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-400 rounded-lg">
        <h2 class="text-lg font-semibold text-blue-700">📘 Documentation sur la Gestion des RTT</h2>

        <h3 class="text-md font-semibold text-blue-600 mt-3">🕒 Définition</h3>
        <p class="text-gray-700">
            Les RTT (Réduction du Temps de Travail) sont des jours de repos accordés aux salariés en compensation d’un temps de travail supérieur à <strong>35 heures par semaine</strong>.
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">📆 Acquisition des RTT</h3>
        <p class="text-gray-700">
            - Les RTT concernent principalement les **salariés travaillant plus de 35 heures par semaine**.<br>
            - Leur attribution varie selon les **accords d’entreprise** ou la **convention collective applicable**.<br>
            - Les absences prolongées (arrêt maladie, congé sans solde) peuvent impacter l’acquisition des RTT.
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">✅ Prise des RTT</h3>
        <p class="text-gray-700">
            - Le salarié doit faire une **demande de RTT** à l’employeur dans un délai défini.<br>
            - L’employeur **peut refuser ou reporter** un RTT en fonction des nécessités de service.<br>
            - Certains accords permettent une prise **automatique des RTT** sur une période définie.
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">💰 Indemnisation et Report</h3>
        <p class="text-gray-700">
            - Les RTT **non pris ne sont généralement pas reportables**, sauf disposition spécifique.<br>
            - En cas de départ de l’entreprise, les RTT restants peuvent être **indemnisés**.<br>
            - Certaines entreprises proposent le **rachat des RTT** sous conditions.
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">⚠️ Cas Particuliers</h3>
        <p class="text-gray-700">
            - Un RTT tombant sur un **jour férié** peut être perdu ou reporté selon l’accord collectif.<br>
            - Les **heures supplémentaires** ne génèrent pas forcément des RTT, sauf accord spécifique.
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">📌 Obligations</h3>
        <p class="text-gray-700">
            - **Employeur** : Appliquer les RTT selon les accords, informer les salariés.<br>
            - **Salarié** : Respecter les procédures internes et les délais de demande.
        </p>
        <a href="{{ route('documentation.index') }}" class="inline-block mb-4 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg shadow hover:bg-gray-300 transition">
            ⬅️ Retour à la documentation
        </a>
    </div>
</div>
@endsection
