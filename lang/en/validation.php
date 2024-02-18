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

    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'The :attribute must be a valid email address.',
    'ends_with' => 'The :attribute must end with one of the following: :values',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
        'string' => 'The :attribute may not be greater than :max characters.',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'The :attribute field is required.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute format is invalid.',
    'uuid' => 'The :attribute must be a valid UUID.',

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
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        "usage_amount"=>"usage times",
        "product_id" =>"product name",
        "points" =>"Points",
        "quantity"=>"Quantity",
        "protein"=>"Protein",
        "fat"=>"Fat",
        "carb"=>"Carb",
        "calories"=>"Calories",
        "category_id"=>"Category",
        'name_ar'        => 'Name in arabic',
        'name_en'        => 'Name in english',
        'title_ar'        => 'title in arabic',
        'title_en'        => 'title in english',
        'text_ar'         => 'notification in arabic',
        'text_en'         => 'notification in english',
        'lang'            => 'language',
        'method_type'=>'method type',
        'session_id' => 'session',
        'rate' => 'rate',
        'file' => 'file',
        'message' => 'message',
        'reading_type_id' => 'reading type id',
        'image' => 'image',
        'periods.*.*.from_time'=>'From Time',
        'periods.*.*.to_time'=>'To Time',
        'reading_types'=>'reading types',
        'reading_level_id'=>'reading level',
        'permissions'=>'permissions',

        'user_type'=>'user type',
        'teacher_id'=>'teacher',
        "rates.*"=>'Rates',
        "ar.name"=>"Name Ar",
        "en.name"=>"Name En",
        "slot_id"=>"appointment",

        "en.question"=>"Qestion In English",
        "ar.question"=>"Qestion In Arabic",
        "en.answer"=>"Answer In English",
        "ar.answer"=>"Answer In Arabic",
        "en.about_app"=>"About In English",
        "ar.about_app"=>"About In Arabic",
        "ar.privacy_policy"=>"Privacy In Arabic",
        "en.privacy_policy"=>"Privacy In English",
        "en.terms_of_use"=>"Terms In English",
        "ar.terms_of_use"=>"Terms In Arabic",
        "city"=>'country',
        "job"=>"job",
        "roles.*"=>"role",
        "department_id"=>"department",
        "unit_id"=>"unit",
        "job_title_id"=>"job title",
        'vendor_category_id' => 'tendering types',
        "home_number"=>"Land Line number",
        "attachments.*.file_name"=>"File Name",
        "attachments.*.file_expire_date"=>"File Expire Date",
        "attachments.*.file"=>"File",
        'permission_ids' => 'Permissions',
        'company_id' => 'Company',
        'vendor_category_ids' => 'tendering types',
        'old_password' => 'old password',
        'images.*'=>'images',
        'contact_roles.*'=> 'role',
        "address_ar"=>"address in arabic",
        "address_en"=>"address in english",
         "whatsapp_number"=> "whatsapp number",
        'qut_name' => 'Quotaytion name',
        'qut_attachements.*' => 'Attachements',
        'items' => 'Items',
        'items.*.available_quantity' => 'Offered quantity',
        'items.*.price' => 'Price',
        'items.*.total_price' => 'Total price',
        'items.*.delivery_date' => 'Delivery date',
        'items.*.status' => 'Status',
        'items.*.notes' => 'Notes',
        'items.*.attachments' => 'Attachements',
        'items.*.attachments.*' => 'Attachements size',
        'items.*.alternatives.*.item_id' => 'Alternative item',
        'items.*.alternatives.*.available_quantity' => 'Quantity',
        'items.*.alternatives.*.name' => 'Name',
        'items.*.alternatives.*.price' => 'Price',
        'items.*.alternatives.*.delivery_date' => 'Delivery date',
        'items.*.alternatives.*.notes' => 'Notes',
        'items.*.requested_quantity' => 'Requested quantity',
        'items.*.item_id'=>"Item",
        'items.*.quantity'=>"Quantity",
        'items.*.std_value' =>'STD value',
        "days.*.time_from" => "Time From",
        "days.*.time_to" => "Time To",
        "days.*.check" => "day",
        "quotation_id" => "Quotation",
        "po_id" => "Purchase order ID",
        'delivery_request_items' => 'Delivery request items',
        'delivery_request_items.*.item_id' => 'Item',
        'delivery_request_items.*.quantity' => 'Quantity',
        'delivery_request_items.*.notes' => 'Notes',
        'delivery_request_items.*.remainingQuantity' => 'Remainign quantity',
        "subscriptions.*.countries.*.country_id" => "country",
        "subscriptions.*.subscription_id"=>"subscription program",
        'currency_id' => 'currency',
        'contact_id' => 'contact',
        "lat"=> "latitude",
        "lng"=> "longitude",
        "role_id"=>"role",
        "branch_id"=>"branch",
        "client_id" => "client",
        "unit_type_id" => "Unit",
        "subscription_type_id"=>"subscription type",
        "groups"=>"products group",
        "tips_ar"=>"tips in arabic",
        "tips_en"=>"tips in english",
        "rank_number"=>"rank number",
        'std_value' =>'STD value',
        "program_code_id"=>"Program ID",
        "supplemental_group_id"=>"supplemental group",
        'work_start_hour' => 'work start hour',
        'work_end_hour' => 'work end hour',
        'slot_repeat' => 'slot repeat',
        'work_duration' => 'work duration',
        'work_break' => 'work break',
        "calorieTargetMethod"=>"Calorie Target Method",
        "days"=>"days",
        "days.*.meals"=>"meals",
        "days.*.meals.*.items"=>"items",
        "send_method" =>" sending method",
        "client_ids" =>"clients",
        "hours_duration"=> "hours",
        "minutes_duration"=> "minutes",
        "seconds_duration"=> "seconds",
        "target_calorie"=> "Target Burned Calorie Per Exercise",
        "muscle_side"=> "muscle side",
        "muscle_name"=> "muscle name",
        "exercise_type_id"=> "exercise type",
        "back_side"=> "back",
        "front_side"=> "front",
        "target_calories"=>"daily target calories",
        "voucher_name"=> "voucher name",
        "voucher_amount"=>"voucher amount",
        "voucher_local_amount"=>"voucher local amount",
        "voucher_number"=>"voucher number",
        "reference_number"=> "reference number",
        "per_user_usage_amount"=> "usage number per user",
        "general_usage_amount"=> "general usage number",
        "blog_category_id"=>"blog category",
        "attachments.*"=>"attachments",
        "schedule_status"=> "schedule notification",
        "redirect_type"=> "redirect pages",
        "chat_limit"=> "chat limit",
    ],

    'values' => [
        'birth_date' => [
            'today' => 'today'
        ]
    ]

];