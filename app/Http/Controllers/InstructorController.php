<?php

namespace App\Http\Controllers;

use App\Models\instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return response([
            'instructors' => instructor::all(),
        ], 200);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function show(instructor $instructor) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function edit(instructor $instructor) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, instructor $instructor) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function destroy(instructor $instructor) {
        //
    }
}
