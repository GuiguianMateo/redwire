<?php

namespace App\Http\Controllers;

use App\Http\Requests\MotifRequest;
use App\Mail\CreateMotif;
use App\Mail\DeleteMotif;
use App\Mail\EditMotif;
use App\Mail\RestoreMotif;
use App\Models\Absence;
use App\Models\Motif;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class MotifController extends Controller
{
    /**
     * Summary of index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $motifs = Cache::remember('motifs_with_trashed', 60 * 60 * 24, function () {
            return Motif::withTrashed()->get();
        });

        return view('motif.index', compact('motifs'));
    }

    /**
     * Summary of create
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        if (Auth::user()->can('motif-create')) {
            Motif::all();

            return view('motif.create');
        }
        abort('403');
    }

    /**
     * Summary of store
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function store(MotifRequest $request)
    {
        if (Auth::user()->can('motif-create')) {
            $data = $request->all();
            $motif = new motif();

            $motif->titre = $data['titre'];
            $motif->is_accessible_salarie = $data['is_accessible'];

            $motif->save();

            Cache::forget('motifs_with_trashed');

            Mail::to(users: Auth::user()->email)->send(new CreateMotif($motif));

            session()->flash('message', value: ['type' => 'success', 'text' => __('Reason create successfully.')]);
            $motifs = Motif::all();

            return redirect()->route('motif.index', compact('motifs'));
        }
        abort('403');
    }

    /**
     * Summary of show
     *
     * @return void
     */
    public function show(Motif $motif)
    {
    }

    /**
     * Summary of edit
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Motif $motif)
    {
        if (Auth::user()->can('motif-edit')) {
            return view('motif.edit', compact('motif'));
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
    public function update(MotifRequest $request, Motif $motif)
    {
        if (Auth::user()->can('motif-edit')) {
            $oldtitre = $motif->titre;
            $oldaccessible = $motif->is_accessible_salarie;

            $data = $request->all();
            $motif->titre = $data['titre'];
            $motif->is_accessible_salarie = $data['is_accessible'];

            $motif->save();

            Cache::forget('motifs_with_trashed');

            session()->flash('message', value: ['type' => 'success', 'text' => __('Reason edit successfully.')]);

            Mail::to(users: Auth::user()->email)->send(new EditMotif($motif, $oldtitre, $oldaccessible));

            $motifs = Motif::all();

            return redirect()->route('motif.index', compact('motifs'));
        }

        abort(403);
    }

    /**
     * Summary of destroy
     *
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Motif $motif)
    {
        if (Auth::user()->can('motif-delete')) {
            $nb = Absence::where('motif_id', $motif->id)->count();

            if ($nb === 0) {
                $oldtitre = $motif->titre;
                $oldaccessible = $motif->is_accessible_salarie;

                $motif->delete();

                Cache::forget('motifs_with_trashed');

                session()->flash('message', value: ['type' => 'success', 'text' => __('Reason delete successfully.')]);

                Mail::to(users: Auth::user()->email)->send(mailable: new DeleteMotif($oldtitre, $oldaccessible));
            } else {
                session()->flash('message', value: ['type' => 'error', 'text' => __('The reason is still in use with :count absence(s).', ['count' => $nb])]);
            }

            $motifs = Motif::all();

            return redirect()->route('motif.index', compact('motifs'));
        }
        abort('403');
    }

    /**
     * Summary of restore
     *
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function restore(Motif $motif)
    {
        if (Auth::user()->can('motif-delete')) {
            $motif->restore();

            Cache::forget('motifs_with_trashed');

            session()->flash('message', value: ['type' => 'success', 'text' => __('Reason restore successfully.')]);

            Mail::to(users: Auth::user()->email)->send(new RestoreMotif($motif));

            $motifs = Motif::all();

            return redirect()->route('motif.index', compact('motifs'));
        }
        abort('403');
    }
}
