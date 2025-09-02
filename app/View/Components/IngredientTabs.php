<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class IngredientTabs extends Component
{
    public $ingredient;

    /**
     * Create a new component instance.
     */
    public function __construct($ingredient)
    {
        $this->ingredient = $ingredient;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ingredient-tabs');
    }
}
