<?php

namespace App\VueTable\Table\BulkActions;

class CustomItem
{
    protected array $data = [
        'name' => "Make action",
        'id' => null,
        'modal' => '',
    ];

    public function init(): array
    {
        return $this->data;
    }

    public static function make(string $id): self
    {
        $instance = new self();
        $instance->data['id'] = $id;
        return $instance;
    }

    public function model(string $model): self
    {
        $this->data['model'] = $model;
        return $this;
    }


    public function name(string $value): self
    {
        $this->data['name'] = $value;
        return $this;
    }

    public function id(string $value): self
    {
        $this->data['id'] = $value;
        return $this;
    }

}
