<?php

namespace App\Http\Controllers;

use App\Models\SubMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->input('showdata')) {
            $querys = SubMenu::select('id', 'menu_id', 'title', 'url')
                ->get();

            return $querys;
        }
        $colums = ['id', 'menu_id', 'title', 'url'];
        $lenght = $request->input('length');
        $column = $request->input('column');
        $search_input = $request->input('search');

        $query = SubMenu::select('id', 'menu_id', 'title', 'url')
            ->orderBy($colums[$column])
            ->get();

        if ($search_input) {
            $query->where(function ($query) use ($search_input) {
                $query->where('id', 'like', '%' . $search_input . '%')->orwhere('url', 'like', '%' . $search_input . '%')->orwhere('title', 'like', '%' . $search_input . '%');
            });
        }

        $users = $query->paginate($lenght);
        return ['data' => $users];
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
    public function store(Request $request, SubMenu $subMenu)
    {
        $validator = Validator::make($request->all(), [
            // 'id' => 'required|string|max:50',
            'title' => 'required|string|max:50',
            'url' => 'required|string|max:50',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $subMenu::Create(
            [
                // 'id' => Str::uuid(),
                'menu_id' => $request->menuid['id'],
                'title' => $request->title,
                'url' => $request->url
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubMenu  $subMenu
     * @return \Illuminate\Http\Response
     */
    public function show(SubMenu $subMenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubMenu  $subMenu
     * @return \Illuminate\Http\Response
     */
    public function edit(SubMenu $subMenu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubMenu  $subMenu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubMenu $subMenu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubMenu  $subMenu
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubMenu $subMenu)
    {
        //
    }
}
