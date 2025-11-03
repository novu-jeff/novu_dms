<?php
// app/Http/Middleware/ClientMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiClient;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $rawToken = $request->header('X-API-KEY') ?: $request->bearerToken();

        if (empty($rawToken)) {
            return response()->json(['message' => 'Unauthenticated.'], Response::HTTP_UNAUTHORIZED);
        }

        // Hash incoming token the same way you stored it
        $incomingHash = hash('sha256', $rawToken);

        $client = ApiClient::where('token_hash', $incomingHash)->first();

        if (!$client) {
            return response()->json(['message' => 'Unauthenticated.'], Response::HTTP_UNAUTHORIZED);
        }

        // Optional: check IP whitelist if set
        if ($client->ip_whitelist) {
            $allowedIps = array_filter(array_map('trim', explode(',', $client->ip_whitelist)));
            if (!empty($allowedIps) && !in_array($request->ip(), $allowedIps)) {
                return response()->json(['message' => 'Forbidden. IP not allowed.'], Response::HTTP_FORBIDDEN);
            }
        }

        // You may set the client on the request for later use
        $request->attributes->set('api_client', $client);

        return $next($request);
    }
}