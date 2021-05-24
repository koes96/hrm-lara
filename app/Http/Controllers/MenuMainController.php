<?php

namespace App\Http\Controllers;

use App\Models\MenuMain;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class MenuMainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->input('showdata')) {
            return MenuMain::orderBy('id', 'desc')->get();
        }

        $colums = ['id', 'menu', 'judul', 'icon'];
        $lenght = $request->input('length');
        $column = $request->input('column');
        $search_input = $request->input('search');

        $query = MenuMain::select('id', 'menu', 'judul', 'icon')->orderBy($colums[$column]);

        if ($search_input) {
            $query->where(function ($query) use ($search_input) {
                $query->where('id', 'like', '%' . $search_input . '%')->orwhere('menu', 'like', '%' . $search_input . '%')->orwhere('judul', 'like', '%' . $search_input . '%')->orwher('icon', 'like', '%' . $search_input . '%');
            });
        }

        $users = $query->paginate($lenght);
        return ['data' => $users];
    }

    public function getDatas()
    {
        return MenuMain::select('id', 'judul', 'menu')->get();
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
    public function store(Request $request, MenuMain $menuMain)
    {
        $validator = Validator::make($request->all(), [
            'menu' => 'required|string|max:50',
            'judul' => 'required|string|max:50',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $menuMain::Create(
            [
                'id' => Str::uuid(),
                'menu' => $request->menu,
                'judul' => $request->judul,
                'icon' => $request->icon,
            ]
        );

        // $request->request->add(['id' => Str::uuid()]);
        // MenuMain::created($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MenuMain  $menuMain
     * @return \Illuminate\Http\Response
     */
    public function show(MenuMain $menuMain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MenuMain  $menuMain
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuMain $menuMain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MenuMain  $menuMain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuMain $menuMain, $id)
    {
        $validator = Validator::make($request->all(), [
            'menu' => 'required|string|max:50',
            'judul' => 'required|string|max:50',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $post = MenuMain::findOrFail($id);
        if ($post) {
            $menuMain->where('id', $id)->update($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MenuMain  $menuMain
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //mencari data sesuai $id
        $post = MenuMain::findOrFail($id);

        // jika data berhasil didelete maka tampilkan pesan json 
        if ($post->delete()) {
            return response([
                'Berhasil Menghapus Data'
            ]);
        } else {
            return response([
                'Tidak Berhasil Menghapus Data'
            ]);
        }
    }
    public function deletebanyak($id)
    {
        $x = explode(',', $id);

        foreach ($x as $value) {
            MenuMain::findOrFail($value)->delete();
        }
    }
}
