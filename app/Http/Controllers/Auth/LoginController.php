<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\LoginWithOTPRequest;
use App\Jobs\Application\CheckApplicationKeyJob;
use App\Jobs\Auth\CheckSessionJob;
use App\Jobs\Auth\GenerateQrSessionJob;
use App\Jobs\Auth\GetRequestApiKeyJob;
use App\Jobs\Auth\LoginWithModalJob;
use App\Jobs\Auth\LoginWithOTPSessionJob;
use App\Jobs\Auth\LoginWithSessionJob;
use App\Jobs\Auth\RequestOTPJob;
use App\Repositories\Contracts\IUserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LoginController extends Controller
{
    /**
     * Create a new instance of RegisterController
     *
     *
     * @return void
     */
    public function __construct(public IUserRepository $userRepository)
    {
    }

    public function requestOTP(LoginRequest $request)
    {
        return $this->response(dispatch_sync(new RequestOTPJob($request)));
    }

    public function verifyOTP(LoginWithOTPRequest $request)
    {
        $result = dispatch_sync(new LoginWithOTPSessionJob($request->id, $request->hash, $request->otp, $request));
        $user = $result['user'];
        $token = $result['token'];

        return $this->tokenResponse($user, $token);
    }

    /**
     * generate new login with qr
     */
    public function requstQrCode(Request $request)
    {
        $session = dispatch_sync(new GenerateQrSessionJob('qr'));

        return $this->response(
            [
                'id' => $session->id,
                'hash' => $session->hash,
                'expired_at' => Carbon::now()->addMinutes(3),
                'url' => route('qr-render', [$session->hash, $session->id]).'?api-key='.dispatch_sync(new GetRequestApiKeyJob()),
            ]
        );
    }

    /**
     * render the token svg
     */
    public function qrRender($hash, $id)
    {
        $url = route('login-with-qr', [$id, $hash]);

        $contents =  QrCode::size(300)->generate($url);

		$response = Response::make($contents, 200);
		$response->header('Content-Type', 'image/svg+xml');
		return $response;

	}

    /**
     * request session for login modal
     */
    public function requestModalLogin(Request $request)
    {
        dispatch_sync(new CheckApplicationKeyJob($request));
        $session = dispatch_sync(new LoginWithModalJob('modal', $request));

        return $this->response(
            [
                'session' => $session,
                'user' => auth()->user(),
            ]
        );
    }

    /**
     * login with qr, requires to get an qr first
     */
    public function loginWithQrSession($hash, $id)
    {
        return $this->response(dispatch_sync(new LoginWithSessionJob('qr', $id, $hash)));
    }

    /**
     * login with otp, requires to get an otp first
     */
    public function loginWithModalSession($hash, $id)
    {
        return $this->response(dispatch_sync(new LoginWithSessionJob('modal', $id, $hash)));
    }

    /**
     * check if a session is claimed or not.
     */
    public function sessionCheck(Request $request, $type, $hash, $id)
    {
        $result = dispatch_sync(new CheckSessionJob($type, $id, $hash));
        $user = $result['user'];
        $token = $result['token'];

        return $this->tokenResponse($user, $token);
    }

    /**
     * send login token response
     */
    private function tokenResponse($user, $token)
    {
        return $this->response(
            [
                'first_name' => $user->profile->first_name,
                'middle_name' => $user->profile->middle_name,
                'last_name' => $user->profile->last_name,
                'email' => $user->email,
                'mobile' => $user->profile->mobile,
                'phone_numbers' => $user->profileNumbers,
                'language' => $user->profile->language,
                'timezone' => $user->profile->timezone,
                'currency' => $user->profile->currency,
                'last_connection' => $user->profile->last_online,
                'private' => $user->profile->is_private,
                'avatar' => $user->profile->avatar,
                'access_token' => $token,
                'token_type' => 'bearer',
                'expire' => config('jwt.ttl'),
            ]
        );
    }
}
