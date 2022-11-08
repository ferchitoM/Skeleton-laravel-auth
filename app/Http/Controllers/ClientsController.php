<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Roles;
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
        $client_list = DB::select(
            'SELECT u.*, r.name AS role 
            FROM users u, roles r 
            WHERE roles_id = r.id
            AND r.code = "U"
            AND deleted_at IS NULL  
            ORDER BY u.created_at DESC'
        );
        //NOTA: deleted_at IS NULL es para listar los usuarios no eliminados con softdeletes

        $clients_list_deleted = DB::select(
            'SELECT u.*, r.name AS role 
            FROM users u, roles r 
            WHERE roles_id = r.id
            AND r.code = "U"
            AND deleted_at IS NOT NULL  
            ORDER BY u.created_at DESC'
        );

        return response(
            [
                'client_list' => $client_list,
                'client_list_deleted' => $clients_list_deleted
            ],
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
            'image' => 'nullable|image'
        ]);

        //Save image in server and get its url
        $url_image = $this->validate_image($request);

        $user = User::create([
            'roles_id' => 2, //All registered user have the USER role (id=2)
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $url_image,
        ]);

        return response(
            [
                'message' => 'Cliente creado exitósamente.',
                'new_user' => $user //Nuevo usuario creado
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
        ]);

        //Guardar nueva imagen
        if ($request->updated) {

            $request->validate([
                'image' => 'nullable|image'
            ]);

            //Eliminar la imagen anterior
            if (File::exists(public_path($client->image)))
                File::delete(public_path($client->image));

            $client->image = $this->validate_image($request);
        }

        $client->name = $request->name;
        $client->email = $request->email;
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

    public function restore($id) {
        $client = User::withTrashed()->find($id); //withTrashed() to find soft-deleted users
        $client->restore();

        return response([
            'message' => 'Cliente restablecido exitósamente.'
        ]);
    }

    public function validate_image($request) {

        if ($request->hasfile('image')) {
            $name = uniqid() . time() . '.' . $request->file('image')->getClientOriginalExtension(); //46464611435281365.jpg
            $request->file('image')->storeAs('public', $name);
            return '/storage' . '/' . $name; //uploads/46464611435281365.jpg

        } else {

            return null;
        }
    }
}
