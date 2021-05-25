<?php

namespace App\Http\Controllers;

use App\Models\MenuAkses;
use App\Models\MenuMain;
use App\Models\SubMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id = Auth::id();
        // $querys = MenuAkses::select('menu_akses.id as idakses', 'menu_akses.role_id', 'menu_akses.menu_id', 'users.id as iduser', 'users.name')
        //     ->join('users', 'users.id', '=', 'menu_akses.role_id')
        // ->where('users.id', '=', $id)
        $querys = DB::table('join_users_ke_menu_akses')
            ->where('iduser', '=', $id)
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
        // echo json_encode($querys);
        return view('home', ['menu' => $querys]);
    }
}
