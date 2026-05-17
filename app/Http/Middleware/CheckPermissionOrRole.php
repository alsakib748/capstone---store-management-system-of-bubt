<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissionOrRole
{
    /**
     * Handle an incoming request.
     * If middleware parameter(s) provided, use them; otherwise derive permission from route name.
     * Bypass checks for users with role 'Super Admin' or 'Admin'.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$params
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$params)
    {
        $user = $request->user();

        if (!$user) {
            abort(Response::HTTP_FORBIDDEN);
        }

        // Super Admin and Admin bypass all permission checks
        if ($user->hasRole('Super Admin') || $user->hasRole('Admin')) {
            return $next($request);
        }

        // Determine required permission(s)
        if (!empty($params)) {
            // params may be passed as a single string with '|' separators
            $permissions = is_array($params) ? $params : explode('|', $params[0]);
        } else {
            $routeName = $request->route() ? $request->route()->getName() : null;
            $permissions = [];
            if ($routeName) {
                $segments = explode('.', $routeName);

                // Search endpoints are nested under their parent module name, e.g. requisition.product.search.
                // Derive permission from the parent module instead of generating Product.search::menu.
                if (count($segments) >= 3 && end($segments) === 'search') {
                    $resource = $segments[0];
                    $resourceTitle = ucfirst(str_replace('-', ' ', $resource));
                    $permissions[] = $resourceTitle . '::menu';
                } else {
                    // convention: action.resource (e.g., all.brand, add.brand)
                    [$action, $resource] = array_pad(explode('.', $routeName, 2), 2, null);
                    if ($resource) {
                        $resourceTitle = ucfirst(str_replace('-', ' ', $resource));
                        $pluralResource = Str::plural(Str::lower($resourceTitle));

                        switch ($action) {
                            case 'all':
                            case 'index':
                            case 'menu':
                                $listPermission = $resourceTitle . '::all ' . $pluralResource;
                                if (Permission::where('name', $listPermission)->where('guard_name', 'web')->exists()) {
                                    $permissions[] = $listPermission;
                                } else {
                                    $permissions[] = $resourceTitle . '::menu';
                                }
                                break;
                            case 'my':
                                $myPermission = $resourceTitle . '::my ' . $pluralResource;
                                if (Permission::where('name', $myPermission)->where('guard_name', 'web')->exists()) {
                                    $permissions[] = $myPermission;
                                } else {
                                    $permissions[] = $resourceTitle . '::menu';
                                }
                                break;
                            case 'add':
                            case 'create':
                            case 'store':
                                $permissions[] = $resourceTitle . '::add';
                                break;
                            case 'edit':
                            case 'update':
                                $permissions[] = $resourceTitle . '::edit';
                                break;
                            case 'delete':
                            case 'destroy':
                                $permissions[] = $resourceTitle . '::delete';
                                break;
                            default:
                                // fallback to menu permission
                                $permissions[] = $resourceTitle . '::menu';
                        }
                    }
                }
            }
        }

        // If still no permissions, deny access
        if (empty($permissions)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        // Check permission(s)
        foreach ($permissions as $permission) {
            if ($user->hasPermissionTo($permission)) {
                return $next($request);
            }
        }

        abort(Response::HTTP_FORBIDDEN);
    }
}
