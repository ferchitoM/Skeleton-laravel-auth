<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;


class ClientsController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $clients_list = DB::select(
            'SELECT u.*, r.name AS role 
            FROM users u, roles r 
            WHERE roles_id = r.id
            AND r.code != "A"
            ORDER BY u.created_at DESC'
        );

        return response(
            ['client_list' => $clients_list],
            200
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'image' => 'nullable|max:1024'
        ]);

        $user = User::create([
            'roles_id' => 2, //All registered user have the USER role (id=2)
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $request->image,
        ]);

        return response(
            [
                'message' => 'Cliente creado exitósamente.',
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $client = User::find($id);

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $client->id,
            'image' => 'nullable'
        ]);

        $client->name = $request->name;
        $client->email = $request->email;
        $client->image = $request->image;
        $client->save();

        return response([
            'message' => 'Cliente actualizado exitósamente.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $client = User::find($id);
        $client->delete();

        return response([
            'message' => 'Cliente eliminado exitósamente.'
        ]);
    }
}
