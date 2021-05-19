<?php

namespace App\Http\Controllers;

use App\Models\MenuAkses;
use Illuminate\Http\Request;

class MenuAksesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MenuAkses  $menuAkses
     * @return \Illuminate\Http\Response
     */
    public function show(MenuAkses $menuAkses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MenuAkses  $menuAkses
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuAkses $menuAkses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MenuAkses  $menuAkses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuAkses $menuAkses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MenuAkses  $menuAkses
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuAkses $menuAkses)
    {
        //
    }
}
