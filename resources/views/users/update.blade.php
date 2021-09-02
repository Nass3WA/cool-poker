@extends('layout')

@section('title', 'Modifier votre profil')

@section('content')
    
    <h1>Modifier votre profil</h1>
    
     <section>
        <form method="post" action="{{ route('users.edit') }}" enctype = "multipart/form-data">
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
    	        <div>
    	            <label for="username">Pseudo :</label>
    	            <input type="text" name="username" id="username" value="{{ auth()->user()->username }}">
    	        </div>
    	        <div>
    	            <label for="firstname">Prénom :</label>
    	            <input type="text" name="firstname" id="firstname" value="{{ auth()->user()->firstname }}">
    	        </div>
    	        <div>
    	            <label for="lastname">Nom :</label>
    	            <input type="text" name="lastname" id="lastname" value="{{ auth()->user()->lastname }}">
    	        </div>
    	        <div>
    	            <label for="email">Email :</label>
    	            <input type="email" name="email" id="email" value="{{ auth()->user()->email }}">
    	        </div>
                <div>
                    <label for="avatar">Avatar :</label>
                    <input type="file"  class="avatar" name="avatar" id="avatar" accept="image/*">
                </div>
    	    </fieldset>
    	    
    	    <fieldset>
                <div>
                    <label for="password">Mot de passe :</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div>
                    <label for="password-confirmation">Confirmer le mot de passe :</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password-confirmation">
                </div>			        
    	    </fieldset>
    	    
    		<div class="submit">
    			<button type="submit">Modifier !</button>
    		</div>
		</form>
	</section>

@endsection