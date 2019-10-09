<?php

namespace iBrand\Edu\Backend\Http\Controllers;

use iBrand\Backend\Http\Controllers\Controller;
use iBrand\Edu\Backend\Repositories\UserRepository;

class CommonController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserList()
    {
        $limit = request('limit') ? request('limit') : 5;

        $conditions=$this->Condition();

        $where=$conditions[0];

        $lists = $this->userRepository->getUsersPaginate($where, $limit);

        return view('edu-backend::common.model.user.list', compact('lists'));

    }

    public function modelUsers()
    {
        $limit = request('limit') ? request('limit') : 5;

        $lists = $this->userRepository->scopeQuery(function ($query) {
            return $query->orderBy('updated_at', 'desc');
        })->paginate($limit);

        return view('edu-backend::common.model.user.index', compact('lists'));
    }

    private function Condition()
    {
        $where = [];
        if (!empty(request('field'))) {
            $where[request('field')] = ['like', '%' . request('value') . '%'];
        }
        return [$where];
    }
}