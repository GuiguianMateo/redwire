<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbsenceRequest;
use App\Http\Requests\StatusRequest;
use App\Mail\CreateAbsence;
use App\Mail\DeleteAbsence;
use App\Mail\EditAbsence;
use App\Mail\RestoreAbsence;
use App\Models\Absence;
use App\Models\Motif;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class AbsenceController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $users = Cache::remember('users_with_trashed', 60 * 60 * 24, function () {
            return User::withTrashed()->get();
        });

        $motifs = Cache::remember('motifs_with_trashed', 60 * 60 * 24, function () {
            return Motif::withTrashed()->get();
        });

        $absences = Cache::remember('absences_with_trashed', 60 * 60 * 24, function () {
            return Absence::withTrashed()->get();
        });

        return view('absence.index', compact('absences', 'users', 'motifs'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $users = User::all();
        $motifs = Motif::all();

        return view('absence.create', compact('users', 'motifs'));
    }

    /**
     * @param AbsenceRequest $request
     * @return RedirectResponse
     */
    public function store(AbsenceRequest $request): RedirectResponse
    {
        $data = $request->all();
        $absence = new Absence();

        if ($data['fin'] < $data['debut']) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['date_fin' => __('La date de fin ne peut pas être antérieure à la date de début.')]);
        }

        $absence->user_id = $data['user'];
        $absence->motif_id = $data['motif'];
        $absence->date_debut = $data['debut'];
        $absence->date_fin = $data['fin'];
        $absence->status = $data['status'];

        $absence->save();

        Cache::forget('absences_with_trashed');
        Cache::forget('users_with_trashed');
        Cache::forget('motifs_with_trashed');

        session()->flash('message', ['type' => 'success', 'text' => __('Absence created successfully.')]);

        if (Auth::check() && Auth::user() !== null && Auth::user()->email !== null) {
            Mail::to(Auth::user()->email)->send(new CreateAbsence($absence));
        }

        return redirect()->route('absence.index');
    }



    /**
     * @param Absence $absence
     * @return View
     */
    public function show(Absence $absence): View
    {
        if (Auth::user() && Auth::user()->can('absence-show')) {
            return view('absence.show', compact('absence'));
        }
        abort(403);
    }

    /**
     * @param Absence $absence
     * @return View
     */
    public function edit(Absence $absence): View
    {
        if (Auth::user() && Auth::user()->can('absence-edit')) {
            $users = User::all();
            $motifs = Motif::all();

            return view('absence.edit', compact('absence', 'motifs', 'users'));
        }
        abort(403);
    }

    /**
     * @param AbsenceRequest $request
     * @param Absence $absence
     * @return RedirectResponse
     */
    public function update(AbsenceRequest $request, Absence $absence): RedirectResponse
    {
        if (Auth::user() && Auth::user()->can('absence-edit')) {

            $oldname = $absence->user->name;
            $oldtitre = $absence->motif->titre;
            $olddebut = $absence->date_debut;
            $oldfin = $absence->date_fin;

            $data = $request->all();
            $absence->user_id = $data['user'];
            $absence->motif_id = $data['motif'];
            $absence->date_debut = $data['debut'];
            $absence->date_fin = $data['fin'];

            if ($data['fin'] < $data['debut']) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['date_fin' => __('La date de fin ne peut pas être antérieure à la date de début.')]);
            }

            $absence->save();

            Cache::forget('absences_with_trashed');
            Cache::forget('users_with_trashed');
            Cache::forget('motifs_with_trashed');

            session()->flash('message', ['type' => 'success', 'text' => __('Absence edited successfully.')]);

            if (Auth::check()) {
                Mail::to(Auth::user()->email)->send(new EditAbsence($absence, $oldname, $oldtitre, $olddebut, $oldfin));
            }

            return redirect()->route('absence.index');
        }
        abort(403);
    }

    /**
     * @param Absence $absence
     * @return RedirectResponse
     */
    public function destroy(Absence $absence): RedirectResponse
    {
        if (Auth::user() && Auth::user()->can('absence-delete')) {
            $oldname = $absence->user->name;
            $oldtitre = $absence->motif->titre;
            $olddebut = $absence->date_debut;
            $oldfin = $absence->date_fin;
            $oldstatus = $absence->status;

            $absence->delete();

            if (Auth::check()) {
                Mail::to(Auth::user()->email)->send(new DeleteAbsence($absence, $oldname, $oldtitre, $olddebut, $oldfin, $oldstatus));
            }

            Cache::forget('absences_with_trashed');
            Cache::forget('users_with_trashed');
            Cache::forget('motifs_with_trashed');

            session()->flash('message', ['type' => 'success', 'text' => __('Absence deleted successfully.')]);

            return redirect()->route('absence.index');
        }
        abort(403);
    }

    /**
     * @param Absence $absence
     * @return RedirectResponse
     */
    public function restore(Absence $absence): RedirectResponse
    {
        if (Auth::user() && Auth::user()->can('absence-restore')) {
            $absence->restore();
            session()->flash('message', ['type' => 'success', 'text' => __('Absence restored successfully.')]);

            Cache::forget('absences_with_trashed');
            Cache::forget('users_with_trashed');
            Cache::forget('motifs_with_trashed');

            if (Auth::check()) {
                Mail::to(Auth::user()->email)->send(new RestoreAbsence($absence));
            }

            return redirect()->route('absence.index');
        }
        abort(403);
    }

    /**
     * @param Absence $absence
     * @return View
     */
    public function demande(Absence $absence): View
    {
        if (Auth::user() && Auth::user()->isA('admin')) {
            $absences = Absence::all();

            return view('absence.demande', compact('absences'));
        }
        abort(403);
    }

    /**
     * @param StatusRequest $request
     * @param Absence $absence
     * @return RedirectResponse
     */
    public function status(StatusRequest $request, Absence $absence): RedirectResponse
    {
        if (Auth::user() && Auth::user()->isA('admin')) {
            $data = $request->all();

            $absence->status = $data['status'];
            $absence->save();

            Cache::forget('absences_with_trashed');

            return redirect()->route('absence.demande');
        }
        abort(403);
    }
}
