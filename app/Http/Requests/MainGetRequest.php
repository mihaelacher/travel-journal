<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\SanitizeInputTrait;
use Auth;
use Illuminate\Http\Request;

abstract class MainGetRequest extends Request
{
    use SanitizeInputTrait;

    public $currentUser;

    public function __construct()
    {
        parent::__construct();
        $this->currentUser = Auth::user();
        $this->setQueryParams();
        $this->sanitizeInput();
    }

    /**
     * @return void
     */
    private function setQueryParams(): void
    {
        foreach (request()->input() as $key => $getParameter) {
            $this->merge([$key => $getParameter]);
        }
    }
}
