<?php

namespace App\Http\Controllers;

use App\Http\Requests\MotifRequest;
use App\Mail\CreateMotif;
use App\Mail\DeleteMotif;
use App\Mail\EditMotif;
use App\Mail\RestoreMotif;
use App\Models\Absence;
use App\Models\Motif;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class MotifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $motifs = Cache::remember('motifs_with_trashed', 60 * 60 * 24, function () {
            return Motif::withTrashed()->get();
        });

        return view('motif.index', compact('motifs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $user = Auth::user();
        if ($user && $user->can('motif-create')) {
            return view('motif.create');
        }
        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MotifRequest  $request
     * @return RedirectResponse
     */
    public function store(MotifRequest $request): RedirectResponse
    {
        $user = Auth::user();
        if ($user && $user->can('motif-create')) {
            $data = $request->validated();

            // Assurer que les données sont bien typées
            $titre = isset($data['titre']) ? (string) $data['titre'] : '';
            // Convertir en entier 0 ou 1
            $isAccessible = isset($data['is_accessible']) && $data['is_accessible'] ? 1 : 0;

            $motif = new Motif();
            $motif->titre = $titre;
            $motif->is_accessible_salarie = $isAccessible; // La propriété doit être un int
            $motif->save();

            Cache::forget('motifs_with_trashed');

            Mail::to($user->email)->send(new CreateMotif($motif));

            session()->flash('message', ['type' => 'success', 'text' => __('Reason created successfully.')]);
            return redirect()->route('motif.index');
        }
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Motif  $motif
     * @return View
     */
    public function edit(Motif $motif): View
    {
        $user = Auth::user();
        if ($user && $user->can('motif-edit')) {
            return view('motif.edit', compact('motif'));
        }
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MotifRequest  $request
     * @param  Motif  $motif
     * @return RedirectResponse
     */
    public function update(MotifRequest $request, Motif $motif): RedirectResponse
    {
        $user = Auth::user();
        if ($user && $user->can('motif-edit')) {
            $oldtitre = $motif->titre;
            $oldaccessible = (bool) $motif->is_accessible_salarie; // Convertir en booléen

            $data = $request->validated();

            // Assurer que les données sont bien typées
            $titre = isset($data['titre']) ? (string) $data['titre'] : '';
            // Convertir en entier 0 ou 1
            $isAccessible = isset($data['is_accessible']) && $data['is_accessible'] ? 1 : 0;

            $motif->titre = $titre;
            $motif->is_accessible_salarie = $isAccessible; // La propriété doit être un int
            $motif->save();

            Cache::forget('motifs_with_trashed');

            // On passe oldaccessible comme booléen
            Mail::to($user->email)->send(new EditMotif($motif, $oldtitre, $oldaccessible));

            session()->flash('message', ['type' => 'success', 'text' => __('Reason edited successfully.')]);
            return redirect()->route('motif.index');
        }
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Motif  $motif
     * @return RedirectResponse
     */
    public function destroy(Motif $motif): RedirectResponse
    {
        $user = Auth::user();
        if ($user && $user->can('motif-delete')) {
            $nb = Absence::where('motif_id', $motif->id)->count();

            if ($nb === 0) {
                $oldtitre = $motif->titre;
                $oldaccessible = (bool) $motif->is_accessible_salarie; // Convertir en booléen

                $motif->delete();

                Cache::forget('motifs_with_trashed');

                // On passe oldaccessible comme booléen
                Mail::to($user->email)->send(new DeleteMotif($oldtitre, $oldaccessible));

                session()->flash('message', ['type' => 'success', 'text' => __('Reason deleted successfully.')]);
            } else {
                session()->flash('message', ['type' => 'error', 'text' => __('The reason is still in use with :count absence(s).', ['count' => $nb])]);
            }

            return redirect()->route('motif.index');
        }
        abort(403);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  Motif  $motif
     * @return RedirectResponse
     */
    public function restore(Motif $motif): RedirectResponse
    {
        $user = Auth::user();
        if ($user && $user->can('motif-restore')) {
            $motif->restore();

            Cache::forget('motifs_with_trashed');

            Mail::to($user->email)->send(new RestoreMotif($motif));

            session()->flash('message', ['type' => 'success', 'text' => __('Reason restored successfully.')]);
            return redirect()->route('motif.index');
        }
        abort(403);
    }
}
