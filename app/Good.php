<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use kanazaca\CounterCache\CounterCache;

class Good extends Model
{
    use CounterCache;

    protected $reportClass = Report::class;
    protected $userClass = User::class;

    public $counterCacheOptions = [
        'Report' => [
            'field' => 'goods_count',
            'foreignKey' => 'report_id'
        ]
    ];

    protected $fillable = ['user_id', 'report_id'];

    public function Report()
    {
        return $this->belongsTo($this->reportClass);
    }

    public function User()
    {
        return $this->belongsTo($this->userClass);
    }
}
