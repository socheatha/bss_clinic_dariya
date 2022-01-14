<?php

return [

  'table' => [
    'no' => 'ល.រ',
    'date' => 'កាលបរិច្ឆេទ',
    'name_kh' => 'ឈ្មោះខ្មែរ',
    'name_en' => 'ឈ្មោះអង់គ្លេស',
    'name' => 'ឈ្មោះ',
    'gender' => 'ភេទ',
    'description' => 'បរិយាយ',
    'action' => 'សកម្មភាព',
    'created_by' => 'បង្កើតដោយ',
    'updated_by' => 'កែប្រែដោយ',
		'sort' => 'លំដាប់',
    'phone' => 'លេខទូរស័ព្ទ',
    'email' => 'អ៊ីមែល',
    'address' => 'អាសយដ្ឋាន',
    'status' => 'ស្ថានភាព',
		'vat_tin' => 'អ.ត​.ប',
		'verified' => 'បានសម្រេច',
		'submitted' => 'បានស្នើររួច',
		'resubmit' => 'រងចាំកែប្រែ',

    'patient' => [
	    'age' => 'អាយុ',
    ],

    'medicine' => [
	    'code' => 'កូដ',
	    'usage' => 'ការប្រើប្រាស់',
	    'price' => 'តម្លៃ',
    ],

    'service' => [
	    'price' => 'តម្លៃ',
    ],
    
    'labor_service' => [
	    'category' => 'ប្រភេទ',
	    'default_value' => 'តម្លៃលំនាំដើម',
	    'sub_of' => 'សេវាកម្ម',
	    'unit' => 'ឯកតា',
	    'reference' => 'យោង',
    ],
    
		'echo_default_description' => [
			'slug' => 'Slug',
		],

    'echoes' => [
	    'pt_name' => 'ឈ្មោះអ្នកជំងឺ',
	    'pt_phone' => 'លេខទូរស័ព្ទ',
    ],

    'invoice' => [
	    'inv_number' => 'លេខវិក្កយបត្រ',
	    'pt_name' => 'ឈ្មោះអ្នកជំងឺ',
	    'pt_phone' => 'លេខទូរស័ព្ទ',
	    'sub_total' => 'តម្លៃ',
	    'grand_total' => 'តម្លៃសរុបចុងក្រោយ',
	    'discount' => 'បញ្ចុះតម្លៃ',
	    'status' => 'ការបង់ប្រាក់',
	    'exchange_rate' => 'អត្រាប្ដូរប្រាក់',
    ],

    'labor' => [
	    'labor_number' => 'លេខរៀង',
	    'pt_name' => 'ឈ្មោះអ្នកជំងឺ',
	    'pt_phone' => 'លេខទូរស័ព្ទ',
	    'pt_age' => 'អាយុ',
	    'category' => 'ប្រភេទ',
	    'result' => 'លទ្ធផល',
	    'detail' => 'លម្អិត',
	    'total_patient' => 'អ្នកជំងឺសរុប',
	    'create_label_1' => 'ស្តង់ដា',
	    'create_label_2' => 'BIO CHEMIE',
	    'create_label_3' => 'ទទេ',
    ],

    'prescription' => [
	    'code' => 'លេខវេជ្ជបញ្ជា',
	    'pt_name' => 'ឈ្មោះអ្នកជំងឺ',
	    'pt_phone' => 'លេខទូរស័ព្ទ',
	    'sub_total' => 'តម្លៃ',
	    'grand_total' => 'តម្លៃសរុបចុងក្រោយ',
	    'discount' => 'បញ្ចុះតម្លៃ',
	    'status' => 'ការបង់ប្រាក់',
    ],

    'user' => [
	    'first_name' => 'គោត្តនាម',
	    'last_name' => 'នាម',
	    'phone' => 'លេខទូរស័ព្ទ',
	    'gender' => 'ភេទ',
	    'position' => 'មុខងារ',
	    'role' => 'តួនាទី',
	    'email' => 'អ៊ីមែល',
	    'password' => 'ពាក្យសម្ងាត់',
      'confirm_password' => 'ផ្ទៀងផ្ទាត់ពាក្យសម្ងាត់',
      
      'permission' => 'សិទ្ធិប្រើប្រាស់',
      'edit' => 'ការកែប្រែ',
      'image' => 'រូបភាព',
    ],
    
    'province' => [
	    'districts' => 'ចំនួនស្រុក',
    ],
    
    'district' => [
	    'code' => 'លេខកូដតំបន់',
	    'province' => 'ស្ថិតក្នុង',
    ],
    
    'role' => [
      'permission' => 'សិទ្ធិប្រើប្រាស់',
      'user' => 'អ្នកប្រើប្រាស់',
      'permission' => 'ចំនួនសិទ្ធិ',
	],

	'permission' => [
		'role' => 'ចំនួនតួនាទី',
	],
	
	'selection' => [
		'age_type_1' => 'ឆ្នាំ',
	    'age_type_2' => 'ខែ',
	]
  ],

];
