<?php

namespace App\Http\Livewire\Common\Notice;

use Illuminate\Support\Collection;
use Illuminate\Support\Arr;

trait CanNotify {

    protected array|Collection $emoticons = [
        "success" => ['🎉', '🤩', '🎊', '🥳', '👏'],
        "info" => ['😇', '🤩', '🤓', '😄', '😃'],
        "primary" => ['✌', '👌', '🤓', '😉', '😊'],
        "warning" => ['🧐', '😬', '🤔', '🙈', '🖖'],
        "danger" => ['🥶', '😳', '🤕', '🥺', '😶'],
    ];

    /**
     * Setup Notice for Notice Livewire Component
     *
     * @param string $type
     * @param string $heading
     * @param string $message
     * @param array $options
     * @return void
     */
    public function notify(string $type, string $heading, string $message, array $options = [])
    {
        $emoticon = Arr::random($this->emoticons[$type] ?? []);
        $notice = [
            'type' => $type,
            'heading' => $heading,
            'message' => $emoticon . ' ' . $message,
        ];
        $data = array_merge($notice, $options);
        $this->triggerNotice($data);
    }

    public function triggerNotice(array $data)
    {
        $this->emit('notice', $data);
    }


}
