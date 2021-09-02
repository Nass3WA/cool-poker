@extends('layout')

@section('title', 'Connexion')

@section('content')
    
    <h1>Connexion</h1>
    
    <form method="post" action="{{ route('users.signin') }}">
        @csrf
        @if($errors->any())
            <aside>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </aside>
        @endif
        
	    <fieldset>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password">
            </div>
            <div>
                <button>Se connecter</button>
            </div>		        
	    </fieldset>
    </form>

@endsection