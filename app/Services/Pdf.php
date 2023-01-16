<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Pdf {

    private $url;
    private $data;
    private $path;
    private $relative;
    private $_endpoint;
    private $_apikey;
    private $_contentType = 'application/json';
    private $request;

    public function __construct($url, $data = [])
    {
        $this->_apikey = config('services.pdf.api');
        $this->_endpoint = config('services.pdf.endpoint');
        $this->path = config('services.pdf.storage');

        $this->url = $url;
        $this->data = [
            "output" => Arr::has($data, 'output') ? $data['output'] : "data",
            "url" => $this->url,
            "page_options" => [
                "wait_network" => Arr::has($data, 'wait_network') ? $data['wait_network'] : true,
            ],
            "pdf_options" => [
                "paper_size" => Arr::has($data, 'paper_size') ? $data['paper_size'] : "A4",
            ],
        ];
    }

    public function generate()
    {
        $request = Http::withHeaders([
            'X-API-KEY' => $this->_apikey,
            'Content-Type' => $this->_contentType,
        ])->post($this->_endpoint, $this->data);

        $this->request = $request;
        return $this;
    }

    public function save($filename, $path = null, $disk = 'local')
    {
        $path = $path ?? $this->path;
        $filepath = $path.$filename;

        if(Storage::disk($disk)->exists($filepath))
        {
            Storage::disk($disk)->delete($filepath);
        }

        Storage::disk($disk)->put($filepath, $this->request->body(), 'public');
        $this->relative = Storage::disk($disk)->path($filepath);

        return $this;
    }

    public function get($filename, $path = null, $disk = 'local')
    {
        $path = $path ?? $this->path;
        $filepath = $path.$filename;

        if(Storage::disk($disk)->exists($filepath))
        {
            $this->relative =  Storage::disk($disk)->path($filepath);
            return $this;
        }

        return false;
    }

    public function url()
    {
        return $this->relative;
    }

    public static function getOrGenerate($filename, $url, $path = null, $disk = 'local')
    {
        $pdf = new self($url);
        $return = $pdf->get($filename, $path, $disk);

        if (!$return)
        {
            // Generate
            $return = $pdf->generate()->save($filename);
        }

        return $return->url();

        // $pdf = new $this($this->url);
        // return $pdf->generate()->save($filename, $path, $disk);
    }

}
