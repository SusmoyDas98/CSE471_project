<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'is_subscribed',
        'password',
    ];

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
            'is_subscribed' => 'boolean',
        ];
    }

    public function detail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function dorms()
    {
        return $this->hasMany(Dorm::class);
    }

    public function communityDorms()
    {
        return $this->belongsToMany(Dorm::class)->withTimestamps()->withPivot('joined_at');
    }

    public function communityPosts()
    {
        return $this->hasMany(CommunityPost::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function selectedRoommates()
    {
        return $this->hasMany(RoommateConnection::class, 'seeker_id');
    }

    public function sentRoommateConnections()
    {
        return $this->selectedRoommates();
    }

    public function selectedByRoommates()
    {
        return $this->hasMany(RoommateConnection::class, 'selected_roommate_id');
    }

    public function receivedRoommateConnections()
    {
        return $this->selectedByRoommates();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function unreadNotifications()
    {
        return $this->hasMany(Notification::class)->where('is_read', false);
    }
}
