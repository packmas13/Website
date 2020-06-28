<?php


namespace WPDM;


class Form
{
    private $formFields;
    private $method = 'post';
    private $action = '';
    private $name = 'form';
    private $id = 'form';
    private $class = 'form';
    function __construct($formFields, $attrs = array())
    {
        $this->formFields = $formFields;
        foreach ($attrs as $name => $value){
            $this->$name = $value;
        }
    }

    function div($class = '', $id = ''){
        return "<div class='{$class}' id='row_{$id}'>";
    }
    function divClose(){
        return "</div>";
    }

    function label($label, $for = ''){
        return "<label form='{$for}'>{$label}</label>";
    }

    function row($id, $fields){
         $row = $this->div("form-row", $id);
         if(isset($fields['label']))
             $this->label($fields['label'], $id);

         foreach ($fields['cols'] as $id => $field){
             $row .= $this->formGroup($id, $field);
         }

         $row .= $this->divClose();
         return $row;
    }

    function formGroup($id, $field){
        $grid_class = isset($field['grid_class'])?$field['grid_class']:'';
        $field_html = $this->div("form-group {$grid_class}", $id);
        if(isset($field['label']))
            $field_html .= $this->label($field['label'], $id);
        $type = $field['type'];
        $field_html .= $this->$type($field['attrs']);
        $field_html .= $this->divClose();
        return $field_html;
    }

    function text($attrs){
        $_attrs = "";
        $attrs['class'] = isset($attrs['class']) ? "form-control ".$attrs['class']: "form-control";
        foreach ($attrs as $key => $value){
            $_attrs .= "{$key}='{$value}' ";
        }
        return "<input type='text' $_attrs />";
    }

    function email($attrs){
        $_attrs = "";
        $attrs['class'] = isset($attrs['class']) ? "form-control ".$attrs['class']: "form-control";
        foreach ($attrs as $key => $value){
            $_attrs .= "{$key}='{$value}' ";
        }
        return "<input type='email' $_attrs />";
    }

    function password($attrs){
        $_attrs = "";
        $attrs['class'] = isset($attrs['class']) ? "form-control ".$attrs['class']: "form-control";
        foreach ($attrs as $key => $value){
            $_attrs .= "{$key}='{$value}' ";
        }
        return "<input type='password' $_attrs />";
    }

    function render(){
        $form_html = "<form method='{$this->method}' action='{$this->action}' name='{$this->name}' id='{$this->id}' class='{$this->class}'>";
        foreach ($this->formFields as $id => $field){
            if(isset($field['parts']))
                $form_html .= $this->row($id, $field);
            else
                $form_html .= $this->formGroup($id, $field);
        }
        $form_html .= "</form>";
        return $form_html;
    }
}
