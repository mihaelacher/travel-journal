<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $value,
        public string $type = 'submit',
        public string $classType = 'primary',
        public ?string $icon = null
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.button');
    }
}
