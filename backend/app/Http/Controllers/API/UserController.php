<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User; 
use App\Http\Resources\UserResource;
use Response;
use Hash;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function login(Request $request){  
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $query  = User::query(); 
        $query->where(function ($query) use ($email) { 
            $query->where('email', $email ); 
        });
        $user = $query->first();
        $inputs = $request->all();  

        $inputs['email'] = $user ? $user->email : '';
        $credentials = [
            'email' => $inputs['email'],
            'password' => $inputs['password']
        ]; 
        if((!$user || !Hash::check($request->password, $user->password)) || !Auth::attempt($credentials)) { 
            return response()->json([
                'success'   => false, 
                'message'   => 'Login Failed',
                'error'     => 'Invalid Credentials'
            ], 401);
        }  

        $newToken = $user->createToken('authToken', ['*']);
        $plainTextToken = $newToken->plainTextToken;

        // Set expiration for the token and save
        $newToken->accessToken->expires_at = Carbon::now()->addHours(24);
        $newToken->accessToken->save();

        return response()->json([
            'data' => [
                'user' => new UserResource($user),
                'access_token' => $plainTextToken, // Include the plain text token here
                'token_type' => 'Bearer',
                'expires_at' => $newToken->accessToken->expires_at,
            ],
            'success' => true,
            'message' => 'You are successfully logged in'
        ]);
    } 
}
