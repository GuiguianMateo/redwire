<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    public function change(string $code_iso): RedirectResponse
    {
        Session::put('locale', $code_iso);
        App::setLocale($code_iso);

        return back();
    }
}
