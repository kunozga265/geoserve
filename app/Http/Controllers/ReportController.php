<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function getCurrentReport()
    {
        $month=date('F');
        $year=date('Y');

        if(Report::where('year',$year)->where('month',$month)->exists())
            return Report::where('year',$year)->where('month',$month)->first();
        else
            return Report::create(['year'  =>  $year, 'month' =>  $month,]);
    }
}
