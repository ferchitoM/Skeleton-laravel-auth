<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'image' => 'nullable|image|max:2048'
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
            'image' => 'nullable|image|max:2048'
        ]);

        $client->fill($request->all())->save();

        return response([
            'message' => 'Cliente actualizado exitósamente.'
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

    public function validate_image($request) {
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $name = uniqid() . time() . '.' . $file->getClientOriginalExtension(); //46464611435281365.jpg
            $url = public_path() . '/uploads'; // http://127.0.0.1:8000/public

            $file->move($url, $name);
            $url = 'uploads/' . $name; //uploads/46464611435281365.jpg
            return $url;
        } else {

            return null;
        }
    }
}
