<?php

namespace Kathore\LaraFormik\Table\Filter;

class SelectInput
{
    protected $data = [
        'label' => null,
        'id' => null,
        'key' => null,
        'resetKey' => [],
        'options' => [],
        'type' => 'multiselect',
        'isEmit' => false,
        'mode' => 'single',
        'value' => ''
    ];

    public function label(string $value)
    {
        $this->data['label'] = $value;
        return $this;  // Return the instance for chaining
    }

    public function setId(string $value)
    {
        $this->data['id'] = $value;
        return $this;  // Return the instance for chaining
    }

    public function resetKey(array $value = [])
    {
        $this->data['resetKey'] = $value;
        return $this;  // Return the instance for chaining
    }

    public function options(array $value = [])
    {
        $this->data['options'] = $value;
        return $this;  // Return the instance for chaining
    }

    public function multiple()
    {
        $this->data['mode'] = 'tags';
        return $this;  // Return the instance for chaining
    }

    public function isEmit()
    {
        $this->data['isEmit'] = true;
        return $this;  // Return the instance for chaining
    }

    public function init()
    {
        $param = $this->data['key'];
        $value = ($this->data['mode'] === 'tags') ? [] : "";
        if (request()->get($param)) {
            if ($this->data['mode'] === 'tags') {
                $value = request()->get($param);
            } else {
                $value = request()->get($param);
            }
        }
        $this->data['value'] = $value;
        return $this->data;
    }

    public static function make(string $param)
    {
        $instance = new self();  // Create a new instance of the object

        $instance->data['key'] = $param;  // Initialize the key
        // Return the instance to allow chaining
        return $instance;
    }

}
