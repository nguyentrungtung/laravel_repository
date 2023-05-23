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

    public function addField($type, $name, $label, $options = [])
    {
        if ($type === 'submit') {
            $this->addSubmitButton($name, $label, $options);
        } else {
//            $this->fields[] = compact('type', 'name', 'label', 'options');
//            if (isset($options['rules'])) {
//                $this->rules[$name] = $options['rules'];
//            }

            $field = compact('type', 'name', 'label', 'options');
            if (isset($options['rules'])) {
                $this->rules[$name] = $options['rules'];
            }

            if ($type === 'radio' && isset($options['choices'])) {
                $field['options']['choices'] = $options['choices'];
                $field['options']['id'] = isset($options['id']) ? $options['id'] : $name;
                $field['options']['value'] = isset($options['value']) ? $options['value'] : '';
                $field['options']['label_position'] = isset($options['label_position']) ? $options['label_position'] : 'before';
            }

            $this->fields[] = $field;
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

//        $attributes = '';
//        if (isset($options['class'])) {
//            $attributes .= ' class="' . $options['class'] . '"';
//        }
//        if (isset($options['id'])) {
//            $attributes .= ' id="' . $options['id'] . '"';
//        }


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
        $html = '<input type="email" name="' . $name . '"';

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

        $errors = session('errors');

        if ($errors && $errors->has($name)) {
            $error = $errors->first($name);
            $html .= '<span class="error-message">' . $error . '</span>';
        }

        return $html;
    }

    protected function renderPasswordInput($name, $options)
    {
        $html = '<input type="password" name="' . $name . '"';

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

        $errors = session('errors');

        if ($errors && $errors->has($name)) {
            $error = $errors->first($name);
            $html .= '<span class="error-message">' . $error . '</span>';
        }

        return $html;
    }

    protected function renderTextarea($name, $options)
    {
        $html = '<textarea name="' . $name . '"';

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
        $multiple = !empty($options['multiple']) ? 'multiple' : '';

//        $html = '<select class="form-control select2"' . $multiple ? multiple="multiple" . '"  name="' . $name . '"';
//        $html = '<select class="form-control select2"' . ($multiple ? ' multiple="multiple"' : '') . ' name="' . $name . '"';
        $html = '<select class="form-control select2"' . ($multiple ? ' multiple="multiple" data-tags="true"' : '') . ' name="' . $name . '"';
        foreach ($options as $option => $value) {
            if ($option !== 'id' && $option !== 'options') {
                $html .= ' ' . $option . '="' . $value . '"';
            }
        }

        $html .= '>';

        $selectOptions = $options['options'];

        if (is_array($selectOptions) && count($selectOptions) > 0) {
            foreach ($selectOptions as $optionValue => $optionLabel) {
                $html .= '<option value="' . $optionValue . '">' . $optionLabel . '</option>';
            }
        }

        $html .= '</select>';

        $errors = session('errors');

        if ($errors && $errors->has($name)) {
            $error = $errors->first($name);
            $html .= '<span class="error-message">' . $error . '</span>';
        }

        return $html;
    }

//    protected function renderCheckbox($name, $label, $options)
//    {
//        $radioClass  = !empty($options['class']) ? 'class="' . $options["class"] . '"' : '';
//        $html = '<label><input class="form-control" type="checkbox" name="' . $name . '"';
//
//        foreach ($options as $option => $value) {
//            if ($option !== 'id') {
//                $html .= ' ' . $option . '="' . $value . '"';
//            }
//        }
//
//        $html .= '> ' . $label . '</label>';
//
//        $errors = session('errors');
//
//        if ($errors && $errors->has($name)) {
//            $error = $errors->first($name);
//            $html .= '<span class="error-message">' . $error . '</span>';
//        }
//
//        return $html;
//    }

    protected function renderCheckbox($name, $label, $options)
    {
        $html = '';

        foreach ($options['choices'] as $value => $choiceLabel) {
            $radioId = $options['id'] . '_' . $value;
            $checked = ($value == $options['value']) ? 'checked' : '';
            $radioClass  = !empty($options['class']) ? 'class="' . $options["class"] . '"' : '';

            $html .= '<label><input type="checkbox"'. $radioClass . ' name="' . $name . '" id="' . $radioId . '" value="' . $value . '" ' . $checked . '>';

            if (isset($options['label_position']) && $options['label_position'] === 'after') {
                $html .= $choiceLabel . '</label> ';
            } else {
                $html .= '</label> ' . $choiceLabel . '&nbsp &nbsp';
            }
        }

        $errors = session('errors');

        if ($errors && $errors->has($name)) {
            $error = $errors->first($name);
            $html .= '<span class="error-message">' . $error . '</span>';
        }

        return $html;
    }

    protected function renderRadio($name, $label, $options)
    {
        $html = '';

        foreach ($options['choices'] as $value => $choiceLabel) {
            $radioId = $options['id'] . '_' . $value;
            $checked = ($value == $options['value']) ? 'checked' : '';
            $radioClass  = !empty($options['class']) ? 'class="' . $options["class"] . '"' : '';

            $html .= '<label><input type="radio"'. $radioClass . ' name="' . $name . '" id="' . $radioId . '" value="' . $value . '" ' . $checked . '>';

            if (isset($options['label_position']) && $options['label_position'] === 'after') {
                $html .= $choiceLabel . '</label> ';
            } else {
                $html .= '</label> ' . $choiceLabel . '&nbsp &nbsp';
            }
        }

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
