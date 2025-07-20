<?php
namespace App\View\Components;

use Illuminate\View\Component;

class AddButton extends Component
{
    public $model;
    public $name;
    public $displayName;

    /**
     * Create a new component instance.
     *
     * @param string $model
     * @param string $name
     * @param string $displayName
     * @return void
     */
    public function __construct($model, $name = null, $displayName = null)
    {
        $this->model = $model;
        $this->name = $name;
        $this->displayName = $displayName ?? $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.add-button');
    }
}
