<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Absence;
use App\Models\Motif;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $users = Cache::remember('users_with_trashed', 60 * 60 * 24, function () {
            return User::withTrashed()->get();
        });

        $this->compteurConge();

        return view('user.index', compact('users'));
    }

    /**
     * Show the specified resource.
     *
     * @param  User  $user
     * @return View
     */
    public function show(User $user): View
    {
        $authUser = Auth::user();

        if ($authUser && ($authUser->isA('admin') || Auth::id() === $user->id)) {
            $absences = Absence::where('user_id', $user->id)->get();
            $motifs = Motif::all();

            return view('user.show', compact('user', 'absences', 'motifs'));
        }

        abort(403, 'Unauthorized action.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return View
     */
    public function edit(User $user): View
    {
        if (Auth::user() && Auth::user()->can('user-edit')) {
            return view('user.edit', compact('user'));
        }
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserRequest  $request
     * @param  User  $user
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        if (Auth::user() && Auth::user()->can('user-edit')) {
            $data = $request->validated();

            $user->name = (string) $data['name'];
            $user->email = (string) $data['email'];
            $user->save();

            Cache::forget('users_with_trashed');

            session()->flash('message', [
                'type' => 'success',
                'text' => __('User edited successfully.')
            ]);

            return redirect()->route('user.index');
        }
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        if (Auth::user() && Auth::user()->can('user-delete')) {
            $nb = Absence::where('user_id', $user->id)->count();

            if ($nb === 0) {
                $user->delete();
                Cache::forget('users_with_trashed');
                session()->flash('message', [
                    'type' => 'success',
                    'text' => __('User deleted successfully.')
                ]);
            } else {
                session()->flash('message', [
                    'type' => 'error',
                    'text' => __('The user is still in use with :count absence(s).', ['count' => $nb])
                ]);
            }

            return redirect()->route('user.index');
        }
        abort(403);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  User  $user
     * @return RedirectResponse
     */
    public function restore(User $user): RedirectResponse
    {
        if (Auth::user() && Auth::user()->can('user-restore')) {
            $user->restore();
            Cache::forget('users_with_trashed');

            session()->flash('message', [
                'type' => 'success',
                'text' => __('User restored successfully.')
            ]);

            return redirect()->route('user.index');
        }
        abort(403);
    }

    private function compteurConge(){
        $date = Carbon::now();
        if ($date->startOfMonth()->startOfDay()){
            $users = User::all();
            foreach ($users as $user){
                $user->jour_conge+=2.5;
                $user->save();
            }
        }
    }
}
