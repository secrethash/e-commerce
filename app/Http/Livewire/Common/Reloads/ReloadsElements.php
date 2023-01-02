<?php

namespace App\Http\Livewire\Common\Reloads;

use Exception;
use Illuminate\Support\Str;

trait ReloadsElements {

    /**
     * Process & fires reload events for elements
     * ? Ex: (array) ['tooltip', 'select2', 'modal']
     * ? Ex: (string) "tooltip"
     *
     * @param array|string $elements
     * @return void
     */
    public function reloadElements(array|string|null $elements = null): void
    {
        if (is_null($elements)) {
            // Reload all events in $this->elements
            $elements = $this->elements;
            if (!$elements) {
                throw(new Exception(
                    "Not Initialized or null given for property [\$elements]. "
                ));
            }
        }

        $this->firesReload($elements);
    }

    /**
     * Fires Reload Events
     *
     * @param array|string $elements
     * @return void
     */
    public function firesReload(array|string $elements): void
    {
        // Fire Reload Events
        if (is_array($elements)) {
            foreach ($elements as $element) {
                $this->reloadSingleElement($element);
            }
        } else {
            $this->reloadSingleElement($elements);
        }
    }

    /**
     * Reloads Single Event
     *
     * @param string $element
     * @return void
     */
    public function reloadSingleElement(string $element): void
    {
        $studly = Str::studly($element);
        $slug = Str::slug($element);

        $event = "reload{$studly}Event";

        // If StudlyCase Event function is present call it
        // else emit slug cased event
        method_exists($this, $event) ?
            $this->{$event}() :
            $this->emit("reload-{$slug}");
    }

    /**
     * Reload Tooltip Event
     *
     * @return void
     */
    public function reloadTooltipEvent(): void
    {
        $this->emit('reload-tooltip');
    }

    /**
     * Reload Select2 Event
     *
     * @return void
     */
    // public function reloadSelect2Event(): void
    // {
    //     $this->emit('reload-select2');
    // }

    /**
     * Reload Modal Event
     *
     * @return void
     */
    public function reloadModalEvent(): void
    {
        $this->emit('reload-modal');
    }
}
