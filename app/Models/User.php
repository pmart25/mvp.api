<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Controllers\AuthController;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'deposit',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public static function createUser($userName, $email, $password, $deposit, $role) {

        User::insert([
               'username'=> $userName,
               'email'=> $email,
               'password'=> $password,
               'deposit'=>$deposit,
               'role'=> $role,
               'created_at'=> now(),
               'updated_at'=> now(),
           ]);

    }


    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }

    public static function getDeposit($userId){
      
       
       return User::where('id',  $userId)->select('deposit')->first()->deposit;



    }

    public static function resetDeposit($userId){
      
       
        return User::where('id',  $userId)->update(['deposit' => 0]);
 
 
 
     }


     public static function addDeposit( $amountMoney){
        $userId = auth()->user()->id;
       $userDeposit = self::getDeposit($userId);
       if ($userDeposit == 500) {
          echo "Not possible deposit more than 500 cents.";
          return 0;

       }

       $newDeposit = $userDeposit + $amountMoney;
        return User::where('id',  $userId)->update(['deposit' => $newDeposit]);
 
 
 
     }

     public static function spendDeposit( $amountMoney){
        $userId = auth()->user()->id;
       $userDeposit = self::getDeposit($userId);
       $newDeposit = $userDeposit - $amountMoney;
        return User::where('id',  $userId)->update(['deposit' => $newDeposit]);
  
     }

     public function deposit( $amountMoney){
        $userId = auth()->user()->id;
       $userDeposit = self::getDeposit($userId);
       $newDeposit = $userDeposit+$amountMoney;
        return User::where('id',  $userId)->update(['deposit' => $newDeposit]);
 
 
 
     }
}
