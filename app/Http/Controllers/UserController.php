<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Absence;
use App\Models\Motif;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Summary of index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(User $users)
    {
        //$users = User::all();
        $users = User::withTrashed()->get();

        return view('User.index', compact('users'));
    }

    /**
     * Summary of create
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
    }

    /**
     * Summary of store
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return void
     */
    public function store(UserRequest $request)
    {
    }

    /**
     * Summary of show
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        if (Auth::user()->isA('admin') || Auth::id() === $user->id) {
            $absences = Absence::where('user_id', $user->id)->get();
            $motifs = Motif::all();

            return view('user.show', compact('user', 'absences', 'motifs'));
        }

        abort(403, 'Unauthorized action.');
    }

    /**
     * Summary of edit
     *
     * @return void
     */
    public function edit(User $user)
    {
        if (Auth::user()->can('user-edit')) {
            return view('user.edit', compact('user'));
        }
        abort('403');
    }

    /**
     * Summary of update
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return void
     */
    public function update(UserRequest $request, User $user)
    {
        if (Auth::user()->can(abilities: 'user-edit')) {
            $data = $request->all();

            $user->name = $data['name'];
            $user->email = $data['email'];

            $user->save();
            session()->flash('message', value: ['type' => 'success', 'text' => __('User edit successfully.')]);

            $users = User::all();

            return redirect()->route('user.index', compact('users'));
        }
        abort('403');
    }

    /**
     * Summary of destroy
     *
     * @return void
     */
    public function destroy(User $user)
    {
        if (Auth::user()->can('user-delete')) {
            $nb = Absence::where('user_id', $user->id)->count();

            if ($nb === 0) {
                $user->delete();
                session()->flash('message', value: ['type' => 'success', 'text' => __('User deleted successfully.')]);
            } else {
                session()->flash(key: 'message', value: ['type' => 'error', 'text' => __('The user is still in use with :count absence(s).', ['count' => $nb])]);
            }

            return redirect()->route('user.index');
        }
        abort('403');
    }

    /**
     * Summary of restore
     *
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function restore(User $user)
    {
        if (Auth::user()->can('user-delete')) {
            $user->restore();
            $users = User::all();

            session()->flash('message', value: ['type' => 'success', 'text' => __('User restore successfully.')]);

            return redirect()->route('user.index', compact('users'));
        }
        abort('403');
    }
}
