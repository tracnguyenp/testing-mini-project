<?php

declare(strict_types=1);

namespace TestingAspire\Infra\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class BaseWebController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
