@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 mt-10 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-semibold mb-4 text-gray-800">📚 Documentation</h1>

    <!-- Barre de recherche -->
    <input type="text" id="searchInput" placeholder="Rechercher une catégorie..."
           class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 mb-4">

    <div id="categoriesContainer" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($categories as $slug => $category)
            <a href="{{ route('documentation.category', $slug) }}"
               class="category-card block p-4 bg-white shadow rounded-lg hover:bg-gray-100 transition"
               data-title="{{ strtolower($category['title']) }}">
                <h2 class="text-xl font-semibold text-gray-800">{{ $category['title'] }}</h2>
                <p class="text-gray-600 mt-2">Consultez les procédures détaillées.</p>
            </a>
        @endforeach
    </div>

    <!-- Section FAQ -->
    <div class="mt-10">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">❓ FAQ - Questions Fréquentes</h2>

        <!-- Barre de recherche pour la FAQ -->
        <input type="text" id="faqSearchInput" placeholder="Rechercher une question..."
               class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 mb-4">

               <div id="faqContainer" class="space-y-4">
                <!-- Question 1 -->
                <div class="faq-item border border-gray-200 rounded-lg" data-question="comment utiliser cette documentation">
                    <button class="faq-question w-full text-left p-4 bg-gray-100 hover:bg-gray-200 font-medium flex justify-between items-center">
                        🔹 Comment utiliser cette documentation ?
                        <span class="arrow">➕</span>
                    </button>
                    <div class="faq-answer hidden p-4 bg-white text-gray-700">
                        Cette documentation vous guide à travers les différentes fonctionnalités de notre application. Cliquez sur une catégorie pour accéder aux instructions détaillées.
                    </div>
                </div>

                <!-- Question 2 -->
                <div class="faq-item border border-gray-200 rounded-lg" data-question="puis-je proposer une modification">
                    <button class="faq-question w-full text-left p-4 bg-gray-100 hover:bg-gray-200 font-medium flex justify-between items-center">
                        🔹 Puis-je proposer une modification ?
                        <span class="arrow">➕</span>
                    </button>
                    <div class="faq-answer hidden p-4 bg-white text-gray-700">
                        Oui, vous pouvez nous envoyer vos suggestions en utilisant le formulaire de contact ou en créant une demande sur notre plateforme.
                    </div>
                </div>

                <!-- Question 3 -->
                <div class="faq-item border border-gray-200 rounded-lg" data-question="où puis-je signaler un problème">
                    <button class="faq-question w-full text-left p-4 bg-gray-100 hover:bg-gray-200 font-medium flex justify-between items-center">
                        🔹 Où puis-je signaler un problème ?
                        <span class="arrow">➕</span>
                    </button>
                    <div class="faq-answer hidden p-4 bg-white text-gray-700">
                        Si vous rencontrez un problème, merci de le signaler en envoyant un ticket via notre support technique.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Recherche des catégories
    document.getElementById('searchInput').addEventListener('input', function () {
        let searchValue = this.value.toLowerCase();
        let cards = document.querySelectorAll('.category-card');

        cards.forEach(card => {
            let title = card.getAttribute('data-title');
            card.style.display = title.includes(searchValue) ? "block" : "none";
        });
    });

    // Gestion du système FAQ (accordéon)
    document.querySelectorAll('.faq-question').forEach(button => {
        button.addEventListener('click', function () {
            let answer = this.nextElementSibling;
            let arrow = this.querySelector('.arrow');

            // Ouvrir/Fermer la réponse avec Toggle
            answer.classList.toggle('hidden');

            // Changer l'icône ➕/➖
            if (answer.classList.contains('hidden')) {
                arrow.textContent = "➕";
            } else {
                arrow.textContent = "➖";
            }
        });
    });
    // Recherche dans la FAQ
    document.getElementById('faqSearchInput').addEventListener('input', function () {
        let searchValue = this.value.toLowerCase();
        let faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(item => {
            let question = item.getAttribute('data-question');
            item.style.display = question.includes(searchValue) ? "block" : "none";
        });
    });
</script>
@endsection
