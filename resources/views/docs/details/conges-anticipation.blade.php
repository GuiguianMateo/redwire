@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 mt-10 bg-white rounded-lg shadow-md">
    <!-- Bouton Retour -->


    <h1 class="text-2xl font-semibold mb-4 text-gray-800">Gestion des Congés par Anticipation</h1>

    <p class="text-gray-600 mb-6">Consultez les règles et procédures pour prendre un congé par anticipation.</p>

    <!-- Bloc de documentation sur les Congés Anticipés -->
    <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-400 rounded-lg">
        <h2 class="text-lg font-semibold text-blue-700">📘 Documentation sur la Gestion des Congés par Anticipation</h2>

        <h3 class="text-md font-semibold text-blue-600 mt-3">📝 Définition</h3>
        <p class="text-gray-700">
            Un congé par anticipation est un congé pris avant l’acquisition complète des droits aux congés payés.
            Il est généralement soumis à l’autorisation de l’employeur et à des accords internes spécifiques.
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">📆 Conditions d’Attribution</h3>
        <p class="text-gray-700">
            - L’accord de l’employeur est obligatoire.<br>
            - Peut être accordé aux **nouveaux salariés** n’ayant pas encore accumulé assez de jours de congés.<br>
            - En cas de **situation exceptionnelle** (raisons familiales, médicales…).<br>
            - Dépend des conventions collectives et des accords d’entreprise.
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">📌 Procédure de Demande</h3>
        <p class="text-gray-700">
            1. Faire une **demande écrite** à l’employeur précisant la période souhaitée.<br>
            2. Attendre la **validation de l’employeur** (qui peut refuser pour nécessité de service).<br>
            3. L’accord peut être formalisé dans un **courrier officiel** ou un échange d’emails.<br>
            4. En cas d’accord, le congé sera déduit des jours à acquérir.
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">💰 Impact sur la Rémunération</h3>
        <p class="text-gray-700">
            - Les congés par anticipation **peuvent être rémunérés** si l’entreprise le permet.<br>
            - Dans certains cas, un **avancement de salaire** peut être mis en place.<br>
            - En cas de **rupture de contrat avant l’acquisition des jours accordés**, le salarié peut devoir rembourser les jours pris.
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">⚠️ Cas Particuliers</h3>
        <p class="text-gray-700">
            - En cas de **longue absence** (maladie, congé parental), les congés par anticipation peuvent être refusés.<br>
            - Les entreprises avec des **conventions collectives plus favorables** peuvent accorder plus de souplesse.<br>
            - Certains employeurs proposent une **banque de congés** où les salariés peuvent emprunter des jours.
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">📌 Obligations</h3>
        <p class="text-gray-700">
            - **Salarié** : Effectuer une demande formelle et respecter les délais imposés.<br>
            - **Employeur** : Répondre à la demande et informer clairement sur les conditions d’octroi.<br>
        </p>
        <a href="{{ route('documentation.index') }}" class="inline-block mb-4 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg shadow hover:bg-gray-300 transition">
            ⬅️ Retour à la documentation
        </a>
    </div>
</div>
@endsection
