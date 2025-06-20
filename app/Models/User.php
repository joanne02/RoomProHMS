<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Testing\Fluent\Concerns\Has;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Laravel\Sanctum\HasApiTokens;
use Silber\Bouncer\BouncerFacade as Bouncer;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRolesAndAbilities, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'user_id',
    //     'email',
    //     'password',
    // ];
    protected $guarded = [];
    use Notifiable;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function resident()
    {
        return $this->hasOne(Resident::class);
    }

    public function updateUsertype($userId, $newUsertype)
    {
        $user = User::findOrFail($userId);

        // Update usertype column
        $user->usertype = $newUsertype;
        $user->save();

        // Remove previous role assignments
        Bouncer::unassign($user->getRoles(), $user); // remove all roles

        // Assign the new role
        Bouncer::assign($newUsertype)->to($user);
    }

    public function application()
    {
        return $this->hasOne(Application::class, 'user_id');
    }

    public function isActive()
    {
        return $this->status === 'active';
    }



    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
