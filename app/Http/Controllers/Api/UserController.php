<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // GET /api/users (Melihat semua pengguna beserta koleksinya)
    public function index()
    {
        $users = User::with('media')->paginate(10);
        return UserResource::collection($users);
    }

    // GET /api/users/{user} (Melihat koleksi media milik satu pengguna)
    public function show(User $user)
    {
        return new UserResource($user->load('media'));
    }

    // Custom Action 1: POST /api/users/{user}/collection (Menambah media ke koleksi)
    public function addToCollection(Request $request, User $user)
    {
        $request->validate([
            'media_id' => 'required|exists:media,id',
        ], [
            'media_id.required' => 'ID media wajib diisi.',
            'media_id.exists' => 'Media tidak ditemukan di database.',
        ]);

        // Cek apakah media sudah ada di koleksi user (Error Handling 409 Conflict)
        if ($user->media()->where('media_id', $request->media_id)->exists()) {
            return response()->json([
                'message' => 'Media sudah ada di koleksi pengguna ini.',
            ], 409);
        }

        $user->media()->attach($request->media_id);

        return response()->json([
            'message' => 'Media berhasil ditambahkan ke koleksi.',
            'data' => new UserResource($user->load('media')),
        ], 201);
    }

    // Custom Action 2: DELETE /api/users/{user}/collection/{media} (Menghapus media dari koleksi)
    public function removeFromCollection(User $user, Media $media)
    {
        // Cek apakah media memang ada di koleksi user tersebut
        if (!$user->media()->where('media_id', $media->id)->exists()) {
            return response()->json([
                'message' => 'Media tidak ditemukan di dalam koleksi pengguna ini.',
            ], 404);
        }

        $user->media()->detach($media->id);

        return response()->json([
            'message' => 'Media berhasil dihapus dari koleksi.',
        ], 200);
    }
}