<?php

namespace App\Http\Controllers\Web;

use App\Helpers\ApiFormatter;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected UserRepository $userRepo;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepo->getAllUsers();

        if (!$users || $users->isEmpty()) {
            return ApiFormatter::sendNotFound('No users found');
        }

        return ApiFormatter::sendSuccess("Users retrieved successfully", UserResource::collection($users));
    }
}
