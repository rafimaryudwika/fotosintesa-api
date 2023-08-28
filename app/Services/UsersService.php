<?php

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Repositories\UsersRepository;

/**
 * Di Service, kita harus fokus ke business logic seperti manipulasi data dan kalkulasi
 */
class UsersService
{
    public function __construct(
        protected UsersRepository $userRepository
    ) {
    }

    public function getCurrentUser()
    {
        return $this->userRepository->getCurrentUser();
    }

    public function getAllData()
    {
        return $this->userRepository->getData();
    }

    public function getDataByID(string $id)
    {
        return $this->userRepository->getData($id);
    }

    public function requestData(UserRequest $request, string $id = null)
    {
        // if (!$id) {
        //     return $this->userRepository->requestData($request);
        // }

        return $this->userRepository->requestData($request, !$id ? null : $id);
    }

    public function deleteData(string $id)
    {
        return $this->userRepository->deleteData($id);
    }
}
