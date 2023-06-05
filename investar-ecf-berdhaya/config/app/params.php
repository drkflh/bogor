<?php
return [
    'logicalOperator'=>[
        [ 'text'=>'AND', 'value'=>'AND'],
        [ 'text'=>'OR', 'value'=>'OR'],
    ],
    'comparatorOperator'=>[
        [ 'text'=>'Equal', 'value'=>'EQ'],
        [ 'text'=>'Not Equal', 'value'=>'NE'],
        [ 'text'=>'Contains', 'value'=>'CONTAINS'],
        [ 'text'=>'Exact Contains', 'value'=>'EXACTCONTAINS'],
        [ 'text'=>'Less Than', 'value'=>'LT'],
        [ 'text'=>'Less Than or Equal', 'value'=>'LTE'],
        [ 'text'=>'Greater Than', 'value'=>'GT'],
        [ 'text'=>'Greater Than or Equal', 'value'=>'GTE']
    ],
    'equalityOperator'=>[
        [ 'text'=>'Equal', 'value'=>'EQ'],
        [ 'text'=>'Not Equal', 'value'=>'NE'],
    ],
    'textEqualityOperator'=>[
        [ 'text'=>'Equal', 'value'=>'EQ'],
        [ 'text'=>'Not Equal', 'value'=>'NE'],
        [ 'text'=>'Contains', 'value'=>'CONTAINS'],
        [ 'text'=>'Starts With', 'value'=>'START'],
        [ 'text'=>'Ends With', 'value'=>'END'],
    ],
    'textMatchDirection'=>[
        [ 'text'=>'Subject <- User Field', 'value'=>'SUBJECT_USERFIELD'],
        [ 'text'=>'User Field <- Subject', 'value'=>'USERFIELD_SUBJECT'],
    ],
    'booleanOperator'=>[
        [ 'text'=>'Yes', 'value'=>'YES'],
        [ 'text'=>'No', 'value'=>'NO'],
    ],
    'timeEventOperator'=>[
        [ 'text'=>'Before', 'value'=>'Before'],
        [ 'text'=>'After', 'value'=>'After'],
        [ 'text'=>'From', 'value'=>'From'],
        [ 'text'=>'Until', 'value'=>'Until'],
    ],
    'notationOperator'=>[
        [ 'text'=>'EQ', 'value'=>'='],
        [ 'text'=>'NE', 'value'=>'!='],
        [ 'text'=>'LT', 'value'=>'<'],
        [ 'text'=>'LTE', 'value'=>'<='],
        [ 'text'=>'GT', 'value'=>'>'],
        [ 'text'=>'GTE', 'value'=>'>='],
        [ 'text'=>'LIKE', 'value'=>'LIKE'],
        [ 'text'=>'START', 'value'=>'LIKE_RIGHT'],
        [ 'text'=>'END', 'value'=>'LIKE_LEFT'],
    ],
    'varType'=>[
        [ 'text'=>'STRING', 'value'=>'string'],
        [ 'text'=>'INT', 'value'=>'integer'],
        [ 'text'=>'DOUBLE', 'value'=>'double'],
        [ 'text'=>'FLOAT', 'value'=>'float']
    ],
    'termType'=>[
        [ 'text'=>'NOMINAL', 'value'=>'nominal'],
        [ 'text'=>'PERCENTAGE', 'value'=>'percentage']
    ],

];
