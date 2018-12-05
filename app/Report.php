<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{

    protected $userClass = User::class;
    protected $goodClass = Good::class;

    protected $with = ['user'];

    protected $fillable = ['size', 'prefecture', 'address', 'description', 'user_id'];

    public function user()
    {
        return $this->belongsTo($this->userClass);
    }

    public function goods()
    {
        return $this->hasMany($this->goodClass);
    }

    public function good_by()
    {
        return Good::where('user_id', auth()->user()->id)->first();
    }
}
