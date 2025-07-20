<?php
namespace App\View\Components;

use Illuminate\View\Component;

class ShowButton extends Component
{
    public $route;
    public $param;
    public $name;

    /**
     * Create a new component instance.
     *
     * @param string $route
     * @param mixed $param
     * @param string $name
     * @return void
     */
    public function __construct($route, $param, $name = null)
    {
        $this->route = $route;
        $this->param = $param;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.show-button');
    }
}
