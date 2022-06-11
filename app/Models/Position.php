<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    protected $fillable=[
        "title",
        "grade_id",
        "approvalStages",
        "state",
    ];

    protected $hidden=[
        "approvalStages"
    ];
}
