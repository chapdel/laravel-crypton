<?php

namespace Chapdel\Middleware;

use Chapdel\CryptOn\EncryptionFactory;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CryptOnMiddleware
{
    /**
     * @var \Illuminate\Encryption\Encrypter
     */
    protected $crypton;

    /**
     * Encrypt Reqeust Response Constructor.
     */
    public function __construct()
    {
        $this->crypton = EncryptionFactory::make();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this.decrypt($request);
        $response = $next($request);
        if ($response instanceof JsonResponse) {
            $this->encrypt($request, $response);
        }
        return $response;
    }

    public function encrypt(Request $request, JsonResponse $response){

        $payload = ['payload' => $this->crypton->encrypt(json_decode($response->content(), true))];

        $response->setContent(json_encode($payload));
    }
    public function decrypt(Request $request){
        $decrypted = $request->payload ? $this->crypton->decrypt($request->payload) : null;
        if ($decrypted) {
            $request->merge($decrypted);
            $request->replace($request->except('payload'));
        }
    }
}
