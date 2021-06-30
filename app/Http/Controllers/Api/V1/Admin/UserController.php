<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->role) {
            $users = User::where('roles', $request->role)
                ->where('name', 'like', '%' . $request->search . '%')
                ->paginate(10);
//            $total = User::where('role', $request->role)->count();
        } else {
            $users = User::where('name', 'like', '%' . $request->search . '%')->paginate(10);
//            $total = User::count();
        }
        return response()->json([
            'status' => 200,
            'data' => $users,
//            'total' => $total,
        ], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return response()->json([
            'status' => 200,
            'data' => $user,
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate Data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'sometimes|required|string|email|unique:users',
        ]);
        //Set Data Object
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->roles = $request->roles;
        $user->password = bcrypt('housewares');
        if ($request->hasFile('avatar')) {
            $path = Storage::putFile('avatars', $request->file('avatar'));
            $user->avatar = $path;

        }
        //Check status HTTP
        if ($user->save()) {
            return response()->json([
                'status' => 200,
                'message' => 'User created successfully!',
                'data' => $user,
            ], 200);
        }
        return response()->json([
            'status' => 500,
            'message' => 'Some error occurred. Please try again!',
        ], 500);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //Validate Data
        if ($request->reset) {
            $user->password = bcrypt('housewares');
            $user->active = 0;
        } else {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'sometimes|required|unique:users,email,' . $user->id,
            ]);
            //Set Data Object
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->roles = $request->roles;
            if ($request->hasFile('avatar')) {
                $path = Storage::putFile('avatars', $request->file('avatar'));
                $user->avatar = $path;
            }
        }
        //Check status HTTP
        if ($user->save()) {
            return response()->json([
                'status' => 200,
                'message' => 'User updated successfully!',
                'data' => $user,
            ], 200);
        }
        return response()->json([
            'status' => 500,
            'message' => 'Some error occurred. Please try again!',
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        //Check status HTTP
        if ($user->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'User deleted successfully!',
            ], 200);
        }
        return response()->json([
            'status' => 500,
            'message' => 'Some error occurred. Please try again!',
        ], 500);
    }
}
