<?php

namespace App\Providers;

use App\Repositories\ApplicationRepository;
use App\Repositories\Contracts\IApplicationRepository;
use App\Repositories\Contracts\ILogRepository;
use App\Repositories\Contracts\IProfileBadgesRepository;
use App\Repositories\Contracts\IProfileEducationRepository;
use App\Repositories\Contracts\IProfileFinancialInformationRepository;
use App\Repositories\Contracts\IProfileMetasRepository;
use App\Repositories\Contracts\IProfileMobileNumbersRepository;
use App\Repositories\Contracts\IProfileRepository;
use App\Repositories\Contracts\ISessionRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\LogRepository;
use App\Repositories\ProfileBadgesRepository;
use App\Repositories\ProfileEducationRepository;
use App\Repositories\ProfileFinancialInformationRepository;
use App\Repositories\ProfileMetasRepository;
use App\Repositories\ProfileMobileNumbersRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\SessionRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
        app()->bind(IUserRepository::class, UserRepository::class);
        app()->bind(ILogRepository::class, LogRepository::class);
        app()->bind(ISessionRepository::class, SessionRepository::class);
        app()->bind(IApplicationRepository::class, ApplicationRepository::class);
        app()->bind(IProfileRepository::class, ProfileRepository::class);
        app()->bind(IProfileEducationRepository::class, ProfileEducationRepository::class);
        app()->bind(IProfileBadgesRepository::class, ProfileBadgesRepository::class);
        app()->bind(IProfileFinancialInformationRepository::class, ProfileFinancialInformationRepository::class);
        app()->bind(IProfileMobileNumbersRepository::class, ProfileMobileNumbersRepository::class);
        app()->bind(IProfileMetasRepository::class, ProfileMetasRepository::class);
    }
}
