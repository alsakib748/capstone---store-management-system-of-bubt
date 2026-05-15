<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public static function getpermissionGroups()
    {
        $permission_groups = DB::table('permissions')->select('group_name')->groupBy('group_name')->get();
        return $permission_groups;
    }
    // End Method

    public static function getpermissionByGroupName($group_name)
    {
        $permissions = DB::table('permissions')
            ->select('name', 'id')
            ->where('group_name', $group_name)
            ->get()
            ->map(function ($permission) {
                $permission->display_name = str_contains($permission->name, '::')
                    ? explode('::', $permission->name, 2)[1]
                    : $permission->name;

                return $permission;
            });
        return $permissions;

    }
    // End Method

    public static function roleHasPermissions($role, $permissions)
    {
        $hasPermission = true;
        foreach ($permissions as $key => $permission) {
            if (!$role->hasPermissionTo($permission->name)) {
                $hasPermission = false;
            }
            return $hasPermission;
        }
    }
    // End Method

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the user's avatar (use photo column).
     */
    public function getAvatarAttribute($value)
    {
        // Return photo if it exists and is not empty
        if ($this->photo && !empty($this->photo)) {
            return asset('upload/user_images/' . $this->photo);
        }
        // Return default avatar
        return asset('backend/assets/images/logo-sm.png');
    }

    /**
     * Check if the user has any permission in the given permission group.
     * Super Admin and Admin automatically return true.
     */
    public function hasPermissionGroup(string $groupName): bool
    {
        if ($this->hasRole('Super Admin') || $this->hasRole('Admin')) {
            return true;
        }

        $perms = $this->getAllPermissions();
        return $perms->contains(function ($p) use ($groupName) {
            return isset($p->group_name) && $p->group_name === $groupName;
        });
    }










}