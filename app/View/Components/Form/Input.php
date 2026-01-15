<?php
namespace App\View\Components\Form;

use Illuminate\View\Component;

class Input extends Component
{
    public $name;
    public $title;
    public $type;
    public $required;
    public $disable;
    public $value;
    public $row;
    public function __construct(
        $name,
        $title,
        $required = null,
        $disable = null,
        $value = null,
        $row='row'
    ) {
        $this->name     = $name;
        $this->title    = $title;
        $this->type     = $type ?? 'text';
        $this->required = $required ? 'required' : '';
        $this->disable  = $disable ? 'disabled' : '';
        $this->value    = $value ?? '';
        $this->row    = $row;
    }

    public function render()
    {
        return view('components.form.input');
    }
}
