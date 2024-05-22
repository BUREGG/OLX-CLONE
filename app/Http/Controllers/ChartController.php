<?php

namespace App\Http\Controllers;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function chart(){

    $chart_options = [
        'chart_title' => 'Users by months',
        'report_type' => 'group_by_string',
        'model' => 'App\Models\Product',
        'group_by_field' => 'views',
        'group_by_period' => 'month',
        'chart_type' => 'bar',
    ];
    $chart1 = new LaravelChart($chart_options);
    
    return view('chart', compact('chart1'));
}
}
