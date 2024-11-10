<?php

namespace Kathore\LaraFormik\Table\Action;

class DeleteItems
{
    protected $data = [
        'name' => "Delete",
        'id' => 'delete',
        'modal' => "",
        'confirm' => false,
        'handleActions' => true,
        'isEmit' => false,
        'message' => "Are you sure you want to delete the selected items?",
        'success_message' => "The selected items  have been deleted successfully.",
    ];

    public function init()
    {
        return $this->data;
    }

    public static function make(string $className, string $id_name = null)
    {
        if (!$id_name) {
            $id_name = "delete";
        }
        $instance = new self();
        $instance->data['modal'] = $className;
        $instance->data['id'] = $id_name;
        return $instance;
    }

    public function label(string $value)
    {
        $this->data['label'] = $value;
        return $this;
    }

    public function name(string $value)
    {
        $this->data['name'] = $value;
        return $this;
    }

    public function isConfirm()
    {
        $this->data['confirm'] = true;
        return $this;
    }

    public function isEmit()
    {
        $this->data['isEmit'] = true;
        return $this;
    }

    public function isCustomeAction()
    {
        $this->data['handleActions'] = false;
        return $this;
    }

    public function message(string $message)
    {
        $this->data['message'] = $message;
        return $this;
    }

    public function successMessage(string $successMessage)
    {
        $this->data['success_message'] = $successMessage;
        return $this;
    }


}
