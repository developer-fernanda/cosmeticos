<?php

/**
 * validation_rule_settings
 *
 * Returns an array of countries and codes.
 *
 * @author      WooThemes
 * @category    i18n
 * @package     fluentform/i18n
 * @version     2.5.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$fileTypeOptions = array(
    array(
        'label' => __('Images (jpg, jpeg, gif, png, bmp)', 'fluentform'),
        'value' => 'jpg|jpeg|gif|png|bmp',
    ),
    array(
        'label' => __('Audio (mp3, wav, ogg, oga, wma, mka, m4a, ra, mid, midi)', 'fluentform'),
        'value' => 'mp3|wav|ogg|oga|wma|mka|m4a|ra|mid|midi|mpga',
    ),
    array(
        'label' => __('Video (avi, divx, flv, mov, ogv, mkv, mp4, m4v, divx, mpg, mpeg, mpe)', 'fluentform'),
        'value' => 'avi|divx|flv|mov|ogv|mkv|mp4|m4v|divx|mpg|mpeg|mpe|video/quicktime|qt',
    ),
    array(
        'label' => __('PDF (pdf)', 'fluentform'),
        'value' => 'pdf',
    ),
    array(
        'label' => __('Docs (doc, ppt, pps, xls, mdb, docx, xlsx, pptx, odt, odp, ods, odg, odc, odb, odf, rtf, txt)', 'fluentform'),
        'value' => 'doc|ppt|pps|xls|mdb|docx|xlsx|pptx|odt|odp|ods|odg|odc|odb|odf|rtf|txt',
    ),
    array(
        'label' => __('Zip Archives (zip, gz, gzip, rar, 7z)', 'fluentform'),
        'value' => 'zip|gz|gzip|rar|7z',
    ),
    array(
        'label' => __('Executable Files (exe)', 'fluentform'),
        'value' => 'exe',
    ),
    array(
        'label' => __('CSV (csv)', 'fluentform'),
        'value' => 'csv',
    ),
);

$fileTypeOptions = apply_filters('fluentform_file_type_options', $fileTypeOptions);

$validation_rule_settings = array(
    'required' =>
        array(
            'template' => 'inputRadio',
            'label' => __('Required', 'fluentform'),
            'help_text' => __('Select whether this field is a required field for the form or not.', 'fluentform'),
            'options' =>
                array(
                    array(
                        'value' => true,
                        'label' => __('Yes', 'fluentform'),
                    ),
                    array(
                        'value' => false,
                        'label' => __('No', 'fluentform'),
                    ),
                ),
        ),
    'email' =>
        array(
            'template' => 'inputRadio',
            'label' => __('Validate Email', 'fluentform'),
            'help_text' => __('Select whether to validate this field as email or not', 'fluentform'),
            'options' =>
                array(
                    array(
                        'value' => true,
                        'label' => __('Yes', 'fluentform'),
                    ),
                    array(
                        'value' => false,
                        'label' => __('No', 'fluentform'),
                    ),
                ),
        ),
    'url' =>
        array(
            'template' => 'inputRadio',
            'label' => __('Validate URL', 'fluentform'),
            'help_text' => __('Select whether to validate this field as URL or not', 'fluentform'),
            'options' =>
                array(
                    array(
                        'value' => true,
                        'label' => __('Yes', 'fluentform'),
                    ),
                    array(
                        'value' => false,
                        'label' => __('No', 'fluentform'),
                    ),
                ),
        ),
    'min' =>
        array(
            'template' => 'inputText',
            'type' => 'number',
            'label' => __('Min Value', 'fluentform'),
            'help_text' => __('Minimum value for the input field.', 'fluentform'),
        ),
    'max' =>
        array(
            'template' => 'inputText',
            'type' => 'number',
            'label' => __('Max Value', 'fluentform'),
            'help_text' => __('Maximum value for the input field.', 'fluentform'),
        ),
    'max_file_size' =>
        array(
            'template' => 'maxFileSize',
            'label' => __('Max File Size', 'fluentform'),
            'help_text' => __('The file size limit uploaded by the user.', 'fluentform'),
        ),
    'max_file_count' =>
        array(
            'template' => 'inputText',
            'type' => 'number',
            'label' => __('Max Files Count', 'fluentform'),
            'help_text' => __('Maximum user file upload number.', 'fluentform'),
        ),
    'allowed_file_types' =>
        array(
            'template' => 'inputCheckbox',
            'label' => __('Allowed Files', 'fluentform'),
            'help_text' => __('Allowed Files', 'fluentform'),
            'fileTypes' => array(
                array(
                    'title' => __('Images', 'fluentform'),
                    'types' => array('jpg', 'jpeg', 'gif', 'png', 'bmp'),
                ),
                array(
                    'title' => __('Audio', 'fluentform'),
                    'types' => array('mp3', 'wav', 'ogg', 'oga', 'wma', 'mka', 'm4a', 'ra', 'mid', 'midi'),
                ),
                array(
                    'title' => __('Video', 'fluentform'),
                    'types' => array(
                        'avi',
                        'divx',
                        'flv',
                        'mov',
                        'ogv',
                        'mkv',
                        'mp4',
                        'm4v',
                        'divx',
                        'mpg',
                        'mpeg',
                        'mpe',
                    ),
                ),
                array(
                    'title' => __('PDF', 'fluentform'),
                    'types' => array('pdf'),
                ),
                array(
                    'title' => __('Docs', 'fluentform'),
                    'types' => array(
                        'doc',
                        'ppt',
                        'pps',
                        'xls',
                        'mdb',
                        'docx',
                        'xlsx',
                        'pptx',
                        'odt',
                        'odp',
                        'ods',
                        'odg',
                        'odc',
                        'odb',
                        'odf',
                        'rtf',
                        'txt'
                    ),
                ),
                array(
                    'title' => __('Zip Archives', 'fluentform'),
                    'types' => array('zip', 'gz', 'gzip', 'rar', '7z',),
                ),
                array(
                    'title' => __('Executable Files', 'fluentform'),
                    'types' =>
                        array('exe'),
                ),
                array(
                    'title' => __('CSV', 'fluentform'),
                    'types' => array('csv'),
                ),
            ),
            'options' => $fileTypeOptions,
        ),
    'allowed_image_types' =>
        array(
            'template' => 'inputCheckbox',
            'label' => __('Allowed Images', 'fluentform'),
            'help_text' => __('Allowed Images', 'fluentform'),
            'fileTypes' =>
                array(
                    array(
                        'title' => __('JPG', 'fluentform'),
                        'types' => array('jpg|jpeg',),
                    ),
                    array(
                        'title' => __('PNG', 'fluentform'),
                        'types' => array('png'),
                    ),
                    array(
                        'title' => __('GIF', 'fluentform'),
                        'types' => array('gif'),
                    ),
                ),
            'options' => array(
                array(
                    'label' => __('JPG', 'fluentform'),
                    'value' => 'jpg|jpeg',
                ),
                array(
                    'label' => __('PNG', 'fluentform'),
                    'value' => 'png',
                ),
                array(
                    'label' => __('GIF', 'fluentform'),
                    'value' => 'gif',
                ),
            ),
        )
);

return apply_filters('fluent_editor_validation_rule_settings', $validation_rule_settings);
