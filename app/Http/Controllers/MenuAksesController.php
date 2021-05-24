<?php

namespace App\Http\Controllers;

use App\Models\MenuAkses;
use App\Models\MenuMain;
use App\Models\SubMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
            $querys = MenuAkses::select('menu_akses.id as idakses', 'menu_akses.role_id', 'menu_akses.menu_id', 'users.id as iduser', 'users.name')
                ->join('users', 'users.id', '=', 'menu_akses.role_id')
                ->get();

            foreach ($querys as $key => $value) {
                $exp = explode(",", $value->menu_id);
                $c = count($exp);
                // $value->menus = ['jml' => $c, 'hasil' => $exp];

                $data = null;
                for ($i = 0; $i < $c; $i++) {
                    $data[] = MenuMain::select('id', 'menu')->where('id', $exp[$i])->get();
                }
                $value->menu_id = $data;
            }
            foreach ($querys as $key1 => $value1) {
                foreach ($value1->menu_id as $key2 => $value2) {
                    foreach ($value2 as $key3 => $value3) {
                        $value3->submenu = MenuMain::select('id', 'menu')->where('id', $value3->id)->get();
                    }
                }
            }
            // echo json_encode($querys);

            return $querys;
        }

        $colums = ['id', 'roleid', 'menuid',];
        $lenght = $request->input('length');
        $column = $request->input('column');
        $search_input = $request->input('search');

        $query = MenuAkses::select('menu_akses.id as idakses', 'menu_akses.role_id', 'menu_akses.menu_id', 'users.id as iduser', 'users.name', 'menu_mains.id as idmains', 'menu_mains.menu', 'menu_mains.id')
            ->join('users', 'users.id', '=', 'menu_akses.role_id')
            ->join('menu_mains', 'menu_mains.id', '=', 'menu_akses.menu_id')
            ->orderBy($colums[$column])
            ->get();

        if ($search_input) {
            $query->where(function ($query) use ($search_input) {
                $query->where('menu_akses.id', 'like', '%' . $search_input . '%')->orwhere('menu_akses.role_id', 'like', '%' . $search_input . '%')->orwhere('menu_akses.menu_id', 'like', '%' . $search_input . '%');
            });
        }

        $users = $query->paginate($lenght);
        return ['data' => $users];
    }

    public function getDatas()
    {
        return MenuAkses::all();
    }

    public function cek()
    {
        $querys = MenuAkses::select('menu_akses.id as idakses', 'menu_akses.role_id', 'menu_akses.menu_id', 'users.id as iduser', 'users.name')
            ->join('users', 'users.id', '=', 'menu_akses.role_id')
            ->get();
        foreach ($querys as $key => $value) {
            $exp = explode(",", $value->menu_id);
            $c = count($exp);
            // $value->menus = ['jml' => $c, 'hasil' => $exp];

            $data = null;
            for ($i = 0; $i < $c; $i++) {
                $data[] = MenuMain::select('id', 'menu')->where('id', $exp[$i])->get();
            }
            $value->menu_id = $data;
        }
        foreach ($querys as $key1 => $value1) {
            foreach ($value1->menu_id as $key2 => $value2) {
                foreach ($value2 as $key3 => $value3) {
                    $value3->submenu = SubMenu::select('id', 'title', 'url')->where('menu_id', $value3->id)->get();
                }
            }
        }
        echo json_encode($querys);
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
        $validator = Validator::make($request->all(), [
            // 'id' => 'required|string|max:50',
            // 'role_id' => 'required|string|max:50',
            // 'menu_id' => 'required|string|max:50',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        foreach ($request->menu_id as $key => $value) {
            $menuid[] = $value['id'];
        }
        $menu = implode(",", $menuid);

        $menuAkses::Create(
            [
                'id' => Str::uuid(),
                'role_id' => $request->role_id['id'],
                'menu_id' => $menu,
            ]
        );
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
    public function update(Request $request, MenuAkses $menuAkses, $id)
    {
        //set validation
        // $validator = Validator::make($request->all(), [
        //     'role_id'   => 'required',
        //     'menu_id' => 'required',
        // ]);

        // //response error validation
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 400);
        // }

        foreach ($request->menu_id as $value) {
            $menuid[] = $value['id'];
        }

        $menu = implode(",", $menuid);
        // echo json_encode($menuid);

        //find user by ID
        $post = MenuAkses::findOrFail($id);
        if ($post) {
            $menuAkses->where('id', $id)->update([
                'role_id' => $request->role_id['id'],
                'menu_id' => $menu

            ]);
        }
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
