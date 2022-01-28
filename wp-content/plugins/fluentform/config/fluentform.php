<?php

return array(
	'db_version' => '1.0',
	
	'db_tables' => array(
		'forms' => 'fluentform_forms',
		'form_meta' => 'fluentform_form_meta',
		'submissions' => 'fluentform_submissions',
		'submission_meta' => 'fluentform_submission_meta',
		'transactions' => 'fluentform_transactions'
	),

	'components' => array(
        'general' => array(
        	'input_text' => array(
	            'index' => 2,
	            'element' => 'input_text'
	        ),
	        'input_textarea' => array(
	            'index' => 1,
	            'element' => 'input_textarea'
	        )
        ),
        'advanced' => array(
        	'advanced_input_text' => array(
	            'index' => 2,
	            'element' => 'input_text'
	        ),
	        'advanced_input_textarea' => array(
	            'index' => 1,
	            'element' => 'input_textarea'
	        )
        ),
    ),
);
