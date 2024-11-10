<?php

namespace Kathore\LaraFormik\Table\Action;

class CustomItem
{
    protected $data = [
        'name' => "Make action",
        'id' => null,
        'modal' => '',
    ];

    public function init()
    {
        return $this->data;
    }

    public static function make(string $className, string $id = null)
    {
        $instance = new self();
        $instance->data['modal'] = $className;
        $instance->data['id'] = $id;
        return $instance;
    }


    public function name(string $value)
    {
        $this->data['name'] = $value;
        return $this;
    }

    public function id(string $value)
    {
        $this->data['id'] = $value;
        return $this;
    }

}
