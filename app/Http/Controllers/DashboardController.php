<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::all();

        $selectannee = $request->input('year', date('Y'));
        $nb_annee = $selectannee - date('Y');
        $conge_annee = 30 * max($nb_annee, 1);

        return view('Dashboard', compact('users', 'selectannee', 'conge_annee'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Dashboard  $dashboard
     * @return View
     */
    public function edit(Dashboard $dashboard): View
    {
       //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Dashboard  $dashboard
     * @return RedirectResponse
     */
    public function update(Request $request, Dashboard $dashboard): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Dashboard  $dashboard
     * @return RedirectResponse
     */
    public function destroy(Dashboard $dashboard): RedirectResponse
    {
       //
    }
}
