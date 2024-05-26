<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\MainFormRequest;
use App\Services\Utils\LogUtil;
use Google\Client as GoogleClient;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpFoundation\InputBag;

class GoogleLoginRequest extends MainFormRequest
{
    /** @var $payload */
    protected $payload;

    /**
     * @return bool
     * @throws AuthorizationException
     */
    public function authorize(): bool
    {
        $this->authorizeCsrfToken();
        $this->verifyIdToken();

        return true;
    }

    public function getPayload(): InputBag
    {
        return $this->payload;
    }

    /**
     * @return void
     * @throws AuthorizationException
     */
    private function authorizeCsrfToken(): void
    {
        $csrfToken = $this->input('g_csrf_token');
        if (! $csrfToken || ! $this->session()->token() === $csrfToken) {
            throw new AuthorizationException( trans('auth.csrf_mismatch'), 403);
        }
    }

    /**
     * @return void
     * @throws AuthorizationException
     */
    private function verifyIdToken(): void
    {
        $client = new GoogleClient(['client_id' => config('services.google.client_id')]);
        $idToken = $this->input('credential');
        try {
            $payload = $client->verifyIdToken($idToken);
            $this->payload = new InputBag($payload);
        } catch (\Exception $e) {
            LogUtil::logError(message: $e->getMessage());
            throw new AuthorizationException(trans('auth.token_failed'), 403);
        }
    }
}
