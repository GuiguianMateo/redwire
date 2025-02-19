@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 mt-10 bg-white rounded-lg shadow-md">


    <h1 class="text-2xl font-semibold mb-4 text-gray-800">Gestion des Arrêts Maladie</h1>

    <p class="text-gray-600 mb-6">Consultez les règles et procédures concernant les arrêts maladie.</p>

    <!-- Bloc de documentation sur les Arrêts Maladie -->
    <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-400 rounded-lg">
        <h2 class="text-lg font-semibold text-blue-700">📘 Documentation sur la Gestion des Arrêts Maladie</h2>

        <h3 class="text-md font-semibold text-blue-600 mt-3">🩺 Définition</h3>
        <p class="text-gray-700">
            Un arrêt maladie est une **interruption temporaire de travail** justifiée par un motif médical et attestée par un professionnel de santé.
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">📄 Déclaration et Procédures</h3>
        <p class="text-gray-700">
            - Le salarié doit **informer son employeur** dans un délai de **48 heures**.<br>
            - Un **certificat médical** doit être transmis à la **Sécurité Sociale** et à l’employeur.<br>
            - L’arrêt peut être **court** (moins de 3 mois) ou **long** (supérieur à 3 mois).
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">💰 Indemnisation</h3>
        <p class="text-gray-700">
            - La Sécurité Sociale verse des **indemnités journalières** sous conditions (ancienneté, cotisations suffisantes).<br>
            - Certains employeurs assurent un **complément de salaire** via la convention collective.
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">🚨 Contrôle Médical</h3>
        <p class="text-gray-700">
            - Des contrôles médicaux peuvent être réalisés pour **vérifier la justification** de l’arrêt.<br>
            - En cas de non-respect, les indemnités peuvent être suspendues.
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">🔄 Reprise du Travail</h3>
        <p class="text-gray-700">
            - Un **visite médicale de reprise** est obligatoire après **30 jours d'arrêt**.<br>
            - Le salarié peut bénéficier d’un **aménagement du poste** selon l’avis du médecin du travail.
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">📌 Obligations</h3>
        <p class="text-gray-700">
            - **Salarié** : Respecter les délais, transmettre les documents et suivre les prescriptions médicales.<br>
            - **Employeur** : Vérifier les documents, assurer le maintien du salaire si applicable et organiser la reprise.
        </p>
        <a href="{{ route('documentation.index') }}" class="inline-block mb-4 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg shadow hover:bg-gray-300 transition">
            ⬅️ Retour à la documentation
        </a>
    </div>
</div>
@endsection
