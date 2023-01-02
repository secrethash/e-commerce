<?php

namespace App\Http\Livewire\Common\Notice;

interface Notifications {

    public function triggerNotice(array $data);

    public function notify(string $type, string $heading, string $message, array $options = []);

}
