<?php

namespace FluentForm\App\Databases;

use FluentForm\App\Databases\Migrations\FormAnalytics;
use FluentForm\App\Databases\Migrations\FormLogs;
use FluentForm\App\Databases\Migrations\Forms;
use FluentForm\App\Databases\Migrations\FormMeta;
use FluentForm\App\Databases\Migrations\FormSubmissionDetails;
use FluentForm\App\Databases\Migrations\FormSubmissions;
use FluentForm\App\Databases\Migrations\FormSubmissionMeta;
use FluentForm\App\Databases\Migrations\ScheduledActions;
use FluentForm\App\Modules\Form\Form;

class DatabaseMigrator
{
    public static function run()
    {
        Forms::migrate();
        FormMeta::migrate();
        FormSubmissions::migrate(true);
        FormSubmissionMeta::migrate();
        FormAnalytics::migrate();
        FormSubmissionDetails::migrate();
        FormLogs::migrate();
        ScheduledActions::migrate();
    }
}
