<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function index() {
        return view('welcome');
    }

    public function editor() {
        return view('pages.editor');
    }

    public function admin(Request $request) {
        $data = $request->all();

        if (isset($data['order'])) {
            if($data['order'] === 'date') {
                $users = User::orderByRaw('created_at DESC')->get();
            } else {
                $users = User::orderByRaw('LOWER(name) ' . $data['order'])->get();
            }
        } else {
            $users = User::all();
        }
        return view('pages.admin', compact('users'));
    }

    //TODO:User moze odstranit svoj profil
    public function delete(Request $request) {
        $data = $request->validate([
            'id' => 'required|integer|exists:users,id'
        ]);

        if (Auth::user()->getAuthIdentifier() == $data['id']) { // Admin nemôže vymazať samého seba
            return redirect()->back();
        }

        $user = User::findOrFail($data['id']);
        $user->delete();

        return redirect()->back();
    }
}
