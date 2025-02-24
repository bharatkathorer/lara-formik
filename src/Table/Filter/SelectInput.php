<?php

namespace Kathore\LaraFormik\Table\Filter;

class SelectInput extends BaseFilter
{
    protected array $data = [
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

    public function label(string $value): self
    {
        $this->data['label'] = $value;
        return $this;  // Return the instance for chaining
    }

    public function setId(string $value): self
    {
        $this->data['id'] = $value;
        return $this;  // Return the instance for chaining
    }

    public function resetKey(array $value = []): self
    {
        $this->data['resetKey'] = $value;
        return $this;  // Return the instance for chaining
    }

    public function options(array $value = []): self
    {
        $this->data['options'] = $value;
        return $this;  // Return the instance for chaining
    }

    public function multiple(): self
    {
        $this->data['mode'] = 'tags';
        return $this;  // Return the instance for chaining
    }

    public function isEmit(): self
    {
        $this->data['isEmit'] = true;
        return $this;  // Return the instance for chaining
    }

    public function init(): array
    {

        $key = $this->data['key'] = $this->key;
        $value = ($this->data['mode'] === 'tags') ? [] : "";

        if (request()->get($key)) {
            if ($this->data['mode'] === 'tags') {
                $value = request()->get($key);
            } else {
                $value = request()->get($key);
            }
        }
        $this->data['value'] = $value;
        return $this->data;
    }

}
