<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobBatchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array (
  'name' => 'required|string',
  'total_jobs' => 'required|string',
  'pending_jobs' => 'required|string',
  'failed_jobs' => 'required|string',
  'failed_job_ids' => 'required|string',
  'options' => 'required|string',
  'cancelled_at' => 'required|string',
  'finished_at' => 'required|string',
);
    }
}
