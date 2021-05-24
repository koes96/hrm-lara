<?php

namespace App\Http\Controllers;

use App\Models\MenuAkses;
use App\Models\MenuMain;
use Illuminate\Http\Request;

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
        // $akses = MenuAkses::join('menu_mains', 'menu_mains.id', '=', 'menu_akses.menu_id')->select('menu_akses.*', 'menu_mains.judul', 'menu_mains.menu')->get();
        // $sub = MenuMain::join('sub_menus', 'sub_menus.menu_id', '=', 'menu_mains.menu')->select('sub_menus.*', 'menu_mains.judul', 'menu_mains.menu')->get();
        // return view('home', [
        //     'akses' => $akses,
        //     'sub' => $sub
        // ]);
        return view('home');
    }
}
