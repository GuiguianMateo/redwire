<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbsenceRequest;
use App\Http\Requests\StatusRequest;
use App\Mail\CreateAbsence;
use App\Mail\EditAbsence;
use App\Mail\DeleteAbsence;
use App\Mail\RestoreAbsence;
use Illuminate\Support\Facades\Auth;
use App\Models\Absence;
use App\Models\Motif;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AbsenceController extends Controller
{
    /**
     * Summary of index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = User::withTrashed()->get();
        $motifs = Motif::withTrashed()->get();
        $absences = Absence::withTrashed()->get();

        return view('absence.index', compact('absences', 'users', 'motifs'));
    }

    /**
     * Summary of create
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        // if (Auth::user()->can('absence-create')) {
            $users = User::all();
            $motifs = Motif::all();
            Absence::all();
            return view('absence.create', compact('users', 'motifs'));
        // }
        // abort('403');
    }

    /**
     * Summary of store
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function store(AbsenceRequest $request)
    {
        // if (Auth::user()->can('absence-create')) {

            $data = $request->all();
            $absence = new absence();

            $absence->user_id = $data['user'];
            $absence->motif_id = $data['motif'];
            $absence->date_debut = $data['debut'];
            $absence->date_fin = $data['fin'];
            $absence->status = $data['status'];

            $absence->save();

            $users = User::all();
            $motifs = Motif::all();
            $absences = Absence::all();
            session()->flash('message',value: ['type' => 'success', 'text' => __("Absence create successfully.")]);

            Mail::to(users: Auth::user()->email)->send(mailable: new CreateAbsence($absence));

            return redirect()->route('absence.index', compact('absences', 'motifs', 'users'));
        // }
        // abort('403');
    }

    /**
     * Summary of show
     *
     * @param \App\Models\Absence $absence
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
     * @param \App\Models\Absence $absence
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
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Absence $absence
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

            $users = User::all();
            $motifs = Motif::all();
            $absences = Absence::all();
            session()->flash('message',value: ['type' => 'success', 'text' => __("Absence edit successfully.")]);

            Mail::to(users: Auth::user()->email)->send(new EditAbsence($absence, $oldname, $oldtitre, $olddebut, $oldfin));

            return redirect()->route('absence.index', compact('absences', 'motifs', 'users'));
        }
        abort('403');
    }

    /**
     * Summary of destroy
     *
     * @param \App\Models\Absence $absence
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

            $absences = Absence::all();
            session()->flash('message',value: ['type' => 'success', 'text' => __("Absence delete successfully.")]);

            return redirect()->route('absence.index', compact('absences'));
        }
        abort('403');
    }

    /**
     * Summary of restore
     *
     * @param \App\Models\Absence $absence
     *
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function restore(Absence $absence)
    {
        if (Auth::user()->can('absence-delete')) {

        $absence->restore();
        session()->flash('message',value: ['type' => 'success', 'text' => __("Absence restore successfully.")]);

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
            $absences = Absence::all();

            return view('absence.demande', compact('absences'));
        }
        abort('403');
    }
}
