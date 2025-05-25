<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobBatch;

use App\Interfaces\CrudInterface;
/**
 * @group JobBatch
*/
class JobBatchController extends Controller
{
    public CrudInterface $model;

    public function __construct()
    {
        $this->model = new JobBatch();
    }
}