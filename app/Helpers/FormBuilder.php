<?php

namespace App\Helpers;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Foundation\Http\FormRequest;

class FormBuilder
{
    protected $fields = [];
    protected $formAttributes = [];
    protected $errors = [];
    protected $rules = [];
    protected $validator;

    public function __construct()
    {
        $this->validator = app(ValidationFactory::class)->make([], []);
    }


    public function openForm($action = '', $method = 'POST', $formName = '', $attributes = [])
    {
        $this->formAttributes = [
            'action' => $action,
            'method' => $method,
            'formName' => $formName ? $formName : '',
            'attributes' => $attributes,
        ];
    }

    public function closeForm()
    {
        $html = '</form>';
        $html .= '</div>';

        return $html;
    }

    public function addField($type, $name, $label, $options = [], $value = '')
    {
        if ($type === 'submit') {
            $this->addSubmitButton($name, $label, $options);
        } else {
            $this->fields[] = compact('type', 'name', 'label', 'options', 'value');
            if (isset($options['rules'])) {
                $this->rules[$name] = $options['rules'];
            }
        }
    }

    public function addSubmitButton($name, $label, $options = [])
    {
        $this->fields[] = [
            'type' => 'submit',
            'name' => $name,
            'label' => $label,
            'options' => $options,
        ];
    }

    public function render()
    {
//        $html = $this->openFormTag();
        $html = '';

        foreach ($this->fields as $field) {
            $html .= $this->renderField($field);
        }

//        $html .= $this->closeForm();

        return $html;
    }

    public function withErrors($errors)
    {
        $this->errors = $errors;
    }

    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

//    public function validateRequest($request)
//    {
//        foreach ($this->fields as $field) {
//            $name = $field['name'];
//            $options = $field['options'];
//
//            if (isset($options['regex'])) {
//                $value = $request->input($name);
//                $regex = $options['regex'];
//
//                if (!preg_match($regex, $value)) {
//                    $this->addError($name, $options['error_message']);
//                }
//            }
//        }
//
//        return empty($this->errors);
//    }

    public function validateRequest(FormRequest $request)
    {
        $this->validator->setData($request->all());
        $this->validator->setRules($this->rules);

        if ($this->validator->fails()) {
            $this->errors = $this->validator->errors()->messages();
            return false;
        }

        return true;
    }

    protected function openFormTag()
    {
        $action = $this->formAttributes['action'];
        $method = $this->formAttributes['method'];
        $attributes = $this->formAttributes['attributes'];

        $html = '<div class="box box-info">';
        $html .= '<div class="box-header with-border">';
        $html .= '<h3 class="box-title"> ' . $this->formAttributes['formName'] . ' </h3>';
        $html .= '</div>';
        $html .= '<form class="form-horizontal" action="' . $action . '" method="' . $method . '"';

        foreach ($attributes as $attribute => $value) {
            $html .= ' ' . $attribute . '="' . $value . '"';
        }

        $html .= '>';
//        $html .= csrf_field();
        $html .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';

        return $html;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    protected function renderField($field)
    {
        $type = $field['type'];
        $name = $field['name'];
        $label = $field['label'];
        $options = $field['options'];

        $appendLabelColumn = "col-sm-2";

        $html = '<div class="box-body row">';

        if ($type !== 'submit') {
            if (isset($options['id'])) {
                $html .= '<label class="col-form-label ' . $appendLabelColumn .' " for="' . $options['id'] . '">' . $label . '</label>';
            } else {
                $html .= '<label class="col-form-label ' . $appendLabelColumn .'" for="' . $name . '">' . $label . '</label>';
            }
        } else {
            $html .= '<label class="col-form-label ' . $appendLabelColumn .'" for="' . $name . '"></label>';
        }

        $html .= '<div class="col-sm-10">';

        $attributes = '';
        if (isset($options['class'])) {
            $attributes .= ' class="' . $options['class'] . '"';
        }
        if (isset($options['id'])) {
            $attributes .= ' id="' . $options['id'] . '"';
        }


        switch ($type) {
            case 'text':
                $html .= $this->renderTextInput($name, $options);
                break;
            case 'email':
                $html .= $this->renderEmailInput($name, $options);
                break;
            case 'password':
                $html .= $this->renderPasswordInput($name, $options);
                break;
            case 'textarea':
                $html .= $this->renderTextarea($name, $options);
                break;
            case 'select':
                $html .= $this->renderSelect($name, $options);
                break;
            case 'checkbox':
                $html .= $this->renderCheckbox($name, $label, $options);
                break;
            case 'radio':
                $html .= $this->renderRadio($name, $label, $options);
                break;
            case 'submit':
                $html .= $this->renderSubmitButton($name, $label, $options);
                break;
            // Thêm các loại trường khác tại đây
        }

        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    protected function renderTextInput($name, $options)
    {
        // Kiểm tra regex nếu có
        if (isset($options['regex'])) {
            $value = $_POST[$name] ?? '';
            $regex = $options['regex'];
            $this->validateRegex($name, $value, $regex);
        }

        $html = '<input type="text"  name="' . $name . '"';

        foreach ($options as $option => $value) {
            if ($option !== 'id') {
                $html .= ' ' . $option . '="' . $value . '"';
            }
        }

        // Kiểm tra nếu có thuộc tính css_class
        if (isset($options['class'])) {
            $html .= ' class="form-control ' . $options['class'] . '"';
        } else {
            $html .= ' class="form-control"';
        }

        // Kiểm tra nếu có thuộc tính id
        if (isset($options['id'])) {
            $html .= ' id="' . $options['id'] . '"';
        }

        $html .= '>';

        // Kiểm tra nếu trường có thông báo lỗi
        $errors = session('errors');

        if ($errors && $errors->has($name)) {
            $error = $errors->first($name);
            $html .= '<span class="error-message">' . $error . '</span>';
        }

        return $html;
    }

    protected function renderEmailInput($name, $options)
    {
        $html = '<input type="email" class="form-control" name="' . $name . '"';

        foreach ($options as $option => $value) {
            if ($option !== 'id') {
                $html .= ' ' . $option . '="' . $value . '"';
            }
        }

        $html .= '>';

        $errors = session('errors');

        if ($errors && $errors->has($name)) {
            $error = $errors->first($name);
            $html .= '<span class="error-message">' . $error . '</span>';
        }

        return $html;
    }

    protected function renderPasswordInput($name, $options)
    {
        $html = '<input class="form-control" type="password" name="' . $name . '"';

        foreach ($options as $option => $value) {
            if ($option !== 'id') {
                $html .= ' ' . $option . '="' . $value . '"';
            }
        }

        $html .= '>';

        $errors = session('errors');

        if ($errors && $errors->has($name)) {
            $error = $errors->first($name);
            $html .= '<span class="error-message">' . $error . '</span>';
        }

        return $html;
    }

    protected function renderTextarea($name, $options)
    {
        $html = '<textarea class="form-control" name="' . $name . '"';

        foreach ($options as $option => $value) {
            if ($option !== 'id') {
                $html .= ' ' . $option . '="' . $value . '"';
            }
        }

        $html .= '></textarea>';

        $errors = session('errors');

        if ($errors && $errors->has($name)) {
            $error = $errors->first($name);
            $html .= '<span class="error-message">' . $error . '</span>';
        }

        return $html;
    }

    protected function renderSelect($name, $options)
    {
        $html = '<select class="form-control" name="' . $name . '"';

        foreach ($options as $option => $value) {
            if ($option !== 'id' && $option !== 'options') {
                $html .= ' ' . $option . '="' . $value . '"';
            }
        }

        $html .= '>';

        foreach ($options['options'] as $optionValue => $optionLabel) {
            $html .= '<option value="' . $optionValue . '">' . $optionLabel . '</option>';
        }

        $html .= '</select>';

        $errors = session('errors');

        if ($errors && $errors->has($name)) {
            $error = $errors->first($name);
            $html .= '<span class="error-message">' . $error . '</span>';
        }

        return $html;
    }

    protected function renderCheckbox($name, $label, $options)
    {
        $html = '<label><input class="form-control" type="checkbox" name="' . $name . '"';

        foreach ($options as $option => $value) {
            if ($option !== 'id') {
                $html .= ' ' . $option . '="' . $value . '"';
            }
        }

        $html .= '> ' . $label . '</label>';

        $errors = session('errors');

        if ($errors && $errors->has($name)) {
            $error = $errors->first($name);
            $html .= '<span class="error-message">' . $error . '</span>';
        }

        return $html;
    }

    protected function renderRadio($name, $label, $options)
    {
        $html = '<label><input class="form-control" type="radio" name="' . $name . '"';

        foreach ($options as $option => $value) {
            if ($option !== 'id') {
                $html .= ' ' . $option . '="' . $value . '"';
            }
        }

        $html .= '> ' . $label . '</label>';

        $errors = session('errors');

        if ($errors && $errors->has($name)) {
            $error = $errors->first($name);
            $html .= '<span class="error-message">' . $error . '</span>';
        }

        return $html;
    }

    protected function renderSubmitButton($name, $label, $options)
    {
        $html = '<div class="">';
        $html .= '<button type="submit" name="' . $name . '"';

        foreach ($options as $option => $value) {
            if ($option !== 'id' && $option !== 'class') { // Thêm điều kiện loại trừ class
                $html .= ' ' . $option . '="' . $value . '"';
            }
        }

        // Thêm class vào trường submit button
        if (isset($options['class'])) {
            $html .= ' class="' . $options['class'] . '"';
        }

        $html .= '>' . $label . '</button>';

        $html .= '</div>';

        return $html;
    }

    protected function addError($name, $message)
    {
        $this->errors[$name] = $message;
    }

    protected function hasError($name)
    {
        return isset($this->errors[$name]);
    }

    protected function getError($name)
    {
        return $this->errors[$name];
    }

    protected function validateRegex($name, $value, $regex)
    {
        if (!preg_match($regex, $value)) {
            $this->addError($name, $this->getErrorMessage('regex'));
            return false;
        }

        return true;
    }

    protected function getErrorMessage($type)
    {
        switch ($type) {
            case 'regex':
                return 'Invalid format.';
            // code here
        }
    }

}
