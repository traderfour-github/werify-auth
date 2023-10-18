<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewUserMobileNumberRequest;
use App\Repositories\Contracts\IProfileFinancialInformationRepository;
use App\Repositories\Contracts\IProfileMobileNumbersRepository;
use App\Repositories\Contracts\IProfileRepository;
use App\Repositories\Contracts\IUserRepository;

class ProfileMobileNumbersController extends Controller
{
    /**
     * Create a new instance of RegisterController
     *
     *
     * @return void
     */
    public function __construct(public IUserRepository $userRepository, public IProfileRepository $profileRepository, public IProfileFinancialInformationRepository $profileFinancialInformationRepository, public IProfileMobileNumbersRepository $profileMobileNumbersRepository)
    {
    }

    public function index()
    {
        return $this->response($this->profileMobileNumbersRepository->getMobileNumbersByUserId(auth()->user()->id));
    }

    public function store(StoreNewUserMobileNumberRequest $request)
    {
        return $this->profileMobileNumbersRepository->addMobileNumberToUser(auth()->user()->id, $request->mobile_number);
    }
}
