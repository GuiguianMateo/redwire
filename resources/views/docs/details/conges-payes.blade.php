@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 mt-10 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-semibold mb-4 text-gray-800">{{ $category['title'] }}</h1>

    <p class="text-gray-600 mb-6">Consultez les détails et procédures associées.</p>

    <!-- Bloc de documentation spécifique aux Congés Payés -->
    @if($categorySlug === 'conges-payes')
    <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-400 rounded-lg">
        <h2 class="text-lg font-semibold text-blue-700">📘 Documentation sur les Congés Payés</h2>
        <p class="text-gray-700 mb-2">
            Les congés payés sont des jours de repos accordés aux salariés en compensation de leur travail.
            En général, un salarié cumule <strong>2,5 jours de congé</strong> par mois travaillé, soit <strong>30 jours ouvrables par an</strong>.
        </p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">🕒 Acquisition des Congés</h3>
        <p class="text-gray-700">Le calcul des congés se fait sur la période du <strong>1er juin au 31 mai</strong> de l’année suivante.</p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">📆 Prise des Congés</h3>
        <p class="text-gray-700">Les congés doivent être validés par l’employeur en fonction des impératifs de service.</p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">💰 Indemnisation</h3>
        <p class="text-gray-700">L’indemnité de congés payés est calculée au plus avantageux entre <strong>le maintien de salaire</strong> et <strong>la règle du dixième</strong>.</p>

        <h3 class="text-md font-semibold text-blue-600 mt-3">❌ Obligations et Sanctions</h3>
        <p class="text-gray-700">L’employeur doit permettre au salarié de prendre ses congés. Les congés non pris en fin de contrat donnent droit à une indemnité compensatrice.</p>
        <a href="{{ route('documentation.index') }}" class="inline-block mb-4 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg shadow hover:bg-gray-300 transition">
            ⬅️ Retour à la documentation
        </a>
    </div>
    @endif
</div>
@endsection
