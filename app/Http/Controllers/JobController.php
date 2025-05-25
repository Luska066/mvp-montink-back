<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Job;

use App\Interfaces\CrudInterface;
/**
 * @group Job
*/
class JobController extends Controller
{
    public CrudInterface $model;

    public function __construct()
    {
        $this->model = new Job();
    }
}