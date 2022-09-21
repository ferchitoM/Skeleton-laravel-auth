<?php


//! EXECUTE SERVER LOCAL IP
//! php artisan serve --host 192.168.100.13

namespace App\Http\Controllers;

use App\Models\data;
use Illuminate\Http\Request;

class DataController extends Controller {


    public function index() {
        return response([
            'image_list' => data::all()
        ], 200);
    }


    public function store(Request $request) {

        $request->validate([
            'image' => 'required|string|max:500',
            'title' => 'required|string|max:100',
        ]);

        //* USE saveImage FUNCTION FROM controller.php
        $image = $this->saveImage($request->image, 'uploads');
        $request->image = $image;

        $new_data = data::create($request->all());

        return response([
            'message' => 'Nueva imagen agregada.',
            'imagen' => $new_data
        ], 200);
    }

    public function show($id) {

        return response([
            'image' => data::find($id)
        ], 200);
    }

    public function update(Request $request, $id) {

        $request->validate([
            'image' => 'required|string|max:500',
            'title' => 'required|string|max:100',
        ]);

        $image = $this->saveImage($request->image, 'uploads');
        $request->image = $image;

        $data = data::find($id)
            ->update($request->all());

        return response([
            'message' => 'Datos actualizados.',
            'imagen' => $data
        ], 200);
    }

    public function destroy($id) {

        $data = data::find($id)
            ->delete();

        return response([
            'message' => 'Imagen eliminada.',
        ], 200);
    }
}
