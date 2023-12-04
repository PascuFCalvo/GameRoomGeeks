<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Room;
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
                'password' => 'required | min:8|max:10',
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
          
            if ($user->is_active === 0)
            {
                throw new Error('Is active false');
            }
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
            if($th->getMessage() === 'Is active false')
            {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "User not found"
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }
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
        try{
        $user = auth()->user();
        if ($user->is_active === 0)
            {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "User not found"
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }
        return response()->json(
            [
                "success" => true,
                "message" => "User",
                "data" => $user
            ],
            Response::HTTP_OK
        );
        } catch (\Throwable $th) {
             Log::error($th->getMessage());
             if($th->getMessage() === 'Is active false')
             {
                return response()->json(
                [
                    "success" => false,
                    "message" => "User not found"
                ],
                Response::HTTP_NOT_FOUND
               );
             }
        return response()->json(
            [
                "success" => false,
                "message" => "Error profile user"
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
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

            if ($user->is_active === 0)
            {
                throw new Error('Is active false');
            }
            if ($request->has('name')) 
            {
                if (strlen($name)>3 && strlen($name)<100) 
                {
                    $user->name = $name;
                }
                else { throw new Error('invalid'); }
            }
            if ($request->has('nick')) 
            {
                if (strlen($nick)>3 && strlen($nick)<100) 
                {
                    $user->nick = $nick;
                }
                else { throw new Error('invalid'); }
            }
            $user->save();

            $accessToken = $request->bearerToken();
            $token = PersonalAccessToken::findToken($accessToken);
            $token->delete();

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
            if($th->getMessage() === 'Is active false')
            {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "User not found"
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }
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

            if ($user->is_active === 0)
            {
                throw new Error('Is active false');
            }

            $password = $request->input('password');
            if ($request->has('password'))
            {
                if (strlen($password)>=8 && strlen($password)<=10)
                    { $user->password = bcrypt($password); }
                    
                else
                    { throw new Error('invalid');  }
            }
            $user->save();

            $accessToken = $request->bearerToken();
            $token = PersonalAccessToken::findToken($accessToken);
            $token->delete();

            return response()->json(
                [
                    "success" => true,
                    "message" => "User updated"
                ],
                Response::HTTP_OK
            );
        }catch (\Throwable $th) {
            Log::error($th->getMessage());
            if($th->getMessage() === 'Is active false')
            {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "User not found"
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }
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

    public function activate (Request $request, $id)
    {
        try{
            $user=User::query()->find($id);
            $user->is_active = true;
            $user-> save ();
            return response()->json(
                [
                    "success" => true,
                    "message" => "User is activated"
                ],
                Response::HTTP_OK
            );
        }catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error activated user"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
         }
    }

    public function getAllRooms(Request $request)
    {
        try {
            $rooms = Room::query()->get();
            return response()->json(
                [
                    "success" => true,
                    "message" => "Get all rooms successfully",
                    "data" => $rooms
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error getting all rooms"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }


    public function getAllMessages(Request $request)
    {
        try {
            $messages = Message::query()->get();
            return response()->json(
                [
                    "success" => true,
                    "message" => "Get all messages successfully",
                    "data" => $messages
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error getting all messages"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

}