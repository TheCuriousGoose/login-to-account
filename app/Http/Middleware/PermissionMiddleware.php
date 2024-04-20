<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $as = $request->route()->action['as'];

        $asParts = explode('.', $as);
        $last = end($asParts);

        switch ($last) {
            case 'index':
                $last = 'show';
                break;
            case 'store':
                $last = 'create';
                break;
            case 'update':
            case 'destroy':
                $last = 'edit';
                break;
        }

        $asParts[count($asParts) - 1] = $last;
        $as = implode('.', $asParts);

        if (!Permission::whereName($as)->exists()) {
            Permission::create([
                'name' => $as,
                'guard_name' => 'web'
            ]);
        }

        if ($user->hasRole('super-admin')) {
            return $next($request);
        }

        if (!$user->can($as)) {
            throw UnauthorizedException::forPermissions([$as]);
        }

        return $next($request);
    }
}
