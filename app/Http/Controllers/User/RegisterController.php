<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 24/11/2018
 * Time: 14:41
 */
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {

    }

    /**
     * Handle registration post requests
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Check if a users signup email is in the closed beta approved list
        if (config('beta.status') === 'closed') {
            if (!in_array($request->get('email'), config('beta.approved'))) {
                return response()->json([
                    'message' => 'This email is not approved for closed beta access.'
                ], 401);
            }
        }

        $user = User::create([
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        return response()->json([
            'user' => $user
        ]);
    }
}
