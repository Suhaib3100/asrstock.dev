<?php

namespace App\Http\Middleware;

use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContributorMiddleware
{
    use ResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response|RedirectResponse) $next
     * @return JsonResponse|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->contributor_status == CONTRIBUTOR_STATUS_APPROVED) {
            return $next($request);
        } else {
            if ($request->wantsJson()) {
                return $this->error([], __('You don’t have permission to access this resource.'));
            }
            abort(403);
        }
    }
}
