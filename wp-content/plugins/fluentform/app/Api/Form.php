<?php

namespace FluentForm\App\Api;

use FluentForm\App\Helpers\Helper;
use FluentForm\Framework\Helpers\ArrayHelper;

class Form
{
    public function forms($atts = [], $withFields = false)
    {
        $defaultAtts = [
            'search' => '',
            'status' => 'all',
            'sort_column' => 'id',
            'sort_by' => 'DESC',
            'per_page' => 10,
            'page' => 1
        ];

        $atts = wp_parse_args($atts, $defaultAtts);

        $perPage = ArrayHelper::get($atts, 'per_page', 10);
        $search = ArrayHelper::get($atts, 'search', '');
        $status = ArrayHelper::get($atts, 'status', 'all');

        $shortColumn = ArrayHelper::get($atts, 'sort_column', 'id');
        $sortBy = ArrayHelper::get($atts, 'sort_by', 'DESC');

        $query = wpFluent()->table('fluentform_forms')
            ->orderBy($shortColumn, $sortBy);

        if ($status && $status != 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', '%' . $search . '%');
                $q->orWhere('title', 'LIKE', '%' . $search . '%');
            });
        }

        $currentPage = intval(ArrayHelper::get($atts, 'page', 1));
        $total = $query->count();
        $skip = $perPage * ($currentPage - 1);
        $data = (array) $query->select('*')->limit($perPage)->offset($skip)->get();

        $dataCount = count($data);

        $from = $dataCount > 0 ? ($currentPage - 1) * $perPage + 1 : null;

        $to = $dataCount > 0 ? $from + $dataCount - 1 : null;
        $lastPage = (int) ceil($total / $perPage);

        $forms = array(
            'current_page'  => $currentPage,
            'per_page'      => $perPage,
            'from'          => $from,
            'to'            => $to,
            'last_page'     => $lastPage,
            'total'         => $total,
            'data'          => $data,
        );

        foreach ($forms['data'] as $form) {
            $formInstance = $this->form($form);
            $form->preview_url = Helper::getPreviewUrl($form->id, 'classic');
            $form->edit_url = Helper::getFormAdminPermalink('editor', $form);
            $form->settings_url = Helper::getFormSettingsUrl($form);
            $form->entries_url = Helper::getFormAdminPermalink('entries', $form);
            $form->analytics_url = Helper::getFormAdminPermalink('analytics', $form);
            $form->total_views = Helper::getFormMeta($form->id, '_total_views', 0);
            $form->total_Submissions = $formInstance->submissionCount();
            $form->unread_count = $formInstance->unreadCount();
            $form->conversion = $formInstance->conversionRate();
            if(Helper::isConversionForm($form->id)) {
                $form->conversion_preview = Helper::getPreviewUrl($form->id, 'conversational');
            }

            if(!$withFields) {
                unset($form->form_fields);
            }
        }

        return $forms;
    }

    public function find($formId)
    {
        return wpFluent()->table('fluentform_forms')->where('id', $formId)->first();
    }

    /**
     * get Form Properties instance
     * @param int|object $form
     * @return \FluentForm\App\Api\FormProperties
     */
    public function form($form)
    {
        if(is_numeric($form)) {
            $form = $this->find($form);
        }

        return (new FormProperties($form));
    }

    public function entryInstance($form)
    {
        if(is_numeric($form)) {
            $form = $this->find($form);
        }

        return (new Entry($form));
    }

}