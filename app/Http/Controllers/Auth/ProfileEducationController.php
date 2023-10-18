<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\IProfileEducationRepository;

class ProfileEducationController extends Controller
{
    public function __construct(public IProfileEducationRepository $profileEducationRepository)
    {
    }

    public function index()
    {
        return $this->response($this->profileEducationRepository->getProfileEducationByUserId(auth()->user()->id));
    }

    public function store()
    {
        return $this->response($this->profileEducationRepository->getProfileEducationByUserId(auth()->user()->id));
    }
}
