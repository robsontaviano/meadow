<?php

namespace Meadow\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $id = null,
        public ?string $value = null,
        public ?string $icon = null,
        public ?string $iconRight = null,

    ) {
        $this->uuid = "meadow" . md5(serialize($this)) . $id;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
                <div {{ $attributes->class(["badge"])}}>
                    <!-- ICON -->
                    @if($icon)
                        <x-meadow-icon :name="$icon" class="h-4 w-4" />
                    @endif

                    <!-- VALUE / SLOT -->
                    {{ $value ??  $slot }}
                    
                    <!-- ICON RIGHT -->
                    @if($iconRight)
                        <x-meadow-icon :name="$iconRight" class="h-4 w-4" />
                    @endif
                </div>
            HTML;
    }
}
