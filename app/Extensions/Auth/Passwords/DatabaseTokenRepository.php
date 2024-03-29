<?php

namespace App\Extensions\Auth\Passwords;

use Illuminate\Auth\Passwords\DatabaseTokenRepository as DatabaseTokenRepositoryBase;
//use App\Extensions\Auth\Contracts\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
// use Illuminate\Contracts\Hashing\Hasher as HasherContract;
// use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Carbon;
// use Illuminate\Support\Str;

class DatabaseTokenRepository extends DatabaseTokenRepositoryBase
{
    /**
     * The database connection instance.
     *
     * @var \Illuminate\Database\ConnectionInterface
     */
    // protected $connection;

    // /**
    //  * The Hasher implementation.
    //  *
    //  * @var \Illuminate\Contracts\Hashing\Hasher
    //  */
    // protected $hasher;

    // *
    //  * The token database table.
    //  *
    //  * @var string
     
    // protected $table;

    // /**
    //  * The hashing key.
    //  *
    //  * @var string
    //  */
    // protected $hashKey;

    // /**
    //  * The number of seconds a token should last.
    //  *
    //  * @var int
    //  */
    // protected $expires;

    /**
     * Create a new token repository instance.
     *
     * @param  \Illuminate\Database\ConnectionInterface  $connection
     * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
     * @param  string  $table
     * @param  string  $hashKey
     * @param  int  $expires
     * @return void
     */
    // public function __construct(ConnectionInterface $connection, HasherContract $hasher,
    //                             $table, $hashKey, $expires = 60)
    // {
    //     $this->table = $table;
    //     $this->hasher = $hasher;
    //     $this->hashKey = $hashKey;
    //     $this->expires = $expires * 60;
    //     $this->connection = $connection;
    // }
    
    // public function create(CanResetPasswordContract $user)
    // {
    //     $email = $user->getEmailForPasswordReset();
    //     $phone = $user->getPhoneForPasswordReset();
    //     $this->deleteExisting($user);
    //     $token = $this->createNewToken();
    //     $medium = isset($email) ? $email : $phone;
    //     ddd($this->getPayload($medium, $token));
    //     $this->getTable()->insert($this->getPayload($medium, $token));
    //     return $token;
    // }

    public function create(CanResetPasswordContract $user)
    {
        $email = $user->getEmailForPasswordReset();
        $phone = $user->getPhoneForPasswordReset();
        $this->deleteExisting($user);
        $token = $this->createNewToken();
        $medium = isset($email) ? $email : $phone;
        $this->getTable()->insert($this->getPayload($medium, $token));
        return $token;
    }

    protected function deleteExisting(CanResetPasswordContract $user)
    {
        return $this->getTable()
            ->where('email', $user->getEmailForPasswordReset())
            ->orWhere('phone', $user->getPhoneForPasswordReset())
            ->delete();
    }

    protected function getPayload($medium, $token)
    {
        // return ['phone' => $medium, 'token' => $this->hasher->make($token), 'created_at' => new Carbon];
        if( strpos($medium, '@') !== false) 
            {
                return ['email' => $medium, 'token' => $this->hasher->make($token), 'created_at' => new Carbon];
            }              
            return ['phone' => $medium, 'token' => $this->hasher->make($token), 'created_at' => new Carbon];
    }
    
    public function exists(CanResetPasswordContract $user, $token)
    {
        $record = (array) $this->getTable()
            ->where('email', $user->getEmailForPasswordReset())
            ->orWhere('phone', $user->getPhoneForPasswordReset())
            ->first();
        return $record &&
               ! $this->tokenExpired($record['created_at']) &&
                 $this->hasher->check($token, $record['token']);
    }

    // function __call($name_of_function, $arguments) { 
              
    //     // It will match the function name 
    //     if ($name_of_function == 'getPayload') { 
    //         ddd('mmmmmmmmmmmmm');
    //         if( strpos($arguments[0], '@') !== false) 
    //         {
    //             return ['email' => $medium, 'token' => $this->hasher->make($token), 'created_at' => new Carbon];
    //         }              
    //         return ['phone' => $medium, 'token' => $this->hasher->make($token), 'created_at' => new Carbon];
    //     }
    //         // switch ($arguments[0]) { 
                      
    //         //     // If there is only one argument 
    //         //     // area of circle 
    //         //     case '': 
    //         //         return 3.14 * $arguments[0]; 
                          
    //         //     // IF two arguments then area is rectangel; 
    //         //     case 2: 
    //         //         return $arguments[0]*$arguments[1]; 
    //         // } 
    // }


    // /**
    //  * Create a new token record.
    //  *
    //  * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
    //  * @return string
    //  */
    // public function create(CanResetPasswordContract $user)
    // {
    //     $email = $user->getEmailForPasswordReset();

    //     $this->deleteExisting($user);

    //     // We will create a new, random token for the user so that we can e-mail them
    //     // a safe link to the password reset form. Then we will insert a record in
    //     // the database so that we can verify the token within the actual reset.
    //     $token = $this->createNewToken();

    //     $this->getTable()->insert($this->getPayload($email, $token));

    //     return $token;
    // }

    // /**
    //  * Delete all existing reset tokens from the database.
    //  *
    //  * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
    //  * @return int
    //  */
    // protected function deleteExisting(CanResetPasswordContract $user)
    // {
    //     return $this->getTable()->where('email', $user->getEmailForPasswordReset())->delete();
    // }

    // /**
    //  * Build the record payload for the table.
    //  *
    //  * @param  string  $email
    //  * @param  string  $token
    //  * @return array
    //  */
    // protected function getPayload($email, $token)
    // {
    //     return ['email' => $email, 'token' => $this->hasher->make($token), 'created_at' => new Carbon];
    // }

    // /**
    //  * Determine if a token record exists and is valid.
    //  *
    //  * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
    //  * @param  string  $token
    //  * @return bool
    //  */
    // public function exists(CanResetPasswordContract $user, $token)
    // {
    //     $record = (array) $this->getTable()->where(
    //         'email', $user->getEmailForPasswordReset()
    //     )->first();

    //     return $record &&
    //            ! $this->tokenExpired($record['created_at']) &&
    //              $this->hasher->check($token, $record['token']);
    // }

    // /**
    //  * Determine if the token has expired.
    //  *
    //  * @param  string  $createdAt
    //  * @return bool
    //  */
    // protected function tokenExpired($createdAt)
    // {
    //     return Carbon::parse($createdAt)->addSeconds($this->expires)->isPast();
    // }

    // /**
    //  * Delete a token record by user.
    //  *
    //  * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
    //  * @return void
    //  */
    // public function delete(CanResetPasswordContract $user)
    // {
    //     $this->deleteExisting($user);
    // }

    // /**
    //  * Delete expired tokens.
    //  *
    //  * @return void
    //  */
    // public function deleteExpired()
    // {
    //     $expiredAt = Carbon::now()->subSeconds($this->expires);

    //     $this->getTable()->where('created_at', '<', $expiredAt)->delete();
    // }

    // /**
    //  * Create a new token for the user.
    //  *
    //  * @return string
    //  */
    // public function createNewToken()
    // {
    //     return hash_hmac('sha256', Str::random(40), $this->hashKey);
    // }

    // /**
    //  * Get the database connection instance.
    //  *
    //  * @return \Illuminate\Database\ConnectionInterface
    //  */
    // public function getConnection()
    // {
    //     return $this->connection;
    // }

    // /**
    //  * Begin a new database query against the table.
    //  *
    //  * @return \Illuminate\Database\Query\Builder
    //  */
    // protected function getTable()
    // {
    //     return $this->connection->table($this->table);
    // }

    // /**
    //  * Get the hasher instance.
    //  *
    //  * @return \Illuminate\Contracts\Hashing\Hasher
    //  */
    // public function getHasher()
    // {
    //     return $this->hasher;
    // }
}
