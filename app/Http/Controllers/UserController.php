<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        // funciona en x6 y x8
        $users = User::latest()->get();
        // retorna models/User con esta estructura:
        // App\Models\User {#1204 ▼
        //     #fillable: array:3 [▶]
        //     #hidden: array:2 [▶]
        //     #casts: array:1 [▶]
        //     #connection: "mysql"
        //     #table: "users"
        //     #primaryKey: "id"
        //     #keyType: "int"
        //     +incrementing: true
        //     #with: []
        //     #withCount: []
        //     +preventsLazyLoading: false
        //     #perPage: 15
        //     +exists: true
        //     +wasRecentlyCreated: false
        //     #attributes: array:8 [▶]
        //     #original: array:8 [▶]
        //     #changes: []
        //     #classCastCache: []
        //     #dates: []
        //     #dateFormat: null
        //     #appends: []
        //     #dispatchesEvents: []
        //     #observables: []
        //     #relations: []
        //     #touches: []
        //     +timestamps: true
        //     #visible: []
        //     #guarded: array:1 [▶]
        //     #rememberTokenName: "remember_token"
        //   } En este caso nos conviene hacerlo de esta manera para usar el delete directamente.
        
        // $users = DB::table('users')->get();
        
        // retorna un objeto sólo con los datos, ejemplo:
        //         {#996 ▼
        //   +"id": 3
        //   +"name": "Neha Schroeder"
        //   +"email": "gusikowski.travon@example.org"
        //   +"email_verified_at": "2021-06-02 15:43:04"
        //   +"password": "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi"
        //   +"remember_token": "Td6dLo7G1y"
        //   +"created_at": "2021-06-02 15:43:09"
        //   +"updated_at": "2021-06-02 15:43:09"
        // }
        //Que es originalmente viene de una clase stdClass, clase estandar que nace vacia y se le asignan luego propiedades y metodos. 
        return view('users.index',[
            'users' => $users
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'=> ['required'],
            'email' => ['required','email','unique:users'],
            'password' => ['required','min:8'],
        ]);
        //Acá harémos las validaciones correspondientes


        //Archivo que representa la tabla de usuarios
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        //bcrypt es la libreria para encryptar <3

        return back();
    }
    public function destroy(User $user)
    {
        //este método espera un parametro por navegacion 'users/{user}'
        $user->delete();
        //es necesario devolver/retornar una vista, en este este caso con back() retornamos a la vista anterior
        return back();
    }
}
