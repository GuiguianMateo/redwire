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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class AbsenceController extends Controller
{
    /**
     * Summary of index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
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
     * Summary of create
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $users = User::all();
        $motifs = Motif::all();
        Absence::all();

        return view('absence.create', compact('users', 'motifs'));

    }

    /**
     * Summary of store
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function store(AbsenceRequest $request)
    {
        $data = $request->all();
        $absence = new absence();

        $absence->user_id = $data['user'];
        $absence->motif_id = $data['motif'];
        $absence->date_debut = $data['debut'];
        $absence->date_fin = $data['fin'];
        $absence->status = $data['status'];

        $absence->save();

        Cache::forget('absences_with_trashed');
        Cache::forget('users_with_trashed');
        Cache::forget('motifs_with_trashed');

        $users = User::all();
        $motifs = Motif::all();
        $absences = Absence::all();
        session()->flash('message', value: ['type' => 'success', 'text' => __('Absence create successfully.')]);

        Mail::to(users: Auth::user()->email)->send(mailable: new CreateAbsence($absence));

        return redirect()->route('absence.index', compact('absences', 'motifs', 'users'));
    }

    /**
     * Summary of show
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Absence $absence)
    {
        if (Auth::user()->can('absence-show')) {
            return view('absence.show', compact('absence'));
        }
        abort('403');
    }

    /**
     * Summary of edit
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Absence $absence)
    {
        if (Auth::user()->can('absence-edit')) {
            $users = User::all();
            $motifs = Motif::all();

            return view('absence.edit', compact('absence', 'motifs', 'users'));
        }
        abort('403');
    }

    /**
     * Summary of update
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function update(AbsenceRequest $request, Absence $absence)
    {
        if (Auth::user()->can('absence-edit')) {
            $oldname = $absence->user->name;
            $oldtitre = $absence->motif->titre;
            $olddebut = $absence->date_debut;
            $oldfin = $absence->date_fin;

            $data = $request->all();
            $absence->user_id = $data['user'];
            $absence->motif_id = $data['motif'];
            $absence->date_debut = $data['debut'];
            $absence->date_fin = $data['fin'];

            $absence->save();

            Cache::forget('absences_with_trashed');
            Cache::forget('users_with_trashed');
            Cache::forget('motifs_with_trashed');

            $users = User::all();
            $motifs = Motif::all();
            $absences = Absence::all();
            session()->flash('message', value: ['type' => 'success', 'text' => __('Absence edit successfully.')]);

            Mail::to(users: Auth::user()->email)->send(new EditAbsence($absence, $oldname, $oldtitre, $olddebut, $oldfin));

            return redirect()->route('absence.index', compact('absences', 'motifs', 'users'));
        }
        abort('403');
    }

    /**
     * Summary of destroy
     *
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Absence $absence)
    {
        if (Auth::user()->can('absence-delete')) {
            $oldname = $absence->user->name;
            $oldtitre = $absence->motif->titre;
            $olddebut = $absence->date_debut;
            $oldfin = $absence->date_fin;
            $oldstatus = $absence->status;

            $absence->delete();
            Mail::to(users: Auth::user()->email)->send(new DeleteAbsence($absence, $oldname, $oldtitre, $olddebut, $oldfin, $oldstatus));

            Cache::forget('absences_with_trashed');
            Cache::forget('users_with_trashed');
            Cache::forget('motifs_with_trashed');

            $absences = Absence::all();
            session()->flash('message', value: ['type' => 'success', 'text' => __('Absence delete successfully.')]);

            return redirect()->route('absence.index', compact('absences'));
        }
        abort('403');
    }

    /**
     * Summary of restore
     *
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function restore(Absence $absence)
    {
        if (Auth::user()->can('absence-restore')) {
            $absence->restore();
            session()->flash('message', value: ['type' => 'success', 'text' => __('Absence restore successfully.')]);

            Cache::forget('absences_with_trashed');
            Cache::forget('users_with_trashed');
            Cache::forget('motifs_with_trashed');

            Mail::to(users: Auth::user()->email)->send(new RestoreAbsence($absence));
            $absences = Absence::all();

            return redirect()->route('absence.index', compact('absences'));
        }
        abort('403');
    }

    public function demande(Absence $absence)
    {
        if (Auth::user()->isA('admin')) {
            $absences = Absence::all();

            return view('absence.demande', compact('absences'));
        }
        abort('403');
    }

    public function status(StatusRequest $request, Absence $absence)
    {
        if (Auth::user()->isA('admin')) {
            $data = $request->all();

            $absence->status = $data['status'];
            $absence->save();

            Cache::forget('absences_with_trashed');

            $absences = Absence::all();
            return view('absence.demande', compact('absences'));
        }
        abort('403');
    }
}
