<?php

namespace App\Http\Controllers;

class DataController extends Controller
{
    public function jobs()
    {
        return config('data-jobs');
    }
}
