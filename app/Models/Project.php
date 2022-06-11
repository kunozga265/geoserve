<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function requestForms()
    {
        return $this->hasMany(RequestForm::class);
    }

    protected $fillable=[
        "name",
        "client",
        "site",
        "verified",
    ];

    protected $hidden=[
      "created_at",
      "updated_at",
    ];
}
