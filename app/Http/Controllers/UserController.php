<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    /**
     * @todo login, signin and logout would be better in a seperate controller (e.g. AuthController)
     */

    /**
     * Login Form
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function login()
    {
        return view('users.login');
    }

    /**
     * Sign In
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function signin(Request $request)
    {
        // Validation du formulaire et récupération des identifiants
        $credentials = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        // Si les identifiants sont corrects, connexion de l'utilisateur
        // et redirection vers la la homepage
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('homepage'))->with([
                'status' => 'success',
                'message' => 'Welcome back ' . auth()->user()->username,
            ]);
        }

        // Retour sur le formulaire avec un message d'erreur
        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas',
        ]);
    }

    /**
     * Logout
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('homepage');
    }

    /**
     * Show the form for creating a new User.
     *
     * Signup Form
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.register');
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Création des conditions pour les champs à remplir

        $data = $request->validate([
            'username' => 'required|min:3|unique:users,username',
            'firstname'=>'required|min:3',
            'lastname'=>'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        //Enregistrement de l'image dans le dossier image si l'utilisateur a ajouté un avatar
        $path = null;
        if ($request->file('avatar') !== null){
            $path = $request->file('avatar')->store('images');
        }

        // Ajout de l'utilisateur dans la base de données via une requête SQL
        $user = DB::table('users')->insert([
            'username' => $data['username'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'avatar' => $path,
            'password' => Hash::make($data['password'])
        ]);

        return redirect(route('users.login'))->with([
            'status' => 'success',
            'message' => 'User Created',
        ]);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit()
    {
        return view('users.edit');
    }

    /**
     * Update the specified User in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $user_id = auth()->user()->id;

        // !! Always Validate your Data !!
        $data = $request->validate([
            'username' => [
                'required',
                'min:3',
                Rule::unique('users')->ignore($user_id)
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user_id)
            ],
            'firstname'=>'required|min:3',
            'lastname'=>'required|min:3',
            'password' => 'nullable|min:8|confirmed',
            'avatar' => 'nullable|file',
        ]);

        //Enregistrement de l'image dans le dossier image si l'utilisateur a ajouté un avatar

        // Update de l'utilisateur dans la base de données via une requête SQL
        DB::table('users')
            ->where('id', $user_id)
            ->update([
                'username' => $data['username'],
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
            ]);

        // Update avatar if needed
        if ($request->file('avatar') !== null){
            $path = $request->file('avatar')->store('images');

            DB::table('users')
                ->where('id', $user_id)
                ->update([
                    'avatar' => $path,
                ]);
        }

        // Update Password if needed
        if ($data['password'] !== null) {
            DB::table('users')
                ->where('id', $user_id)
                ->update([
                    'password' => Hash::make($data['password'])
                ]);
        }

        return redirect(route('homepage'))->with([
            'status' => 'success',
            'message' => 'User Updated',
        ]);
    }

}
