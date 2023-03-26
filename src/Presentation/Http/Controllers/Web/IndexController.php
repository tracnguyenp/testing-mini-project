<?php

declare(strict_types=1);

namespace TestingAspire\Presentation\Http\Controllers\Web;

use TestingAspire\Infra\Http\Controllers\BaseWebController;

class IndexController extends BaseWebController
{
    public function home()
    {
        return '<h1>'.'Welcome to the mini project Testing Aspire from npbtrac@gmail.com'.'</h1>';
    }
}
