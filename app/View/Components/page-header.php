<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class PageHeader extends Component
{
    public string $title;

    /**
     * Create a new component instance.
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|string
    {
        return view('components.page-header');
    }
}