<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Error;
use Illuminate\Support\Facades\Hash;
use illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;


class UserController extends Controller
{
    private function validateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:100',
            'nick' => 'required|min:3|max:100',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8|max:10',
        ]);

        return $validator;
    }

    public function register (Request $request)
    {
        try {
            $validator=$this->validateUser($request);
            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Error registering user",
                        "error" => $validator->errors()
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
            $newUser = User::create(
                [
                    "name" => $request->input('name'),
                    "nick"=> $request->input('nick'),
                    "email" => $request->input('email'),
                    "password" => bcrypt($request->input('password'))
                ]
            );
            return response()->json(
                [
                    "success" => true,
                    "message" => "user registered",
                    "data" => $newUser
                ],
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th)
        {
            Log::error($th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error registering user"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required | email',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Error login user",
                        "error" => $validator->errors()
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
            $email = $request->input('email');
            $password = $request->input('password');

            $user = User::query()->where('email', $email)->first();
            if (!$user)
            {
                throw new Error('invalid');
            }
            if (!Hash::check($password, $user->password))
            {
                throw new Error('invalid');
            }
            $token = $user->createToken('userToken')->plainTextToken;
            return response()->json(
                [
                    "success" => true,
                    "message" => "User logged succesfully ",
                    "token" => $token,
                    "data" => $user
                ]
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            if($th->getMessage() === 'invalid')
            {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Email or password are invalid"
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error login user"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function profile(Request $request)
    {
        $user = auth()->user();
        return response()->json(
            [
                "success" => true,
                "message" => "User",
                "data" => $user
            ],
            Response::HTTP_OK
        );
    }

    public function logout(Request $request)
    {
        $accessToken = $request->bearerToken();
        $token = PersonalAccessToken::findToken($accessToken);
        $token->delete();
        return response()->json(
            [
                "success" => true,
                "message" => "Logout successfully"
            ],
            Response::HTTP_OK
        );
    }

    public function updateUsers(Request $request)
    {
        try {
           
            $user = User::query()->find(auth()->user()->id);
            

            $name = $request->input('name');
            $nick = $request->input('nick');

            if ($request->has('name')) {
                $user->name = $name;
            }

            if ($request->has('nick')) {
                $user->nick = $nick;
            }

            $user->save();

           
            return response()->json(
                [
                    "success" => true,
                    "message" => "User updated",
                    "data" => $user
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error updating user"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function changePassword(Request $request)
    {
        try{
            
            $user=User::query()->find(auth()->user()->id);

           
            $password = $request->input('password');
            if ($request->has('password'))
            {
                if (strlen($password)>=8 && strlen($password)<=10)
                    { $user->password = bcrypt($password); }
                    
                else
                    { throw new Error('invalid');  }
            }
            $user->save();
            return response()->json(
                [
                    "success" => true,
                    "message" => "User updated"
                ],
                Response::HTTP_OK
            );
        }catch (\Throwable $th) {
            Log::error($th->getMessage());
            if($th->getMessage() === 'invalid')
                 {
                     return response()->json(
                       [
                        "success" => false,
                        "message" => "Incorrect data"
                       ],
                      Response::HTTP_NOT_MODIFIED
                     );
                  }
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error update user"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
         }
    }

    public function inactivate (Request $request)
    {
        try{
            $userId = Auth::id();
            $user=User::query()->find($userId);

            $user->is_active = false;
            $user-> save ();

            return response()->json(
                [
                    "success" => true,
                    "message" => "User inactive"
                ],
                Response::HTTP_OK
            );
        }catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error inactive user"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
         }
    }

}