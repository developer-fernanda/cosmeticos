<?php

namespace FluentForm\App\Modules\Entries;

use FluentForm\App\Helpers\Helper;
use FluentForm\App\Modules\Form\FormFieldsParser;
use FluentForm\Framework\Foundation\Application;
use FluentForm\Framework\Helpers\ArrayHelper;

class Report
{
    private $app;
    private $formModel;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->formModel = wpFluent()->table('fluentform_forms');
    }

    /**
     * @param bool $formId
     */
    public function getReport($formId = false)
    {
        if (!$formId) {
            $formId = intval($_REQUEST['form_id']);
        }

        $this->maybeMigrateData($formId);

        $statuses = $this->app->request->get('statuses');

        $form = $this->formModel->find($formId);

        $report = $this->generateReport($form, $statuses);

        wp_send_json_success($report);
    }


    public function generateReport($form, $statuses = [])
    {
        $formInputs = FormFieldsParser::getEntryInputs($form, ['admin_label', 'element', 'options']);

        $inputLabels = FormFieldsParser::getAdminLabels($form, $formInputs);

        $elements = [];

        foreach ($formInputs as $inputName => $input) {
            $elements[$inputName] = $input['element'];
            if ($input['element'] == 'select_country') {
                $formInputs[$inputName]['options'] = getFluentFormCountryList();
            }
        }

        $reportableInputs = Helper::getReportableInputs();

        $formReportableInputs = array_intersect($reportableInputs, array_values($elements));

        $reportableInputs = Helper::getSubFieldReportableInputs();
        $formSubFieldInputs = array_intersect($reportableInputs, array_values($elements));

        if (!$formReportableInputs && !$formSubFieldInputs) {
            return [
                'report_items'  => (object)[],
                'total_entries' => 0
            ];
        }

        $inputs = [];
        $subfieldInputs = [];
        foreach ($elements as $elementKey => $element) {
            if (in_array($element, $formReportableInputs)) {
                $inputs[$elementKey] = $element;
            }
            if (in_array($element, $formSubFieldInputs)) {
                $subfieldInputs[$elementKey] = $element;
            }
        }

        $whereClasuses = [];

        if ($statuses) {
            $whereClasuses['fluentform_submissions.status'] = [
                'method' => 'whereIn',
                'values' => $statuses
            ];
        }

        $reports = $this->getInputReport($form->id, array_keys($inputs), $whereClasuses);

        $subFieldReports = $this->getSubFieldInputReport($form->id, array_keys($subfieldInputs), $whereClasuses);

        $reports = array_merge($reports, $subFieldReports);

        foreach ($reports as $reportKey => $report) {
            $reports[$reportKey]['label'] = $inputLabels[$reportKey];
            $reports[$reportKey]['element'] = ArrayHelper::get($inputs, $reportKey, []);
            $reports[$reportKey]['options'] = $formInputs[$reportKey]['options'];
        }

        return [
            'report_items'  => $reports,
            'total_entries' => $this->getEntryCounts($form->id, $statuses),
            'browsers'      => $this->getbrowserCounts($form->id, $statuses),
            'devices'       => $this->getDeviceCounts($form->id, $statuses),
        ];
    }

    public function getInputReport($formId, $fieldNames, $whereClasuses)
    {
        if(!$fieldNames) {
            return [];
        }
        global $wpdb;
        $reportQuery = wpFluent()->table('fluentform_entry_details')
            ->select([
                'fluentform_entry_details.field_name',
                'fluentform_entry_details.sub_field_name',
                'fluentform_entry_details.field_value'
            ])
            ->select(wpFluent()->raw('count(' . $wpdb->prefix . 'fluentform_entry_details.field_name) as total_count'))
            ->where('fluentform_entry_details.form_id', $formId)
            ->whereIn('fluentform_entry_details.field_name', $fieldNames)
            ->leftJoin('fluentform_submissions', 'fluentform_submissions.id', '=', 'fluentform_entry_details.submission_id');

        if ($whereClasuses) {
            foreach ($whereClasuses as $clauseColumn => $clasus) {
                $reportQuery = $reportQuery->{$clasus['method']}($clauseColumn, $clasus['values']);
            }
        }

        $reports = $reportQuery->groupBy(['fluentform_entry_details.field_name', 'fluentform_entry_details.field_value'])
            ->get();

        $formattedReports = [];
        foreach ($reports as $report) {
            $formattedReports[$report->field_name]['reports'][] = [
                'value'     => maybe_unserialize($report->field_value),
                'count'     => $report->total_count,
                'sub_field' => $report->sub_field_name,
            ];
            $formattedReports[$report->field_name]['total_entry'] = $this->getEntryTotal($report->field_name, $formId, $whereClasuses);
        }

        return $formattedReports;
    }

    public function getSubFieldInputReport($formId, $fieldNames, $whereClasuses)
    {
        if(!$fieldNames) {
            return [];
        }

        global $wpdb;
        $reportQuery = wpFluent()->table('fluentform_entry_details')
            ->select([
                'fluentform_entry_details.field_name',
                'fluentform_entry_details.sub_field_name',
                'fluentform_entry_details.field_value'
            ])
            ->select(wpFluent()->raw('count(' . $wpdb->prefix . 'fluentform_entry_details.field_name) as total_count'))
            ->where('fluentform_entry_details.form_id', $formId)
            ->whereIn('fluentform_entry_details.field_name', $fieldNames)
            ->leftJoin('fluentform_submissions', 'fluentform_submissions.id', '=', 'fluentform_entry_details.submission_id');

        if ($whereClasuses) {
            foreach ($whereClasuses as $clauseColumn => $clasus) {
                $reportQuery = $reportQuery->{$clasus['method']}($clauseColumn, $clasus['values']);
            }
        }

        $reports = $reportQuery->groupBy(['fluentform_entry_details.field_name', 'fluentform_entry_details.field_value', 'fluentform_entry_details.sub_field_name'])
            ->get();


        $formattedReports = [];
        foreach ($reports as $report) {
            $filedValue = maybe_unserialize($report->field_value);
            if(is_array($filedValue)) {
                $filedValue = implode(', ', $filedValue);
            }
            $formattedReports[$report->field_name]['reports'][] = [
                'value'     => $report->sub_field_name . ' : ' . $filedValue,
                'count'     => $report->total_count,
                'sub_field' => $report->sub_field_name,
            ];
            $formattedReports[$report->field_name]['total_entry'] = $this->getEntryTotal($report->field_name, $formId, $whereClasuses);
        }

        return $formattedReports;
    }

    public function getEntryTotal($fieldName, $formId, $whereClasuses)
    {
        $query = wpFluent()->table('fluentform_entry_details')
            ->select('fluentform_entry_details.id')
            ->where('fluentform_entry_details.form_id', $formId)
            ->where('fluentform_entry_details.field_name', $fieldName)
            ->groupBy(['fluentform_entry_details.field_name', 'fluentform_entry_details.submission_id'])
            ->leftJoin('fluentform_submissions', 'fluentform_submissions.id', '=', 'fluentform_entry_details.submission_id');

        if ($whereClasuses) {
            foreach ($whereClasuses as $clauseColumn => $clasus) {
                $query = $query->{$clasus['method']}($clauseColumn, $clasus['values']);
            }
        }

        return $query->count();
    }

    private function maybeMigrateData($formId)
    {
        // We have to check if we need to migrate the data
        if (Helper::getFormMeta($formId, 'report_data_migrated') == 'yes') {
            return true;
        }
        global $wpdb;
        // let's migrate the data
        $unmigratedData = wpFluent()
            ->table('fluentform_submissions')
            ->select([
                'fluentform_submissions.id',
                'fluentform_submissions.response'
            ])
            ->where('fluentform_submissions.form_id', $formId)
            ->where(wpFluent()->raw($wpdb->prefix . 'fluentform_submissions.id NOT IN (SELECT submission_id from ' . $wpdb->prefix . 'fluentform_entry_details)'))
            ->get();

        if (!$unmigratedData) {
            return Helper::setFormMeta($formId, 'report_data_migrated', 'yes');
        }

        $entries = new Entries();
        foreach ($unmigratedData as $datum) {
            $value = json_decode($datum->response, true);
            $entries->recordEntryDetails($datum->id, $formId, $value);
        }

        return true;

    }

    private function getEntryCounts($formId, $statuses = false)
    {
        $totalEntries = wpFluent()
            ->table('fluentform_submissions')
            ->where('fluentform_submissions.form_id', $formId);

        if ($statuses) {
            $totalEntries = $totalEntries->whereIn('fluentform_submissions.status', $statuses);
        } else {
            $totalEntries = $totalEntries->where('fluentform_submissions.status', '!=', 'trashed');
        }
        return $totalEntries->count();
    }

    private function getBrowserCounts($formId, $statuses)
    {
        global $wpdb;
        $browserCounts = wpFluent()->table('fluentform_submissions')
            ->select([
                wpFluent()->raw('count(' . $wpdb->prefix . 'fluentform_submissions.id) as total_count'),
                'browser'
            ])
            ->where('form_id', $formId);
        if ($statuses) {
            $browserCounts = $browserCounts->whereIn('status', $statuses);
        } else {
            $browserCounts = $browserCounts->where('status', '!=', 'trashed');
        }

        $browserCounts = $browserCounts->groupBy('browser')
            ->get();

        $formattedData = [];
        foreach ($browserCounts as $browser) {
            $formattedData[$browser->browser] = $browser->total_count;
        }

        return $formattedData;

    }

    private function getDeviceCounts($formId, $statuses)
    {
        global $wpdb;
        $deviceCounts = wpFluent()->table('fluentform_submissions')
            ->select([
                wpFluent()->raw('count(' . $wpdb->prefix . 'fluentform_submissions.id) as total_count'),
                'device'
            ])
            ->where('form_id', $formId);
        if ($statuses) {
            $deviceCounts = $deviceCounts->whereIn('status', $statuses);
        } else {
            $deviceCounts = $deviceCounts->where('status', '!=', 'trashed');
        }

        $deviceCounts = $deviceCounts->groupBy('device')
            ->get();

        $formattedData = [];
        foreach ($deviceCounts as $deviceCount) {
            $formattedData[$deviceCount->device] = $deviceCount->total_count;
        }
        return $formattedData;
    }

}