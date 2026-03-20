<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index() {
        return view('welcome');
    }

    public function editor() {
        return view('pages.editor');
    }

    public function admin() {
        $users = User::all();
        return view('pages.admin', compact('users'));
    }

    //TODO:User moze odstranit svoj profil
    public function delete(Request $request) {
        $data = $request->validate([
            'id' => 'required|integer|exists:users,user_id'
        ]);

        $user = User::findOrFail($data['id']);
        $user->delete();

        return redirect()->back();
    }
}
