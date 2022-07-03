<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public function requestForms()
    {
        return $this->belongsToMany(RequestForm::class,'report_request','report_id','request_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'report_user','report_id','user_id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class,'report_project','report_id','project_id');
    }

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class,'report_vehicle','report_id','vehicle_id');
    }


    protected $fillable=[
        'year',
        'month',
    ];
}
