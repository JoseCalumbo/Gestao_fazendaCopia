<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // public function index()
    // {
    //     $users = User::orderBy('name')
    //         ->paginate(10);

    //     return response()->json($users);
    // }

    public function index()
    {
        $users = User::orderBy('name')->paginate(5);

        // Se for requisição AJAX, retorna JSON com informações de paginação
        if (request()->expectsJson()) {
            return response()->json([
                'data' => $users->items(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem(),
            ]);
        }

        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $foto = null;

        if ($request->hasFile('foto')) {

            $nomeFoto = time().'_'.$request->file('foto')->getClientOriginalName();

            $request->file('foto')->move(
                public_path('uploads/users'),
                $nomeFoto
            );

            $foto = $nomeFoto;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefone' => $request->telefone,
            'foto' => $foto,
            'nivel' => $request->nivel,
            'estado' => $request->estado,
        ]);

        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }

    // public function store(Request $request)
    // {
    //     $foto = null;

    //     if ($request->hasFile('foto')) {
    //         // Mantemos a sua lógica de gerar um nome único
    //         $nomeFoto = time().'_'.$request->file('foto')->getClientOriginalName();

    //         // Isso vai salvar em: storage/app/public/uploads/users/
    //         $request->file('foto')->storeAs('uploads/users', $nomeFoto, 'public');

    //         $foto = $nomeFoto;
    //     }

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'telefone' => $request->telefone,
    //         'foto' => $foto,
    //         'nivel' => $request->nivel,
    //         'estado' => $request->estado,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'user' => $user,
    //     ]);
    // }

    // Apaga os dados do user
    public function destroy($id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilizador não encontrado',
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Utilizador eliminado com sucesso',
        ]);
    }

    // Mostra apenas os dados para serem editados
    public function show($id)
    {
        return response()->json(
            User::findOrFail($id)
        );
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->telefone = $request->telefone;
        $user->nivel = $request->nivel;
        $user->estado = $request->estado;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }


    // ...
    // public function destroy($id)
    // {
    //     $user = User::find($id);

    //     if (! $user) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Utilizador não encontrado',
    //         ], 404);
    //     }

    //     // O PADRÃO LARAVEL: Se o utilizador tiver foto, removemos ela do disco público
    //     if ($user->foto) {
    //         Storage::disk('public')->delete('uploads/users/'.$user->foto);
    //     }

    //     // Agora sim, deletamos o registo do banco de dados seguro
    //     $user->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Utilizador eliminado com sucesso',
    //     ]);
    // }
}
