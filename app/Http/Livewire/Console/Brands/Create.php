<?php

namespace App\Http\Livewire\Console\Brands;

use Illuminate\Contracts\View\View;
use Shopper\Framework\Http\Livewire\AbstractBaseComponent;
use Shopper\Framework\Repositories\Ecommerce\BrandRepository;
use Shopper\Framework\Traits\WithSeoAttributes;

class Create extends AbstractBaseComponent
{
    use WithSeoAttributes;

    public string $name = '';

    public ?string $website = null;

    public ?string $description = null;

    public bool $is_enabled = true;

    public bool $aftermarket = true;

    public ?string $fileUrl = null;

    public $seoAttributes = [
        'name' => 'name',
        'description' => 'description',
    ];

    protected $listeners = [
        'trix:valueUpdated' => 'onTrixValueUpdate',
        'shopper:fileUpdated' => 'onFileUpdate',
    ];

    public function onTrixValueUpdate($value)
    {
        $this->description = $value;
    }

    public function onFileUpdate($file)
    {
        $this->fileUrl = $file;
    }

    public function store(): void
    {
        $this->validate($this->rules());

        $brand = (new BrandRepository())->create([
            'name' => $this->name,
            'slug' => $this->name,
            'website' => $this->website,
            'description' => $this->description,
            'is_enabled' => $this->is_enabled,
            'aftermarket' => $this->aftermarket,
            'seo_title' => $this->seoTitle,
            'seo_description' => $this->seoDescription,
        ]);

        if ($this->fileUrl) {
            $brand->addMedia($this->fileUrl)->toMediaCollection(config('shopper.system.storage.disks.uploads'));
        }

        session()->flash('success', __('Brand successfully added!'));

        $this->redirectRoute('shopper.brands.index');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:150|unique:' . shopper_table('brands'),
        ];
    }

    public function render(): View
    {
        return view('livewire.console.brands.create');
    }
}
