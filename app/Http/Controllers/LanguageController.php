<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function change(string $code_iso)
    {
        Session::put('locale', $code_iso);
        App::setLocale($code_iso);

        return back();
    }
}
