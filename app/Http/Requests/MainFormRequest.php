<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\SanitizeInputTrait;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

abstract class MainFormRequest extends FormRequest
{
    use SanitizeInputTrait;

    public $currentUser;

    public function __construct()
    {
        parent::__construct();
        $this->currentUser = Auth::user();
        $this->extendValidatorRules();
    }

    public function rules (): array
    {
        return [];
    }

    public function validator($factory)
    {
        return $factory->make(
            $this->sanitizeInput(),
            $this->container->call([$this, 'rules']),
            $this->messages(),
            $this->attributes()
        );
    }

    protected function extendValidatorRules()
    {
        // do nothing
    }
}
