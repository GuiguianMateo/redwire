@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 mt-10 bg-white rounded-lg shadow-md">


    <h1 class="text-2xl font-semibold mb-4 text-gray-800">Gestion des Autres Absences</h1>
    <p class="text-gray-600 mb-6">Consultez les règles et procédures concernant les absences spécifiques.</p>

    <!-- Bloc de documentation -->
    <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-400 rounded-lg">
        <h2 class="text-lg font-semibold text-blue-700">📘 Documentation sur la Gestion des Autres Absences</h2>

        <!-- Congé sans solde -->
        <h3 class="text-md font-semibold text-blue-600 mt-3">📌 Congé Sans Solde</h3>
        <p class="text-gray-700">
            Le **congé sans solde** est une période d'absence accordée à un salarié, durant laquelle il ne perçoit pas de rémunération. Ce type de congé est soumis à l'approbation de l'employeur et n'est pas décompté des congés payés.
        </p>

        <h4 class="text-sm font-semibold text-blue-500 mt-2">🔹 Conditions d'Attribution</h4>
        <p class="text-gray-700">
            - Une demande formelle doit être envoyée à l'employeur.<br>
            - L’employeur n’a **aucune obligation légale** d’accorder un congé sans solde.<br>
            - La durée du congé est déterminée d'un commun accord entre le salarié et l’employeur.<br>
        </p>

        <h4 class="text-sm font-semibold text-blue-500 mt-2">💰 Impact sur la Rémunération</h4>
        <p class="text-gray-700">
            - **Aucune rémunération** durant la période du congé.<br>
            - Pas d’acquisition de droits aux congés payés pendant l’absence.<br>
        </p>

        <!-- Absences pour Événements Familiaux -->
        <h3 class="text-md font-semibold text-blue-600 mt-5">📌 Absences pour Événements Familiaux</h3>
        <p class="text-gray-700">
            Les salariés ont droit à des jours d'absence pour certains **événements familiaux** (mariage, décès, naissance, adoption...).
        </p>

        <h4 class="text-sm font-semibold text-blue-500 mt-2">🔹 Durée Légale des Absences</h4>
        <p class="text-gray-700">
            - **Mariage/PACS du salarié** : 4 jours.<br>
            - **Naissance/adoption d’un enfant** : 3 jours.<br>
            - **Mariage d’un enfant** : 1 jour.<br>
            - **Décès d’un proche (conjoint, enfant, parent, frère/sœur, grand-parent)** : de 1 à 5 jours selon le lien familial.<br>
        </p>

        <h4 class="text-sm font-semibold text-blue-500 mt-2">📌 Procédure de Demande</h4>
        <p class="text-gray-700">
            - Informer l’employeur dès que possible.<br>
            - Fournir un justificatif (acte de mariage, certificat de décès, etc.).<br>
            - Ces absences sont **rémunérées** et ne sont pas déduites des congés payés.<br>
        </p>
            <!-- Bouton Retour -->
    <a href="{{ route('documentation.index') }}" class="inline-block mb-4 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg shadow hover:bg-gray-300 transition">
        ⬅️ Retour à la documentation
    </a>
    </div>
</div>
@endsection
