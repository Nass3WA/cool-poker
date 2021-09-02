<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    // Fonction qui renvoie la vue vers la page register utilisateur
    public function create(){
        
        return view('users.register');
    }
    
     public function store(Request $request)
     {
        // Création des conditions pour les champs à remplir 
        $request->validate([
            'username' => 'required|min:3|unique:users',
            'firstname'=>'min:3',
            'lastname'=>'min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);
        
        //Enregistrement de l'image dans le dossier image si l'utilisateur a ajouté un avatar
        if($request->file('avatar') === null) {
            $path = null;
        }else{
            $path = $request->file('avatar')->store('public/images');
            $path = str_replace('public', 'storage', $path);
        }
        
        // Ajout de l'utilisateur dans la base de données via une requête SQL
        $user = DB::table('users')->insert([
                    'username' => $request->input('username'),
                    'firstname' => $request->input('firstname'),
                    'lastname' => $request->input('lastname'),
                    'email' => $request->input('email'),
                    'avatar' => $path,
                    'password' => bcrypt($request->input('password'))
                ]);
                
        return redirect()->route('users.login');
    }
    
    public function login()
    {
        return view('users.login');
    }
    
    public function signin(Request $request)
    {
        // Validation du formulaire et récupération des identifiants
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        // Si les identifiants sont corrects, connexion de l'utilisateur
        // et redirection vers la la homepage
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect()->intended(route('homepage'));
        }
        
        // Retour sur le formulaire avec un message d'erreur
        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas',
        ]);
    }    
    
    public function update() 
    {
        return view('users.update');
    }
    
    public function edit(Request $request)
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        // $user = DB::table('users')
        //     ->select('username', 'firstname', 'lastname', 'email', 'avatar')
        //     ->where('id', $user_id)
        //     ->get();
        // var_dump($user);
        // exit;
        
        //Enregistrement de l'image dans le dossier image si l'utilisateur a ajouté un avatar
        if($request->file('avatar') === null) {
            $path = auth()->user()->avatar;
        }else{
            $path = $request->file('avatar')->store('public/images');
            $path = str_replace('public', 'storage', $path);
        }
        
        if($request->input('password') === null) {
            
            $user->update([
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'avatar' =>  $path
            ]);
        }else{
                $user->update([
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'password' => bcrypt($request->input('password')),
                'avatar' =>  $path
            ]);
        }
        return redirect()->route('homepage');
    }
    
     public function logout()
    {
        Auth::logout();
        return redirect()->route('homepage');
    }
}

                
