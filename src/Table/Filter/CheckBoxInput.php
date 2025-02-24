<?php

namespace Kathore\LaraFormik\Table\Filter;

class CheckBoxInput extends BaseFilter
{

    protected array $data = [
        'label' => null,
        'id' => null,
        'key' => null,
        'resetKey' => [],
        'options' => [],
        'type' => 'checkbox',
        'isEmit' => false,
        'mode' => 'single',
        'value' => '',
        'name' => ''
    ];

    public function label(string $value): self
    {
        $this->data['label'] = $value;
        return $this;  // Return the instance for chaining
    }

    public function name(string $value): self
    {
        $this->data['name'] = $value;
        return $this;  // Return the instance for chaining
    }

    public function options(array $value = []): self
    {
        $this->data['options'] = $value;
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

    public function isEmit(): self
    {
        $this->data['isEmit'] = true;
        return $this;  // Return the instance for chaining
    }

    public function init(): array
    {
        $this->data['key'] = $this->key;
        $this->data['value'] = request()->get($this->key) ?? [];
        return $this->data;
    }


}
