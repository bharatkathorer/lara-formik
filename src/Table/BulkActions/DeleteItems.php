<?php

namespace Kathore\LaraFormik\Table\BulkActions;

class DeleteItems
{
    protected array $data = [
        'name' => "Delete",
        'id' => 'delete',
        'modal' => "",
        'confirm' => false,
        'handleActions' => true,
        'isEmit' => false,
        'message' => "Are you sure you want to delete the selected items?",
        'success_message' => "The selected items  have been deleted successfully.",
    ];

    public function init(): array
    {
        return $this->data;
    }

    public static function make(string $id = 'delete'): self
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

    public function label(string $value): self
    {
        $this->data['label'] = $value;
        return $this;
    }

    public function name(string $value): self
    {
        $this->data['name'] = $value;
        return $this;
    }

    public function isConfirm(): self
    {
        $this->data['confirm'] = true;
        return $this;
    }

    public function isEmit(): self
    {
        $this->data['isEmit'] = true;
        return $this;
    }

    public function isCustomAction(): self
    {
        $this->data['handleActions'] = false;
        return $this;
    }

    public function message(string $message): self
    {
        $this->data['message'] = $message;
        return $this;
    }

    public function successMessage(string $successMessage): self
    {
        $this->data['success_message'] = $successMessage;
        return $this;
    }


}
