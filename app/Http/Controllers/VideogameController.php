<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Videogame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class VideogameController extends Controller
{
    public function createVideogame(Request $request)
    {
        try {
            $name = $request->input('name');
            $id = auth()->user()->id;

            $newVideogame = Videogame::create([
                'name' => $name,
                'user_id' => $id
            ]);
            return response()->json(
                [
                    "success" => true,
                    "message" => "Created videogame successfully",
                    "data" => $newVideogame
                ],
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error creating videogame"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    public function deleteVideogameById(Request $request, $id)
    {
        try {
            $deletedVideogame = Videogame::destroy($id);
            return response()->json(
                [
                    "success" => true,
                    "message" => "Videogame deleted successfully",
                    "data" => $deletedVideogame
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error deleting videogame"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    public function updateVideogameById(Request $request, $id)
    {
        try {
            $videogame = Videogame::query()->find($id);
            $name = $request->input('name');
            $videogame->name = $name;
            $videogame->save();
            return response()->json(
                [
                    "success" => true,
                    "message" => "Videogame updated successfully",
                    "data" => $videogame
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error updating videogame"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    public function getAllVideogames(Request $request)
    {
        try {
            $videogames = Videogame::query()->get();
            return response()->json(
                [
                    "success" => true,
                    "message" => "Get all videogames successfully",
                    "data" => $videogames
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error getting all videogames"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getVideogameById(Request $request, $id)
    {
        try {
            $videogame = Videogame::query()->find($id);
            return response()->json(
                [
                    "success" => true,
                    "message" => "Get videogame successfully",
                    "data" => $videogame
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error getting videogame"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }


}
