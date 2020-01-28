<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnBoardAccount extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'accounts';
    protected $fillable  = ['username', 'password'];

}
