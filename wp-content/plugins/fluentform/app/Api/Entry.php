<?php

namespace FluentForm\App\Api;
use FluentForm\App\Modules\Entries\Report;
use FluentForm\App\Modules\Form\FormDataParser;
use FluentForm\App\Modules\Form\FormFieldsParser;

class Entry
{
    private $form;

    public function __construct($form)
    {
        $this->form = $form;
    }

    public function entries($atts = [], $includeFormats = false)
    {
        if($includeFormats) {
            if (!defined('FLUENTFORM_RENDERING_ENTRIES')) {
                define('FLUENTFORM_RENDERING_ENTRIES', true);
            }
        }

        $atts = wp_parse_args($atts, [
            'per_page' => 10,
            'page' => 1,
            'search' => '',
            'sort_type' => 'DESC',
            'entry_type' => 'all'
        ]);

        $offset = $atts['per_page'] * ($atts['page'] - 1);

        $entryQuery = wpFluent()->table('fluentform_submissions')
                        ->where('form_id', $this->form->id)
                        ->orderBy('id', $atts['sort_type'])
                        ->limit($atts['per_page'])
                        ->offset($offset);

        $type = $atts['entry_type'];

        if($type && $type != 'all') {
            $entryQuery->where('status', $type);
        }

        if ($searchString = $atts['search']) {
            $entryQuery->where(function ($q) use ($searchString) {
                $q->where('id', 'LIKE', "%{$searchString}%")
                    ->orWhere('response', 'LIKE', "%{$searchString}%")
                    ->orWhere('status', 'LIKE', "%{$searchString}%")
                    ->orWhere('created_at', 'LIKE', "%{$searchString}%");
            });
        }

        $count = $entryQuery->count();

        $data = $entryQuery->get();

        $dataCount = count($data);

        $from = $dataCount > 0 ? ($atts['page'] - 1) * $atts['per_page'] + 1 : null;

        $to =  $dataCount > 0 ? $from + $dataCount - 1 : null;
        $lastPage = (int) ceil($count / $atts['per_page']);

        if($includeFormats) {
            $data = FormDataParser::parseFormEntries($data, $this->form);
        }

        foreach ($data as $datum) {
            $datum->response = json_decode($datum->response, true);
        }

        return [
            'current_page'  => $atts['page'],
            'per_page'      => $atts['per_page'],
            'from'          => $from,
            'to'            => $to,
            'last_page'     => $lastPage,
            'total'         => $count,
            'data'          => $data,
        ];
    }

    public function entry($entryId, $includeFormats = false)
    {
        $submission = wpFluent()->table('fluentform_submissions')
                    ->where('form_id', $this->form->id)
                    ->where('id', $entryId)
                    ->first();

        if(!$submission) {
            return null;
        }

        $inputs = FormFieldsParser::getEntryInputs($this->form);
        $submission = FormDataParser::parseFormEntry($submission, $this->form, $inputs, true);

        if(!$includeFormats) {
            $submission->response = json_decode($submission->response, true);
            return [
                'submission' => $submission
            ];
        }

        if ($submission->user_id) {
            $user = get_user_by('ID', $submission->user_id);
            $user_data = [
                'name'      => $user->display_name,
                'email'     => $user->user_email,
                'ID'        => $user->ID,
                'permalink' => get_edit_user_link($user->ID)
            ];
            $submission->user = $user_data;
        }

        $submission = apply_filters('fluentform_single_response_data', $submission, $this->form->id);

        $submission->response = json_decode($submission->response);

        $inputLabels = FormFieldsParser::getAdminLabels($this->form, $inputs);

        return [
            'submission' => $submission,
            'labels'     => $inputLabels
        ];
    }

    public function report($statuses = [])
    {
        $reportClass = new Report(wpFluentForm());
        return $reportClass->generateReport($this->form, $statuses);
    }

}