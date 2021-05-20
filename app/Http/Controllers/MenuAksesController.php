<?php

namespace App\Http\Controllers;

use App\Models\MenuAkses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MenuAksesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->input('showdata')) {
            return MenuAkses::orderBy('id', 'desc')->get();
        }

        $colums = ['id', 'roleid', 'menuid'];
        $lenght = $request->input('length');
        $column = $request->input('column');
        $search_input = $request->input('search');

        $query = MenuAkses::select('id', 'role_id', 'menuid')->orderBy($colums[$column]);

        if ($search_input) {
            $query->where(function ($query) use ($search_input) {
                $query->where('id', 'like', '%' . $search_input . '%')->orwhere('role_id', 'like', '%' . $search_input . '%')->orwhere('menuid', 'like', '%' . $search_input . '%');
            });
        }

        $users = $query->paginate($lenght);
        return ['data' => $users];
    }

    public function getDatas()
    {
        return MenuAkses::all();
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
    public function store(Request $request, MenuAkses $menuAkses)
    {
        // $validator = Validator::make($request->all(), [
        //     'id' => 'required|string|max:50',
        //     'role_id' => 'required|string|max:50',
        //     'menuid' => 'required|string|max:50',
        // ]);

        // //response error validation
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 400);
        // }
        foreach ($request->menu_id as $value) {
            $menuid = $value['id'];
        }

        $menuAkses::updateOrCreate(
            ['id' => $request->id],
            [
                'id' => Str::uuid(),
                'role_id' => $request->role_id['id'],
                'menu_id' => $menuid,
            ]
        );
        // $countrole = count($request->role_id);
        // $countmenu = count($request->menu_id);
        // if ($countrole > 0) {
        //     echo json_encode($request->role_id['id']);
        // }
        // $ar = array();
        // if ($countmenu > 0) {
        //     foreach ($request->menu_id as $value) {
        //         $ar[] = $value;
        // echo json_encode($ar[$i]);
        //         var_dump($value['id']);
        //         }
        // }
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
        //set validation
        $validator = Validator::make($request->all(), [
            'role_id'   => 'required',
            'menuid' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find user by ID
        $user = MenuAkses::findOrFail($menuAkses->id);

        if ($user) {

            //update user
            $user->update([
                'title'     => $request->title,
                'content'   => $request->content
            ]);

            return response()->json([
                'success' => true,
                'message' => 'user Updated',
                'data'    => $user
            ], 200);
        }

        //data user not found
        return response()->json([
            'success' => false,
            'message' => 'user Not Found',
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MenuAkses  $menuAkses
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //mencari data sesuai $id
        $post = MenuAkses::findOrFail($id);

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
            MenuAkses::findOrFail($value)->delete();
        }
    }
}
