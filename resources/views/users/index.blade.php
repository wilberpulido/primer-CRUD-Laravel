<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    </head>
    <body class="container">
        <div class="row">
            <div class="col-sm-8 mx-auto">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        @if ($errors-> any())
                        {{-- Variable global que almacena todos los errores --}}
                        <div class="alert alert-danger">
                            {{-- De esta manera rescatas todos los errores, con all(), acá lo recorre e imprime --}}
                            @foreach ($errors->all() as $error)
                                -{{$error}} <br>
                            @endforeach
                        </div>
                        @endif   
                        <form action="{{ route('users.store')}}"  method='POST'>
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="text" name="name" class="form-control" placeholder="Nombre" value="{{old('name')}}">
                                </div>
                                <div class="col-sm-4">
                                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{old('email')}}">
                                    {{-- helper old sirve para guardar el último elemento que se envio con el nombre señalado: name,email, si una validación falla seran retornados --}}
                                </div>
                                <div class="col-sm-3">
                                    <input type="password" name="password" class="form-control" placeholder="Contraseña">
                                </div>
                                <div class="col-auto">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>&nbsp;</th>
                        {{-- <!-- &nbsp; se usa para dejar un espacio, abajo pondremos el boton de eliminar en este caso --> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <form action="{{ route('users.destroy', ['user'=>$user->id])}}" method="POST">
                                        {{-- users.destroy es el nombre asignado para la ruta de eliminar --}}
                                        {{-- <!-- route is the helper for Laravel --> --}}
                                        {{-- route('users.destroy', ['user'=>$user->id]) funciona si uso $users = DB::table('users')->get(); --}}
                                        @method('DELETE')
                                        @csrf
                                        {{-- $user sirve para pasar como parametro porque tiene el mismo nombre que en la ruta: 'users/{user}'--}}
                                        {{-- El metodo es POST, pero internamente LARAVEL espera que le pidamos elimnar porque así lo configuramos en routes/web.php--}}
                                        {{-- genera un token que le dice a laravel que el formulario realmente es de nuetro proyecto y no es un form externo--}}
                                        <input 
                                            type="submit" 
                                            value="Eliminar" 
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Desea eliminar... ?')"
                                        />
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
