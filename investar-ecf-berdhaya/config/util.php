<?php

return [
    'user_field'=>'email',
    'password_field'=>'password',
    'api_login_field'=>'login',
    'api_password_field'=>'pwd',
    'user_collection'=>'users',
    'invalid_chars'=>array('%','&','|',' ','"',':',';','\'','\\','?','#','(',')','/'),
    'api_page_size'=>50,

    'languages'=> [
        'en'=>'English',
        'id'=>'Indonesia',
    ],

    'mobile_countries'=> [
        [ 'text'=>'+62', 'value'=>'+62'],
        [ 'text'=>'+61', 'value'=>'+61'],
    ],

    'auth_roles'=> [
        [ 'text'=>'Penerbit', 'value'=>'penerbit'],
        [ 'text'=>'Pemodal', 'value'=>'pemodal'],
    ],

    'role_layouts'=> [
        [ 'text'=>'Noble UI', 'value'=>'layouts.nobleui'],
        [ 'text'=>'Noble UI Horizontal', 'value'=>'layouts.nobleui_h'],
    ],

    'timezones'=> [
        'Asia/Jakarta'=>'Asia/Jakarta (WIB)',
        'Asia/Pontianak'=>'Asia/Pontianak (WITA)',
        'Asia/Makassar'=>'Asia/Makassar (WIT)',
        'UTC'=>'UTC',
    ],

    'approval_status_list'=>[
        [ 'text'=>'Pending', 'value'=>'PENDING'],
        [ 'text'=>'Approved', 'value'=>'APPROVED'],
        [ 'text'=>'Released', 'value'=>'RELEASED'],
        [ 'text'=>'Rejected', 'value'=>'REJECTED'],
        [ 'text'=>'Canceled', 'value'=>'CANCELED'],
    ],

    'task_progress_status_list'=>[
        [ 'value'=> 'OPEN', 'text'=> 'Open' ],
        [ 'value'=> 'ON_PROGRESS', 'text'=> 'On Progress'],
        [ 'value'=> 'CLOSED', 'text'=> 'Closed'],
        [ 'value'=> 'READY_TO_TEST', 'text'=> 'Ready to Test'],
        [ 'value'=> 'ON_TESTING', 'text'=> 'On Testing']
    ],

    'project_progress_status_list'=>[
        [ 'value'=> 'NEW', 'text'=> 'New' ],
        [ 'value'=> 'ON_PROGRESS', 'text'=> 'On Progress'],
        [ 'value'=> 'SUSPENDED', 'text'=> 'Suspended'],
        [ 'value'=> 'CLOSED', 'text'=> 'Closed']
    ],

    'developer_progress_status_list'=>[
        [ 'value'=> 'OPEN', 'text'=> 'Open' ],
        [ 'value'=> 'ON_PROGRESS', 'text'=> 'On Progress'],
        [ 'value'=> 'READY_TO_TEST', 'text'=> 'Ready to Test']
    ],

    'qa_progress_status_list'=>[
        [ 'value'=> 'OPEN', 'text'=> 'Open' ],
        [ 'value'=> 'ON_TEST', 'text'=> 'On Test'],
        [ 'value'=> 'CLOSED', 'text'=> 'Closed'],
        [ 'value'=> 'RE_OPENED', 'text'=> 'Re-Opened'],
    ],

    'pic_progress_status_list'=>[
        [ 'value'=> 'OPEN', 'text'=> 'Open' ],
        [ 'value'=> 'ON_PROGRESS', 'text'=> 'On Progress'],
        [ 'value'=> 'READY_TO_TEST', 'text'=> 'Ready to Test']
    ],

    'employee_status'=>[
        [ 'value'=> 'not-applicable', 'text'=> 'Not Applicable' ],
        [ 'value'=> 'fulltime', 'text'=> 'Fulltime Staff' ],
        [ 'value'=> 'temporary', 'text'=> 'Temporary Staff'],
        [ 'value'=> 'probational', 'text'=> 'Probational'],
        [ 'value'=> 'internship', 'text'=> 'Internship'],
    ],

    'download_qty'=>10000,

    'sys_fields'=>['_id','handle','deleted'],

    'sys_datefields'=>['datepicker','date','datetime'],

    'editor_config'=>"[
        'heading', '|',
        'undo', 'redo','|',
        'fontfamily', 'fontsize', '|',
        'alignment', '|',
        'fontColor', 'fontBackgroundColor', '|',
        'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
        'outdent', 'indent', '|',
        'bulletedList', 'numberedList', 'todoList', '|',
        'insertTable'
    ]",

    'template_exclude'=>[
        '_id',
        'ajax',
        'handle',
        'deleted',
        'createdAt',
        'updatedAt',
        'updated_at',
        'created_at',
        'ownerId',
        'ownerName',
        'filler'
    ],

    'preset_type'=>[
        '_id'=>'object',
        'ajax'=>'boolean',
        'handle'=>'string',
        'deleted'=>'string',
        'createdAt'=>'datetime',
        'updatedAt'=>'datetime',
        'updated_at'=>'datetime',
        'created_at'=>'datetime',
        'ownerId'=>'string',
        'ownerName'=>'string',
        'filler'=>'string'
    ],

    'field_structure'=>[
        'label' => ['field'=>'label', 'default'=>''],
        'name' => ['field'=>'name', 'default'=>''],
        'show' => ['field'=>'show', 'default'=>'false'],
        'sort' => ['field'=>'sort', 'default'=>'false'],
        'uniqueId' => ['field'=>'uniqueId', 'default'=>'false'],
        'row_text_alignment' => ['field'=>'row_text_alignment', 'default'=>'text-left'],
        'datatype' => ['field'=>'datatype', 'default'=>'text'],
        'datadefault' => ['field'=>'datadefault', 'default'=>''],
        'search_visible' => ['field'=>'search_visible', 'default'=>'false'],
        'filter_visible' => ['field'=>'filter_visible', 'default'=>'false'],
        'filter_type' => ['field'=>'filter_type', 'default'=>''],
        'filter_placeholder' => ['field'=>'filter_placeholder', 'default'=>''],

        'form_create' => ['field'=>'form_create', 'default'=>'false'],
        'form_edit' => ['field'=>'form_edit', 'default'=>'false'],
        'form_type' => ['field'=>'form_type', 'default'=>'text'],
        'form_default' => ['field'=>'form_default', 'default'=>''],
        'form_model' => ['field'=>'form_model', 'default'=>''],
        'form_row' => ['field'=>'row', 'default'=>1],
        'form_col' => ['field'=>'col', 'default'=>1],
        'form_options' => ['field'=>'options', 'default'=>'[ { text: "Select", value: "Select" } ]'],
        'form_attr' => ['field'=>'attr', 'default'=>'{ class: "form-data" }' ],

        'vue_visible' => ['field'=>'vue_visible', 'default'=>'false'],
        'vue_type' => ['field'=>'vue_type', 'default'=>'text'],
        'vue_default' => ['field'=>'vue_default', 'default'=>''],

        'view_visible' => ['field'=>'view_visible', 'default'=>'false'],
        'view_type' => ['field'=>'view_type', 'default'=>'text'],
        'view_default' => ['field'=>'view_default', 'default'=>''],

        'api_visible' => ['field'=>'api_visible', 'default'=>'false'],
        'api_type' => ['field'=>'api_type', 'default'=>'text'],
        'api_default' => ['field'=>'api_default', 'default'=>'na'],
    ],

    'api_field_structure'=>[
        'name' => ['field'=>'name', 'type'=>'string' ,'default'=>''],
        'type' => ['field'=>'type', 'type'=>'string' ,'default'=>'string', 'case'=>'lower'],
        'default' => ['field'=>'default', 'type'=>'string' ,'default'=>''],
        'nullable' => ['field'=>'nullable', 'type'=>'boolean' ,'default'=>true ],
        'api_show' => ['field'=>'api_create', 'type'=>'boolean' ,'default'=>true, 'case'=>'lower'],
        'api_create' => ['field'=>'api_create', 'type'=>'boolean' ,'default'=>true, 'case'=>'lower'],
        'api_edit' => ['field'=>'api_edit', 'type'=>'boolean' ,'default'=>true, 'case'=>'lower'],
        'api_view' => ['field'=>'api_view', 'type'=>'boolean' ,'default'=>true, 'case'=>'lower'],
        'api_type' => ['field'=>'api_type', 'type'=>'string' ,'default'=>'string', 'case'=>'lower'],
        'api_default' => ['field'=>'api_default', 'type'=>'string' ,'default'=>'', 'case'=>'lower'],
        'api_validator' => ['field'=>'api_validator', 'type'=>'string' ,'default'=>'', 'case'=>'lower'],
        'api_transform' => ['field'=>'api_transform', 'type'=>'boolean' ,'default'=>false, 'case'=>'lower'],
        'api_attr' => ['field'=>'attr', 'type'=>'object' ,'default'=>'{ class: "form-data" }' ],
        'doc' => ['field'=>'attr', 'type'=>'object' ,'default'=>'{ class: "form-data" }' ],

        'form_label' => ['field'=>'form_label', 'type'=>'string' ,'default'=>'', 'case'=>'normal'],
        'form_name' => ['field'=>'form_name', 'type'=>'string' ,'default'=>'', 'case'=>'normal'],
        'form_create' => ['field'=>'form_create', 'type'=>'boolean' ,'default'=>true, 'case'=>'lower'],
        'form_edit' => ['field'=>'form_edit', 'type'=>'boolean' ,'default'=>true, 'case'=>'lower'],
        'form_type' => ['field'=>'form_type', 'type'=>'string' ,'default'=>'text', 'case'=>'lower'],
        'form_model' => ['field'=>'form_model', 'type'=>'string' ,'default'=>'', 'case'=>'normal'],
        'form_default' => ['field'=>'form_default', 'type'=>'string' ,'default'=>'', 'case'=>'lower'],
        'form_validator' => ['field'=>'form_validator', 'type'=>'string' ,'default'=>'required', 'case'=>'lower'],
        'form_param' => ['field'=>'form_param', 'type'=>'object' ,'default'=>null, 'case'=>'normal'],
        'form_attr' => ['field'=>'form_attr', 'type'=>'object' ,'default'=>null, 'case'=>'lower'],

        'table_label' => ['field'=>'table_label', 'type'=>'string' ,'default'=>'', 'case'=>'normal'],
        'table_name' => ['field'=>'table_name', 'type'=>'string' ,'default'=>'', 'case'=>'normal'],
        'table_show' => ['field'=>'table_show', 'type'=>'boolean' ,'default'=>true, 'case'=>'lower'],
        'table_search' => ['field'=>'table_search', 'type'=>'boolean' ,'default'=>false, 'case'=>'lower'],
        'table_sort' => ['field'=>'table_sort', 'type'=>'boolean' ,'default'=>false, 'case'=>'lower'],
        'table_datatype' => ['field'=>'table_datatype', 'type'=>'string' ,'default'=>'text', 'case'=>'lower'],

        'table_validator' => ['field'=>'table_validator', 'type'=>'string' ,'default'=>'', 'case'=>'lower'],
        'table_param' => ['field'=>'table_param', 'type'=>'string' ,'default'=>'', 'case'=>'normal'],
        'table_attr' => ['field'=>'table_attr', 'type'=>'string' ,'default'=>'', 'case'=>'lower'],

        'view_label' => ['field'=>'view_label', 'type'=>'string' ,'default'=>'', 'case'=>'normal'],
        'view_name' => ['field'=>'view_name', 'type'=>'string' ,'default'=>'', 'case'=>'normal'],
        'view_visible' => ['field'=>'view_visible', 'type'=>'boolean' ,'default'=>true, 'case'=>'lower'],
        'view_type' => ['field'=>'view_type', 'type'=>'string' ,'default'=>'text', 'case'=>'normal'],
        'view_model' => ['field'=>'view_model', 'type'=>'string' ,'default'=>'', 'case'=>'normal'],

        'vue_model' => ['field'=>'vue_model', 'type'=>'string' ,'default'=>'', 'case'=>'normal'],
        'vue_visible' => ['field'=>'vue_visible', 'type'=>'boolean' ,'default'=>true, 'case'=>'lower'],
        'vue_type' => ['field'=>'vue_type', 'type'=>'string' ,'default'=>'string', 'case'=>'normal'],
        'vue_default' => ['field'=>'vue_default', 'type'=>'string' ,'default'=>'', 'case'=>'normal'],

    ],

    'layout'=>[
        ['row'=>[
                ['col'=>[
                        ['field'=> 'originAddress' ],
                    ]
                ],
                ['col'=>[
                        ['field'=> 'destAddress' ],
                    ]
                ]
            ]
        ],
        ['row'=>[
                ['col'=>[
                        ['field'=> 'vehicleIdentifier' ],
                        ['field'=> 'assignedDriverName'],
                        ['field'=> 'pickupAddress'],
                        ['row'=>[
                                ['col'=>[
                                        ['field'=> 'etd'],
                                    ]
                                ],
                                ['col'=>[
                                        ['field'=> 'eta'],
                                    ]
                                ],
                                ['col'=>[
                                        ['field'=> 'duration'],
                                    ]
                                ],
                                ['col'=>[
                                        ['field'=> 'capacity'],
                                    ]
                                ]
                            ]
                        ],
                    ]
                ],
                ['col'=>[
                        ['row'=>[
                            ['col'=>[
                                ['field'=> 'feeCurrency'],
                            ]
                            ],
                            ['col'=>[
                                ['field'=> 'tripFare'],
                            ]
                            ],
                            ['col'=>[
                                ['field'=> 'handlingFee'],
                            ]
                            ],
                            ['col'=>[
                                ['field'=> 'surchargeFee'],
                            ]
                            ]
                        ]
                        ],
                        ['field'=> 'assignedDriverName'],
                    ]
                ]
            ]
        ]
    ],
];
