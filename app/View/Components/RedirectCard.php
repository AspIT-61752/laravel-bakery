<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RedirectCard extends Component
{
    /**
     * Create a new component instance.
     */

    public ?string $title;
    public ?string $content;
    public ?string $url;

    public function __construct(?string $title = null, ?string $content = null, ?string $url = null)
    {
        $this->title = $title;
        $this->content = $content;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(?string $title = null, ?string $content = null, ?string $url = null)
    {
        return view('components.redirect-card', [
            'title' => $title,
            'content' => $content,
            'url' => $url,
        ]);
    }
}
