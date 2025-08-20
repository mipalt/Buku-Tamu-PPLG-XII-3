<?php

namespace App\Http\Controllers\Web;

use App\Helpers\ApiFormatter;
use App\Helpers\PaginationFormatter;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserRepository $userRepo;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    public function index(Request $request)
    {
        // Ambil filter dari query string
        $filters = $request->only(['search', 'limit', 'sortOrder', 'page']);

        $users = $this->userRepo->getAllUsers($filters);

        if ($users->isEmpty()) {
            return ApiFormatter::sendNotFound('No users found');
        }

        return ApiFormatter::sendSuccess(
            "Users retrieved successfully",
            UserResource::collection($users),
            200,
            ['pagination' => PaginationFormatter::format($users)]
        );
    }
}
