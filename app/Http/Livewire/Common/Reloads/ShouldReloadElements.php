<?php

namespace App\Http\Livewire\Common\Reloads;

interface ShouldReloadElements {

    /**
     * Process & fires reload events for elements
     * ? Ex: (array) ['tooltip', 'select2', 'modal']
     * ? Ex: (string) "tooltip"
     *
     * @param array|string $elements
     * @return void
     */
    public function reloadElements(array|string|null $elements = null): void;

    /**
     * Fires Reload Events
     *
     * @param array|string $elements
     * @return void
     */
    public function firesReload(array|string $elements): void;

    /**
     * Reloads Single Event
     *
     * @param string $element
     * @return void
     */
    public function reloadSingleElement(string $element): void;

}
