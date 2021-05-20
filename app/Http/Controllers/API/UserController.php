<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->input('showdata')) {
            return User::orderBy('created_at', 'desc')->get();
        }

        $colums = ['name', 'email', 'created_at', 'id'];
        $lenght = $request->input('length');
        $column = $request->input('column');
        $search_input = $request->input('search');

        $query = User::select('name', 'email', 'created_at', 'id')->orderBy($colums[$column]);

        if ($search_input) {
            $query->where(function ($query) use ($search_input) {
                $query->where('name', 'like', '%' . $search_input . '%')->orwhere('email', 'like', '%' . $search_input . '%')->orwhere('created_at', 'like', '%' . $search_input . '%');
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
    public function getDatas()
    {
        return User::select('id','name')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        // $valid = $this->validate($request, [
        //     'name' => 'required|string|max:50',
        //     'role_id' => 'required|integer',
        //     'email' => 'required|string|max:50',
        //     'password' => 'required|max:50',
        // ]);

        // return User::create([
        //     'id' => Str::uuid(),
        //     'name' => $request->name,
        //     'role_id' => $request->role_id,
        //     'email' => $request->email,
        //     'password' => bcrypt($request->password),
        // ]);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'role_id' => 'required|integer',
            'email' => 'required|string|max:50',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user::updateOrCreate(
            ['id' => $request->id],
            [
                'id' => Str::uuid(),
                'name' => $request->name,
                'role_id' => $request->role_id,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        //set validation
        $validator = Validator::make($request->all(), [
            'title'   => 'required',
            'content' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find user by ID
        $user = user::findOrFail($user->id);

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //mencari data sesuai $id
        $post = User::findOrFail($id);

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
            User::findOrFail($value)->delete();
        }
    }
}
