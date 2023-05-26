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

    public function addFileField($name, $label, $options = [], $uploadedFiles = [])
    {
        $field = [
            'type' => 'file',
            'name' => $name,
            'label' => $label,
            'options' => $options,
            'uploadedFiles' => $uploadedFiles,
        ];

        $this->fields[] = $field;
    }

    public function addField($type, $name, $label, $options = [])
    {
        if ($type === 'submit') {
            $this->addSubmitButton($name, $label, $options);
        } else {

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

        $requiredLabel = isset($field['options']['labelRequired']) ? ' <span style="color:red"> (*) </span> ' : '';

        $appendLabelColumn = "col-sm-2";

        $html = '<div class="box-body row">';

        if ($type !== 'submit') {
            if (isset($options['id'])) {
                $html .= '<label class="col-form-label ' . $appendLabelColumn . ' " for="' . $options['id'] . '">' . $label . '&nbsp ' . $requiredLabel . '</label>';
            } else {
                $html .= '<label class="col-form-label ' . $appendLabelColumn . '" for="' . $name . '">' . $label . '&nbsp ' . $requiredLabel . '</label>';
            }
        } else {
            $html .= '<label class="col-form-label ' . $appendLabelColumn . '" for="' . $name . '"></label>';
        }

        $html .= '<div class="col-sm-10">';

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
            case 'custome':
                $html .= $this->renderCustomField($name, $label, $options);
                break;
            // Thêm các loại trường khác tại đây
            case 'file':
                $html .= $this->renderFile($name, $label, $options, $field['uploadedFiles']);
                break;
            case 'switch':
                $html .= $this->renderSwitch($name, $label, $options);
                break;
        }

        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    protected function renderSwitch($name, $label, $options)
    {
        $html = '<label class="switch">';
        $html .= '<input type="checkbox" name="' . $name . '"';

        if (isset($options['class'])) {
            $html .= ' class="' . $options['class'] . '"';
        }

        if (isset($options['id'])) {
            $html .= ' id="' . $options['id'] . '"';
        }

        if (isset($options['placeholder'])) {
            $html .= ' placeholder="' . $options['placeholder'] . '"';
        }

        // Kiểm tra và đặt giá trị checked nếu có giá trị value và value là true hoặc 1
        if (isset($options['value']) && ($options['value'] === true)) {
            $html .= ' checked';
        }

        $html .= '>';
        $html .= '<span class="slider round"></span>';
        $html .= '</label>';

        return $html;
    }

    protected function renderFile($name, $label, $options, $uploadedFiles)
    {

        $html = '<input type="file" name="' . $name . '"';

        if (isset($options['class'])) {
            $html .= ' class="' . $options['class'] . '"';
        }

        if (isset($options['id'])) {
            $html .= ' id="' . $options['id'] . '"';
        }

        $html .= '>';

        // Hiển thị các tệp tin đã tải lên (ảnh hoặc nhiều ảnh)
        if (!empty($uploadedFiles)) {
            foreach ($uploadedFiles as $uploadedFile) {
                // Kiểm tra kiểu tệp tin (ở đây giả sử chỉ hỗ trợ ảnh)
                if (strpos($uploadedFile, '.jpg') !== false || strpos($uploadedFile, '.png') !== false || strpos($uploadedFile, '.jpeg') !== false || strpos($uploadedFile, '.gif') !== false) {
                    $html .= '<img src="' . $uploadedFile . '" alt="Uploaded Image">';
                }
            }
        }

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

        // Kiểm tra nếu có giá trị old, sử dụng nó như giá trị mặc định
        $oldValue = old($name);
        if ($oldValue !== null) {
            $html .= ' value="' . htmlspecialchars($oldValue) . '"';
        }

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

        if (isset($options['placeholder'])) {
            $html .= ' placeholder="' . $options['placeholder'] . '"';
        }

        $html .= '>';

        // Kiểm tra nếu trường có thông báo lỗi
        $errors = session('errors');

        if ($errors && $errors->has($name)) {
            $error = $errors->first($name);
            $html .= '<span class="error-message text-danger">' . $error . '</span>';
        }

        return $html;
    }

    protected function renderEmailInput($name, $options)
    {
        $html = '<input type="email" name="' . $name . '"';

        // Kiểm tra nếu có giá trị old, sử dụng nó như giá trị mặc định
        $oldValue = old($name);
        if ($oldValue !== null) {
            $html .= ' value="' . htmlspecialchars($oldValue) . '"';
        }

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

        if (isset($options['placeholder'])) {
            $html .= ' placeholder="' . $options['placeholder'] . '"';
        }

        $html .= '>';

        $errors = session('errors');

        if ($errors && $errors->has($name)) {
            $error = $errors->first($name);
            $html .= '<span class="error-message text-danger" >' . $error . '</span>';
        }

        return $html;
    }

    protected function renderPasswordInput($name, $options)
    {
        $html = '<input type="password" name="' . $name . '"';

        // Kiểm tra nếu có giá trị old, sử dụng nó như giá trị mặc định
        $oldValue = old($name);
        if ($oldValue !== null) {
            $html .= ' value="' . htmlspecialchars($oldValue) . '"';
        }

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

        if (isset($options['placeholder'])) {
            $html .= ' placeholder="' . $options['placeholder'] . '"';
        }

        $html .= '>';

        $errors = session('errors');

        if ($errors && $errors->has($name)) {
            $error = $errors->first($name);
            $html .= '<span class="error-message text-danger">' . $error . '</span>';
        }

        return $html;
    }

    protected function renderTextarea($name, $options)
    {
        $html = '<textarea name="' . $name . '"';

        foreach ($options as $option => $value) {
            if ($option !== 'id' && $option !== 'rows' && $option !== 'cols') {
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

        // Kiểm tra nếu có thuộc tính rows
        if (isset($options['rows'])) {
            $html .= ' rows="' . $options['rows'] . '"';
        }

        // Kiểm tra nếu có thuộc tính cols
        if (isset($options['cols'])) {
            $html .= ' cols="' . $options['cols'] . '"';
        }

        if (isset($options['placeholder'])) {
            $html .= ' placeholder="' . $options['placeholder'] . '"';
        }

        // Kiểm tra nếu có giá trị old, sử dụng nó như giá trị mặc định
        $oldValue = old($name);
        if ($oldValue !== null) {
            $html .= ' value="' . htmlspecialchars($oldValue) . '"';
        }

        $html .= '></textarea>';

        $errors = session('errors');

        if ($errors && $errors->has($name)) {
            $error = $errors->first($name);
            $html .= '<span class="error-message text-danger">' . $error . '</span>';
        }

        return $html;
    }

//    protected function renderSelect($name, $options)
//    {
//        $multiple = !empty($options['multiple']) ? 'multiple' : '';
//
//        $html = '<select class="form-control select2"' . ($multiple ? ' multiple="multiple" data-tags="true"' : '') . ' name="' . $name . '"';
//        foreach ($options as $option => $value) {
//            if ($option !== 'id' && $option !== 'options') {
//                $html .= ' ' . $option . '="' . $value . '"';
//            }
//        }
//
//        $html .= '>';
//
//        $selectOptions = $options['options'];
//
//        if (is_array($selectOptions) && count($selectOptions) > 0) {
//            foreach ($selectOptions as $optionValue => $optionLabel) {
//                $html .= '<option value="' . $optionValue . '">' . $optionLabel . '</option>';
//            }
//        }
//
//        $html .= '</select>';
//
//        $errors = session('errors');
//
//        if ($errors && $errors->has($name)) {
//            $error = $errors->first($name);
//            $html .= '<span class="error-message text-danger">' . $error . '</span>';
//        }
//
//        return $html;
//    }

    protected function renderSelect($name, $options)
    {
        $html = '<select class="form-control select2" name="' . $name . '"';
        foreach ($options as $option => $value) {
            if ($option !== 'id' && $option !== 'options') {
                $html .= ' ' . $option . '="' . $value . '"';
            }
        }

        $html .= '>';

        $selectOptions = $options['options'];

        $oldValue = !empty(session()->getOldInput($name)) ? session()->getOldInput($name) : '';

        if (is_array($selectOptions) && count($selectOptions) > 0) {
            foreach ($selectOptions as $optionValue => $optionLabel) {
                $selected = '';

                // Check if the current option value matches the old input value

                if ($oldValue == $optionValue) {
                    $selected = 'selected';
                }

                $html .= '<option value="' . $optionValue . '" ' . $selected . '>' . $optionLabel . '</option>';
            }
        }

        $html .= '</select>';

        $errors = session('errors');

        if ($errors && $errors->has($name)) {
            $error = $errors->first($name);
            $html .= '<span class="error-message text-danger">' . $error . '</span>';
        }

        return $html;
    }

    protected function renderCheckbox($name, $label, $options)
    {
        $html = '';
        $selectedValues = is_array($options['value']) ? $options['value'] : [$options['value']];
        $choices = is_array($options['choices']) ? $options['choices'] : [$options['choices']];
        $inputName = is_array($options['value']) ? $name . '[]' : $name;

        // Retrieve the old input value for the field
        $oldValue = !empty(session()->getOldInput($name)) ? session()->getOldInput($name) : '';

        foreach ($choices as $value => $choiceLabel) {
            $radioId = $options['id'] . '_' . $value;
            $checked = in_array($value, $selectedValues) ? 'checked' : '';
            $radioClass = !empty($options['class']) ? 'class="' . $options["class"] . '"' : '';

            // Compare the old value with the current option value
            if (is_array($oldValue)) {
                $checked = in_array($value, $oldValue) ? 'checked' : '';
            }

            $html .= '<label><input type="checkbox"' . $radioClass . ' name="' . $inputName . '" id="' . $radioId . '" value="' . $value . '" ' . $checked . '>';

            if (isset($options['label_position']) && $options['label_position'] === 'after') {
                $html .= $choiceLabel . '</label> ';
            } else {
                $html .= '</label> ' . $choiceLabel . '&nbsp &nbsp';
            }
        }

        $errors = session('errors');

        if ($errors && $errors->has($name)) {
            $error = $errors->first($name);
            $html .= '<span class="error-message text-danger">' . $error . '</span>';
        }

        return $html;
    }

    protected function renderRadio($name, $label, $options)
    {
        $html = '';

        foreach ($options['choices'] as $value => $choiceLabel) {
            $radioId = $options['id'] . '_' . $value;
            $checked = ($value == $options['value']) ? 'checked' : '';
            $radioClass = !empty($options['class']) ? 'class="' . $options["class"] . '"' : '';

            $html .= '<label><input type="radio"' . $radioClass . ' name="' . $name . '" id="' . $radioId . '" value="' . $value . '" ' . $checked . '>';

            if (isset($options['label_position']) && $options['label_position'] === 'after') {
                $html .= $choiceLabel . '</label> ';
            } else {
                $html .= '</label> ' . $choiceLabel . '&nbsp &nbsp';
            }
        }

        $errors = session('errors');

        if ($errors && $errors->has($name)) {
            $error = $errors->first($name);
            $html .= '<span class="error-message text-danger">' . $error . '</span>';
        }

        return $html;
    }

    protected function renderCustomField($name, $label, $options)
    {
        $html = '';
        $html .= '<div class="col-sm-10">';
        $html .= $options['html'];
        $html .= '</div>';

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
