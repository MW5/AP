<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\MailResetPasswordToken;

class User extends Authenticatable
{
    use Notifiable;
    
    public $manager = "menadżer";
    public $polishingServiceForeman = "brygadzista polerni";
    public $autodetailingForeman = "brygadzista hali autodetailingu";
    public $polishingServiceWorker = "pracownik polerni";
    public $autodetailer = "pracownik autodetailingu";
    
    public $warehouseAll = "menadżer";
    public $warehousePolishingService = "polernia";
    public $warehouseAutodetailing = "autodetailing";
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'account_type', 'warehouse'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }
    
    
    
    
}
