@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 mt-10 bg-white rounded-lg shadow-md">
    <!-- Bouton Retour -->


    <h1 class="text-2xl font-semibold mb-4 text-gray-800">Gestion des T0</h1>

    <p class="text-gray-600 mb-6">Consultez les règles et procédures concernant la gestion des périodes T0.</p>

    <!-- Bloc de documentation sur les T0 -->
    <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-400 rounded-lg">
        <h2 class="text-lg font-semibold text-blue-700">📘 Documentation sur la Gestion des T0</h2>

        <h3 class="text-md font-semibold text-blue-600 mt-3">🔍 Définition</h3>
        <p class="text-gray-700">
            Le **T0** est une période d'absence non rémunérée accordée dans certains contextes spécifiques.
            Elle est souvent mise en place en début de contrat lorsque le salarié **n’a pas encore cumulé de jours de congé**.
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">📆 Conditions d’Attribution</h3>
        <p class="text-gray-700">
            - Peut être accordé aux **nouveaux salariés** avant qu’ils ne cumulent des congés.<br>
            - Peut être utilisé en cas de **besoin exceptionnel** (raisons personnelles, familiales).<br>
            - N'est pas automatiquement accordé et dépend de la **validation de l’employeur**.<br>
            - Certains accords collectifs peuvent prévoir des règles spécifiques pour l’utilisation du T0.
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">📌 Procédure de Demande</h3>
        <p class="text-gray-700">
            1. Faire une **demande écrite** à l’employeur en précisant la période concernée.<br>
            2. Attendre la **validation** ou le **refus** de l’employeur.<br>
            3. En cas d’acceptation, l'absence est enregistrée comme une période **non rémunérée**.<br>
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">💰 Impact sur la Rémunération</h3>
        <p class="text-gray-700">
            - **Aucune rémunération** n’est versée pendant la période T0.<br>
            - Le T0 ne donne pas droit à une compensation financière.<br>
            - Si le salarié prend un T0, il peut voir son **salaire du mois impacté** en fonction de la durée de l'absence.<br>
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">⚠️ Conséquences et Restrictions</h3>
        <p class="text-gray-700">
            - Le T0 **n’interrompt pas** l'ancienneté du salarié.<br>
            - Une **utilisation abusive** du T0 peut entraîner un refus de la part de l’employeur.<br>
            - Dans certaines entreprises, un **plafond de jours T0** peut être fixé pour éviter les abus.<br>
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">📌 Obligations</h3>
        <p class="text-gray-700">
            - **Salarié** : Effectuer une demande formelle et respecter la durée accordée.<br>
            - **Employeur** : Répondre à la demande et formaliser la décision.<br>
        </p>
        <a href="{{ route('documentation.index') }}" class="inline-block mb-4 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg shadow hover:bg-gray-300 transition">
            ⬅️ Retour à la documentation
        </a>
    </div>
</div>
@endsection
