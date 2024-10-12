<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LanguageTest extends TestCase
{
    use RefreshDatabase;

    public function test_language_can_be_changed()
    {
        // Activer le middleware StartSession
        $this->withMiddleware([\Illuminate\Session\Middleware\StartSession::class]);

        // Définir un code de langue (par exemple, 'fr' pour le français)
        $codeIso = 'fr';

        // Envoyer une requête GET à la route du changement de langue
        $response = $this->get(route('language.change', ['code_iso' => $codeIso]));

        // Vérifier que la langue a bien été mise à jour dans la session
        $this->assertEquals($codeIso, session('locale'));

        // Vérifier que l'application utilise le bon locale
        $this->assertEquals($codeIso, App::getLocale());

        // Vérifier que la réponse redirige correctement en arrière
        $response->assertRedirect();
    }
}
