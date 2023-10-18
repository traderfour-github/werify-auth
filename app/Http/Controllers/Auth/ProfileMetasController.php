<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewProfileMetaKeyRequest;
use App\Repositories\Contracts\IProfileMetasRepository;

class ProfileMetasController extends Controller
{
    public function __construct(public IProfileMetasRepository $profileMetasRepository)
    {
    }

    public function index()
    {
        return $this->response($this->profileMetasRepository->getProfileMetasByUserId(auth()->user()->id));
    }

    public function store(StoreNewProfileMetaKeyRequest $request)
    {
        return $this->response($this->profileMetasRepository->setProfileMetaByUserId(auth()->user()->id, $request->key, $request->value));
    }
}
