<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{

    protected $userClass = User::class;

    protected $fillable = ['size', 'prefecture', 'address', 'description', 'user_id'];

    public function user()
    {
        return $this->belongsTo($this->userClass);
    }
}
