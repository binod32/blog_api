<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class UserController extends Controller
{
    public function __construct()
    {
        if (!Gate::allows('admin')) {
            $this->middleware('admin');
        }

    }

    public function index()
    {
        return UserResource::collection(User::paginate());
    }

    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();

        try {
            $password = Hash::make($request->password);
            $userData = $request->except('password');
            $userData['password'] = $password;
            $user = User::create($userData);

            $role = Role::where('name', 'author')->first();
            if (!$role) {
                throw new \Exception('Role not found.');
            }
            $user->assignRole($role);

            DB::commit();

            return response()->json(['message' => 'User created successfully.'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return new UserResource($user);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }


        $user->save();

        return new UserResource($user);
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
}
