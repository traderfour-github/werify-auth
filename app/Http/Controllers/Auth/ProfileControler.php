<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UsernameCheckRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Repositories\Contracts\IProfileFinancialInformationRepository;
use App\Repositories\Contracts\IProfileRepository;
use App\Repositories\Contracts\IUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProfileControler extends Controller
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
     * get user profile
     *
     * @return array
     */
    public function me()
    {
        return $this->response(auth()->user());
    }

    public function single(Request $request, $id)
    {
        return User::where('uuid', $id)->firstOrFail();
    }

    public function update(UpdateProfileRequest $request)
    {
        $data = $request->only(
            [
                'first_name', 'middle_name', 'last_name', 'mobile_number', 'avatar', 'cover', 'is_private', 'language', 'currency', 'timezone', 'calendar', 'shortcuts', 'layout', 'latitude', 'longitude',
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

        return $this->response($this->profileRepository->update($profile->id, $data));
    }

    public function checkUsername(UsernameCheckRequest $request)
    {
        $user = auth()->user();
        $suggested = [];
        $suggested[] = Str::slug($this->cleanIdentifier($user->identifier));
        $suggested[] = Str::slug($user->mobile);
        $suggested[] = Str::slug($user->profile->fullname);
        $suggested = array_filter($suggested);

        $usernamesExists = $this->userRepository->checkUserNames($suggested);
        $suggested = array_values(array_diff($suggested, $usernamesExists));

        return $this->response(
            [
                'suggested' => $suggested,
            ]
        );
    }

    public function setUsername(UsernameCheckRequest $request)
    {
        return $this->response($this->userRepository->setUserName(auth()->user()->id, $request->username));
    }

    private function cleanIdentifier($identifier)
    {
        return explode('@', $identifier)[0];
    }
}
