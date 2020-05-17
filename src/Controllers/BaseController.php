<?php

namespace Manager\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Manager\Controllers\Traits\MakesResponses;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, Helpers, ValidatesRequests, MakesResponses;
}
