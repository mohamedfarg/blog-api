<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Resources\UserResource;


class UserController extends Controller
{

    // Registration
    public function register(Request $request)
    {
        // Validation logic for registration data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Create and store the new user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        return new UserResource($user);
    }

    // Login
    public function login(Request $request)
    {
        // Validation logic for login data
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return new UserResource($user);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logged out successfully']);
    }

    // Create user
    public function create(Request $request)
    {
        // Validation logic for user creation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Create and store the new user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        return new UserResource($user);
    }

    // Update user
    public function update(Request $request, $id)
    {
        // Find the user by ID
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Validation logic for updating user data
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'email' => 'string|email|unique:users',
            'password' => 'string|min:6',
        ]);

        // Update user attributes
        $user->fill($validatedData);
        $user->save();

        return new UserResource($user);
    }

    // Delete user
    public function delete($id)
    {
        // Find the user by ID
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}


