<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $title;
    public $required;
    public $disable;
    public $data;
    public $selected;
    public $row;
    public function __construct(
        $name,
        $title,
        $required = null,
        $disable = null,
        $data = [],
        $selected = null,
        $row='row'
    ) {
        $this->name     = $name;
        $this->title    = $title;
        $this->required = $required ? 'required' : '';
        $this->disable  = $disable ? 'disabled' : '';
        $this->data     = $data;
        $this->selected = $selected;
    }

    public function render()
    {

       return view('components.form.select',[ 'data'=>$this->data ]);
    }
}
