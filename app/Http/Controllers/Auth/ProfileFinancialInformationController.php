<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileFinancialInformationRequest;
use App\Repositories\Contracts\IProfileFinancialInformationRepository;
use App\Repositories\Contracts\IProfileRepository;
use App\Repositories\Contracts\IUserRepository;

class ProfileFinancialInformationController extends Controller
{
    /**
     * Create a new instance of RegisterController
     *
     *
     * @return void
     */
    public function __construct(public IUserRepository $userRepository, public IProfileRepository $profileRepository, public IProfileFinancialInformationRepository $profileFinancialInformationRepository)
    {
    }

    /**
     * get user financial information
     *
     * @return array
     */
    public function index()
    {
        return $this->response($this->profileFinancialInformationRepository->getProfileFinancialInformationByUserId(auth()->user()->id));
    }

    public function update(UpdateProfileFinancialInformationRequest $request)
    {
        $data = $request->only(
            [
                'job', 'income_range', 'salary_range', 'fund_source', 'initial_capital', 'wealth_source', 'goals_to_join', 'preferer_market', 'lose_range', 'monthly_saving_range', 'target_range',

            ]
        );
        $profile = auth()->user()->profile;
        $financialInformation = auth()->user()->financialInformation;

        if (is_null($profile)) {
            $this->profileRepository->createEmptyProfileForUser(auth()->user()->id);
        }

        if (is_null($financialInformation)) {
            $this->profileFinancialInformationRepository->createEmptyFinancialInformationForUser(auth()->user()->id);
        }

        return $this->response($this->profileFinancialInformationRepository->update($profile->id, $data));
    }
}
