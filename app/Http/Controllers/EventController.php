<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StatusRequest;
use App\Mail\CreateEvent;
use App\Mail\DeleteEvent;
use App\Mail\EditEvent;
use App\Mail\RestoreEvent;
use App\Models\Event;
use App\Models\Motif;
use App\Models\User;
use App\Models\Absence;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class EventController extends Controller
{
    /**
     * @return View
     */
    public function index(Request $request): View
    {
        // if($request->ajax()) {
        //     $data = [
        //         'events' => Event::whereDate('debut', '>=', $request->start)
        //                        ->whereDate('fin', '<=', $request->end)
        //                        ->get(['id', 'titre', 'debut', 'fin']),

        //         'absences' => Absence::with(['user', 'motif'])
        //                             ->whereDate('date_debut', '>=', $request->start)
        //                             ->whereDate('date_fin', '<=', $request->end)
        //                             ->get()
        //     ];

        //     return response()->json($data);
        // }
        $absences = Absence::all();
        return view('event.index', compact('absences'));
    }


    /**
     * @return View
     */
    public function create(): View
    {
        $users = User::all();

        return view('event.create', compact('users'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->all();
        $user_id = auth()->user()->id;

        $Event = new Event();
        $Event->name = $data['name'];
        $event->user_id = $user_id;
        $Event->date_debut = $data['debut'];
        $Event->date_fin = $data['fin'];
        $Event->save();

        // Notification de succès
        session()->flash('notification', [
            'type' => 'success',
            'text' => __('Event created successfully.')
        ]);


        return redirect()->route('calandar.index');
    }


    /**
     * @param Event $Event
     * @return View
     */
    public function show(Event $Event): View
    {
        if (Auth::user() && Auth::user()->can('Event-show')) {
            return view('event.show', compact('Event'));
        }
        abort(403);
    }

    /**
     * @param Event $Event
     * @return View
     */
    public function edit(Event $Event): View
    {
        if (Auth::user() && Auth::user()->can('Event-edit')) {
            $users = User::all();
            $motifs = Motif::all();

            return view('event.edit', compact('Event', 'motifs', 'users'));
        }
        abort(403);
    }

    /**
     * @param Request $request
     * @param Event $Event
     * @return RedirectResponse
     */
    public function update(Request $request, Event $Event): RedirectResponse
    {
        if (Auth::user() && Auth::user()->can('Event-edit')) {
            $oldname = $Event->user->name;
            $oldtitre = $Event->motif->titre;
            $olddebut = $Event->date_debut;
            $oldfin = $Event->date_fin;

            $data = $request->all();
            $Event->user_id = $data['user'];
            $Event->motif_id = $data['motif'];
            $Event->date_debut = $data['debut'];
            $Event->date_fin = $data['fin'];

            if ($data['fin'] < $data['debut']) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['date_fin' => __('La date de fin ne peut pas être antérieure à la date de début.')]);
            }

            $Event->save();

            Cache::forget('events_with_trashed');
            Cache::forget('users_with_trashed');
            Cache::forget('motifs_with_trashed');

            session()->flash('message', ['type' => 'success', 'text' => __('Event modifier avec succès.')]);

            if (Auth::check()) {
                Mail::to(Auth::user()->email)->send(new EditEvent($Event, $oldname, $oldtitre, $olddebut, $oldfin));
            }

            return redirect()->route('event.index');
        }
        abort(403);
    }

    /**
     * @param Event $Event
     * @return RedirectResponse
     */
    public function destroy(Event $Event): RedirectResponse
    {
        if (Auth::user() && Auth::user()->can('Event-delete')) {
            $oldname = $Event->user->name;
            $oldtitre = $Event->motif->titre;
            $olddebut = $Event->date_debut;
            $oldfin = $Event->date_fin;
            $oldstatus = $Event->status;

            $Event->delete();

            if (Auth::check()) {
                Mail::to(Auth::user()->email)->send(new DeleteEvent($Event, $oldname, $oldtitre, $olddebut, $oldfin, $oldstatus));
            }

            Cache::forget('events_with_trashed');
            Cache::forget('users_with_trashed');
            Cache::forget('motifs_with_trashed');

            session()->flash('message', ['type' => 'success', 'text' => __('Event deleted successfully.')]);

            return redirect()->route('event.index');
        }
        abort(403);
    }

    /**
     * @param Event $Event
     * @return RedirectResponse
     */
    public function restore(Event $Event): RedirectResponse
    {
        if (Auth::user() && Auth::user()->can('Event-restore')) {
            $Event->restore();
            session()->flash('message', ['type' => 'success', 'text' => __('Event restored successfully.')]);

            Cache::forget('events_with_trashed');
            Cache::forget('users_with_trashed');
            Cache::forget('motifs_with_trashed');

            if (Auth::check()) {
                Mail::to(Auth::user()->email)->send(new RestoreEvent($Event));
            }

            return redirect()->route('event.index');
        }
        abort(403);
    }

}
