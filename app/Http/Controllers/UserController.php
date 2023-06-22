<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::get()->toArray();
        return view('users.index', compact('users'));
    }


    public function create()
    {
        $data['user'] = new User();
        return view('users.create', $data);
    }

    public function store(StoreUserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();
            $user->create($request->all());
            DB::commit();
            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (Exception $exception) {
            dd($exception);
            DB::rollBack();
            Log::error($exception->getMessage());
            return redirect()->route('users.index')->with('error', 'User not saved.');
        }
    }


    public function edit($id)
    {
        $data['user'] = User::find($id);

        return view('users.edit', $data);
    }

    public function show($id)
    {
        $item = User::find($id);
        return view('users.show', compact('item'));
    }
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();
            $user->update($request->all());
            DB::commit();
            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (Exception $exception) {
            dd($exception);
            DB::rollBack();
            Log::error($exception->getMessage());
            return redirect()->route('users.index')->with('error', 'User not saved.');
        }
    }

    public function destroy(User $user)
    {

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }



    public function changeRole(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $status = $data['selectedValue'];
        DB::table('users')->where('id', $data['user_id'])->update(['type' => $status]);
        return response()->json(['status' => 200, 'message' => 'Operation successful']);

    }
}
