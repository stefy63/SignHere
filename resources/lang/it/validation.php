<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'Il campo :attribute must be accepted.',
    'active_url'           => 'Il campo :attribute is not a valid URL.',
    'after'                => 'Il campo :attribute must be a date after :date.',
    'after_or_equal'       => 'Il campo :attribute must be a date after or equal to :date.',
    'alpha'                => 'Il campo :attribute may only contain letters.',
    'alpha_dash'           => 'Il campo :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'Il campo :attribute may only contain letters and numbers.',
    'array'                => 'Il campo :attribute deve essere una array.',
    'before'               => 'Il campo :attribute must be a date before :date.',
    'before_or_equal'      => 'Il campo :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'Il campo :attribute deve essere compreso fra :min e :max.',
        'file'    => 'Il campo :attribute deve essere compreso fra :min e :max kilobytes.',
        'string'  => 'Il campo :attribute deve essere compreso fra :min e :max caratteri.',
        'array'   => 'Il campo :attribute deve essere compreso fra :min e :max elementi.',
    ],
    'boolean'              => 'Il campo :attribute field must be true or false.',
    'confirmed'            => 'Il campo :attribute confirmation does not match.',
    'date'                 => 'Il campo :attribute is not a valid date.',
    'date_format'          => 'Il campo :attribute deve avere il formato :format.',
    'different'            => 'Il campo :attribute e :other devono essere diversi.',
    'digits'               => 'Il campo :attribute deve essere di :digits caratteri.',
    'digits_between'       => 'Il campo :attribute must be between :min and :max digits.',
    'dimensions'           => 'Il campo :attribute has invalid image dimensions.',
    'distinct'             => 'Il campo :attribute field has a duplicate value.',
    'email'                => 'Il campo :attribute deve essere una mail valida.',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'Il campo :attribute deve essere un file valido.',
    'filled'               => 'Il campo :attribute field must have a value.',
    'image'                => 'Il campo :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'Il campo :attribute field does not exist in :other.',
    'integer'              => 'Il campo :attribute deve essere un intero.',
    'ip'                   => 'Il campo :attribute must be a valid IP address.',
    'json'                 => 'Il campo :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'Il campo :attribute may not be greater than :max.',
        'file'    => 'Il campo :attribute may not be greater than :max kilobytes.',
        'string'  => 'Il campo :attribute may not be greater than :max characters.',
        'array'   => 'Il campo :attribute may not have more than :max items.',
    ],
    'mimes'                => 'Il campo :attribute deve essere un file di type: :values.',
    'mimetypes'            => 'Il campo :attribute deve essere un file di type: :values.',
    'min'                  => [
        'numeric' => 'Il campo :attribute must be at least :min.',
        'file'    => 'Il campo :attribute must be at least :min kilobytes.',
        'string'  => 'Il campo :attribute must be at least :min characters.',
        'array'   => 'Il campo :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'Il campo :attribute deve essere un numero.',
    'present'              => 'Il campo :attribute field must be present.',
    'regex'                => 'Il campo :attribute non ha un formato valido.',
    'required'             => 'Il campo :attribute è obbligatorio.',
    'required_if'          => 'Il campo :attribute field is required when :other is :value.',
    'required_unless'      => 'Il campo :attribute field is required unless :other is in :values.',
    'required_with'        => 'Il campo :attribute field is required when :values is present.',
    'required_with_all'    => 'Il campo :attribute field is required when :values is present.',
    'required_without'     => 'Il campo :attribute field is required when :values is not present.',
    'required_without_all' => 'Il campo :attribute field is required when none of :values are present.',
    'same'                 => 'Il campo :attribute e :other NON sono uguali.',
    'size'                 => [
        'numeric' => 'Il campo :attribute must be :size.',
        'file'    => 'Il campo :attribute must be :size kilobytes.',
        'string'  => 'Il campo :attribute must be :size characters.',
        'array'   => 'Il campo :attribute must contain :size items.',
    ],
    'string'               => 'Il campo :attribute must be a string.',
    'timezone'             => 'Il campo :attribute must be a valid zone.',
    'unique'               => 'Il campo :attribute è già presente nel DataBase.',
    'uploaded'             => 'Il campo :attribute failed to upload.',
    'url'                  => 'Il campo :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'brand_id' => [
            'integer' => 'Il campo :attribute deve essere selezionato',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'sign_format' => 'Il formato di una riga in :attribute è errato. eg: pg|x|y|{M-O}|se O stringa',
    'question_format' => 'Il formato di una riga in :attribute è errato. eg: pg|xYes|yYes|xNo|yNo|testo',
    'phone' => 'Il numero di telefono non è valido!',

];
