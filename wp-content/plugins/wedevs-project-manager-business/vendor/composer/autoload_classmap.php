<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Create_PM_Pro_Migrations_Table' => $baseDir . '/db/migrations/create_pm_pro_migrations_table.php',
    'PM_Pro_Create_Table' => $baseDir . '/db/Create_Table.php',
    'ProSeeder' => $baseDir . '/db/seeds/ProSeeder.php',
    'WeDevs\\PM_Pro\\Calendar\\Controllers\\Calendar_Controller' => $baseDir . '/src/Calendar/Controllers/Calendar_Controller.php',
    'WeDevs\\PM_Pro\\Calendar\\Transformers\\Calendar_Transformer' => $baseDir . '/src/Calendar/Transformers/Calendar_Transformer.php',
    'WeDevs\\PM_Pro\\Common\\Traits\\Transformer_Manager' => $baseDir . '/src/Common/Traits/Transformer_Manager.php',
    'WeDevs\\PM_Pro\\Common\\Transformers\\Meta_Transformer' => $baseDir . '/src/Common/Transformers/Meta_Transformer.php',
    'WeDevs\\PM_Pro\\Core\\Config\\Config' => $baseDir . '/core/Config/Config.php',
    'WeDevs\\PM_Pro\\Core\\Database\\Abstract_Migration' => $baseDir . '/core/Database/Abstract_Migration.php',
    'WeDevs\\PM_Pro\\Core\\Database\\Migrater' => $baseDir . '/core/Database/Migrater.php',
    'WeDevs\\PM_Pro\\Core\\Database\\Migration' => $baseDir . '/core/Database/Migration.php',
    'WeDevs\\PM_Pro\\Core\\Database\\Migration_Model' => $baseDir . '/core/Database/Migration_Model.php',
    'WeDevs\\PM_Pro\\Core\\Database\\Model_Observer' => $baseDir . '/core/Database/Model_Observer.php',
    'WeDevs\\PM_Pro\\Core\\Exceptions\\Class_Not_Found' => $baseDir . '/core/Exceptions/Class_Not_Found.php',
    'WeDevs\\PM_Pro\\Core\\Exceptions\\Invalid_Route_Handler' => $baseDir . '/core/Exceptions/Invalid_Route_Handler.php',
    'WeDevs\\PM_Pro\\Core\\Exceptions\\Undefined_Method_Call' => $baseDir . '/core/Exceptions/Undefined_Method_Call.php',
    'WeDevs\\PM_Pro\\Core\\File_System\\File_System' => $baseDir . '/core/File_System/File_System.php',
    'WeDevs\\PM_Pro\\Core\\Integrations\\Slack' => $baseDir . '/core/Integrations/Slack.php',
    'WeDevs\\PM_Pro\\Core\\Notifications\\Emails\\Comment_Mention_Notification' => $baseDir . '/core/Notifications/Emails/Comment_Mention_Notification.php',
    'WeDevs\\PM_Pro\\Core\\Notifications\\Emails\\Daily_Digest' => $baseDir . '/core/Notifications/Emails/Daily_Digest.php',
    'WeDevs\\PM_Pro\\Core\\Notifications\\Notification' => $baseDir . '/core/Notifications/Notification.php',
    'WeDevs\\PM_Pro\\Core\\Permissions\\Abstract_Permission' => $baseDir . '/core/Permissions/Abstract_Permission.php',
    'WeDevs\\PM_Pro\\Core\\Permissions\\Administrator' => $baseDir . '/core/Permissions/Administrator.php',
    'WeDevs\\PM_Pro\\Core\\Permissions\\Permission' => $baseDir . '/core/Permissions/Permission.php',
    'WeDevs\\PM_Pro\\Core\\Rewrites\\Rewrite' => $baseDir . '/core/Rewrites/Rewrite.php',
    'WeDevs\\PM_Pro\\Core\\Router\\Router' => $baseDir . '/core/Router/Router.php',
    'WeDevs\\PM_Pro\\Core\\Router\\Uri_Parser' => $baseDir . '/core/Router/Uri_Parser.php',
    'WeDevs\\PM_Pro\\Core\\Router\\WP_Router' => $baseDir . '/core/Router/WP_Router.php',
    'WeDevs\\PM_Pro\\Core\\Sanitizer\\Abstract_Sanitizer' => $baseDir . '/core/Sanitizer/Abstract_Sanitizer.php',
    'WeDevs\\PM_Pro\\Core\\Sanitizer\\Sanitizer' => $baseDir . '/core/Sanitizer/Sanitizer.php',
    'WeDevs\\PM_Pro\\Core\\Shortcodes\\PM_Shortcode' => $baseDir . '/core/Shortcodes/PM_Shortcode.php',
    'WeDevs\\PM_Pro\\Core\\Singletonable' => $baseDir . '/core/Singletonable.php',
    'WeDevs\\PM_Pro\\Core\\Textdomain\\Textdomain' => $baseDir . '/core/Textdomain/Textdomain.php',
    'WeDevs\\PM_Pro\\Core\\Update\\Update' => $baseDir . '/core/Update/Update.php',
    'WeDevs\\PM_Pro\\Core\\Upgrades\\Upgrade' => $baseDir . '/core/Upgrades/Upgrade.php',
    'WeDevs\\PM_Pro\\Core\\Upgrades\\Upgrade_0_2' => $baseDir . '/core/Upgrades/Upgrade_0_2.php',
    'WeDevs\\PM_Pro\\Core\\Upgrades\\Upgrade_0_3' => $baseDir . '/core/Upgrades/Upgrade_0_3.php',
    'WeDevs\\PM_Pro\\Core\\Validator\\Abstract_Validator' => $baseDir . '/core/Validator/Abstract_Validator.php',
    'WeDevs\\PM_Pro\\Core\\Validator\\Validator' => $baseDir . '/core/Validator/Validator.php',
    'WeDevs\\PM_Pro\\Core\\WP\\Active' => $baseDir . '/core/WP/Active.php',
    'WeDevs\\PM_Pro\\Core\\WP\\Deactive' => $baseDir . '/core/WP/Deactive.php',
    'WeDevs\\PM_Pro\\Core\\WP\\Enqueue_Scripts' => $baseDir . '/core/WP/Enqueue_Scripts.php',
    'WeDevs\\PM_Pro\\Core\\WP\\Frontend' => $baseDir . '/core/WP/Frontend.php',
    'WeDevs\\PM_Pro\\Core\\WP\\Integrations' => $baseDir . '/core/WP/Integrations.php',
    'WeDevs\\PM_Pro\\Core\\WP\\Menu' => $baseDir . '/core/WP/Menu.php',
    'WeDevs\\PM_Pro\\Core\\WP\\Output' => $baseDir . '/core/WP/Output.php',
    'WeDevs\\PM_Pro\\Core\\WP\\Register_Scripts' => $baseDir . '/core/WP/Register_Scripts.php',
    'WeDevs\\PM_Pro\\Core\\WP\\Shortcodes' => $baseDir . '/core/WP/Shortcodes.php',
    'WeDevs\\PM_Pro\\Duplicate\\Controllers\\Duplicate' => $baseDir . '/src/Duplicate/Controllers/Duplicate.php',
    'WeDevs\\PM_Pro\\Duplicate\\Controllers\\Duplicate_Controller' => $baseDir . '/src/Duplicate/Controllers/Duplicate_Controller.php',
    'WeDevs\\PM_Pro\\File\\Controllers\\File_Controller' => $baseDir . '/src/File/Controllers/File_Controller.php',
    'WeDevs\\PM_Pro\\File\\Models\\File' => $baseDir . '/src/File/Models/File.php',
    'WeDevs\\PM_Pro\\File\\Transformers\\File_Transformer' => $baseDir . '/src/File/Transformers/File_Transformer.php',
    'WeDevs\\PM_Pro\\Integrations\\Controllers\\Integrations_Controller' => $baseDir . '/src/Integrations/Controllers/Integrations_Controller.php',
    'WeDevs\\PM_Pro\\Integrations\\Helpers\\Intg_helper' => $baseDir . '/src/Integrations/Helpers/Intg_helper.php',
    'WeDevs\\PM_Pro\\Integrations\\Models\\Integrations' => $baseDir . '/src/Integrations/Models/Integrations.php',
    'WeDevs\\PM_Pro\\Label\\Controllers\\Task_Label_Controller' => $baseDir . '/src/Label/Controllers/Task_Label_Controller.php',
    'WeDevs\\PM_Pro\\Label\\Models\\Label' => $baseDir . '/src/Label/Models/Label.php',
    'WeDevs\\PM_Pro\\Label\\Models\\Task_Label_Task' => $baseDir . '/src/Label/Models/Task_Label_Task.php',
    'WeDevs\\PM_Pro\\Label\\Transformers\\Label_Transformer' => $baseDir . '/src/Label/Transformers/Label_Transformer.php',
    'WeDevs\\PM_Pro\\Module_Lists\\Controllers\\Module_Lists_Controller' => $baseDir . '/src/Module_Lists/Controllers/Module_Lists_Controller.php',
    'WeDevs\\PM_Pro\\Modules\\Gantt\\src\\Models\\Gantt' => $baseDir . '/modules/gantt/src/Models/Gantt.php',
    'WeDevs\\PM_Pro\\Modules\\Gantt\\src\\Transformers\\Link_Transformer' => $baseDir . '/modules/gantt/src/Transformers/Link_Transformer.php',
    'WeDevs\\PM_Pro\\Modules\\custom_fields\\core\\Actions' => $baseDir . '/modules/custom_fields/core/Actions.php',
    'WeDevs\\PM_Pro\\Modules\\custom_fields\\core\\Filters' => $baseDir . '/modules/custom_fields/core/Filters.php',
    'WeDevs\\PM_Pro\\Modules\\custom_fields\\core\\Scripts\\Scripts' => $baseDir . '/modules/custom_fields/core/Scripts/Scripts.php',
    'WeDevs\\PM_Pro\\Modules\\custom_fields\\src\\Controllers\\Custom_Field_Controller' => $baseDir . '/modules/custom_fields/src/Controllers/Custom_Field_Controller.php',
    'WeDevs\\PM_Pro\\Modules\\custom_fields\\src\\Models\\Custom_Field' => $baseDir . '/modules/custom_fields/src/Models/Custom_Field.php',
    'WeDevs\\PM_Pro\\Modules\\custom_fields\\src\\Models\\Task_Custom_Field' => $baseDir . '/modules/custom_fields/src/Models/Task_Custom_Field.php',
    'WeDevs\\PM_Pro\\Modules\\custom_fields\\src\\Transformers\\Custom_Field_Transformer' => $baseDir . '/modules/custom_fields/src/Transformers/Custom_Field_Transformer.php',
    'WeDevs\\PM_Pro\\Modules\\custom_fields\\src\\Transformers\\Task_Custom_Field_Transformer' => $baseDir . '/modules/custom_fields/src/Transformers/Task_Custom_Field_Transformer.php',
    'WeDevs\\PM_Pro\\Modules\\gantt\\core\\Permissions\\Gantt' => $baseDir . '/modules/gantt/core/Permission/Permission.php',
    'WeDevs\\PM_Pro\\Modules\\gantt\\db\\migrations\\Create_Gantt_Chart_Links_Table' => $baseDir . '/modules/gantt/db/migrations/create_gantt_chart_links_table.php',
    'WeDevs\\PM_Pro\\Modules\\gantt\\src\\Controllers\\Gantt_Controller' => $baseDir . '/modules/gantt/src/Controllers/Gantt_Controller.php',
    'WeDevs\\PM_Pro\\Modules\\gantt\\src\\Validators\\Gantt_Validator' => $baseDir . '/modules/gantt/src/Validators/Gantt_Validator.php',
    'WeDevs\\PM_Pro\\Modules\\invoice\\core\\PDF\\PDF' => $baseDir . '/modules/invoice/core/PDF/PDF.php',
    'WeDevs\\PM_Pro\\Modules\\invoice\\core\\Paypal\\Paypal' => $baseDir . '/modules/invoice/core/Paypal/Paypal.php',
    'WeDevs\\PM_Pro\\Modules\\invoice\\core\\Permission\\Payment' => $baseDir . '/modules/invoice/core/Permission/Payment.php',
    'WeDevs\\PM_Pro\\Modules\\invoice\\db\\migrations\\Create_Invoice_Table' => $baseDir . '/modules/invoice/db/migrations/create_invoicce_table.php',
    'WeDevs\\PM_Pro\\Modules\\invoice\\includes\\Shortcodes' => $baseDir . '/modules/invoice/includes/Shortcodes.php',
    'WeDevs\\PM_Pro\\Modules\\invoice\\includes\\shortcodes\\Invoice' => $baseDir . '/modules/invoice/includes/shortcodes/Invoice.php',
    'WeDevs\\PM_Pro\\Modules\\invoice\\src\\Controllers\\Invoice_Controller' => $baseDir . '/modules/invoice/src/Controllers/Invoice_Controller.php',
    'WeDevs\\PM_Pro\\Modules\\invoice\\src\\Models\\Invoice' => $baseDir . '/modules/invoice/src/Models/Invoice.php',
    'WeDevs\\PM_Pro\\Modules\\invoice\\src\\Transformers\\Invoice_Meta_Transformer' => $baseDir . '/modules/invoice/src/Transformers/Invoice_Meta_Transformer.php',
    'WeDevs\\PM_Pro\\Modules\\invoice\\src\\Transformers\\Invoice_Transformer' => $baseDir . '/modules/invoice/src/Transformers/Invoice_Transformer.php',
    'WeDevs\\PM_Pro\\Modules\\kanboard\\core\\Permissions\\Kanboard' => $baseDir . '/modules/kanboard/core/Permission/Permission.php',
    'WeDevs\\PM_Pro\\Modules\\kanboard\\src\\Controllers\\Kanboard_Controller' => $baseDir . '/modules/kanboard/src/Controllers/Kanboard_Controller.php',
    'WeDevs\\PM_Pro\\Modules\\kanboard\\src\\Models\\Kanboard' => $baseDir . '/modules/kanboard/src/Models/Kanboard.php',
    'WeDevs\\PM_Pro\\Modules\\kanboard\\src\\Models\\Kanboard_Boardable' => $baseDir . '/modules/kanboard/src/Models/Kanboard_Boardable.php',
    'WeDevs\\PM_Pro\\Modules\\kanboard\\src\\Transformers\\Kanboard_Transformer' => $baseDir . '/modules/kanboard/src/Transformers/Kanboard_Transformer.php',
    'WeDevs\\PM_Pro\\Modules\\kanboard\\src\\Validators\\Kanboard_Validator' => $baseDir . '/modules/kanboard/src/Validators/Kanboard_Validator.php',
    'WeDevs\\PM_Pro\\Modules\\pm_buddypress\\src\\PM_BP_Group_Extension' => $baseDir . '/modules/pm_buddypress/src/PM_BP_Group_Extension.php',
    'WeDevs\\PM_Pro\\Modules\\stripe\\src\\Controllers\\Stripe_Controller' => $baseDir . '/modules/stripe/src/Controllers/Stripe_Controller.php',
    'WeDevs\\PM_Pro\\Modules\\sub_tasks\\Permissions\\Create_Sub_Task' => $baseDir . '/modules/sub_tasks/Permissions/Create_Sub_Task.php',
    'WeDevs\\PM_Pro\\Modules\\sub_tasks\\Permissions\\Edit_Sub_Task' => $baseDir . '/modules/sub_tasks/Permissions/Edit_Sub_Task.php',
    'WeDevs\\PM_Pro\\Modules\\sub_tasks\\core\\Action' => $baseDir . '/modules/sub_tasks/core/Action.php',
    'WeDevs\\PM_Pro\\Modules\\sub_tasks\\src\\Controllers\\Sub_Tasks_Controller' => $baseDir . '/modules/sub_tasks/src/Controllers/Sub_Tasks_Controller.php',
    'WeDevs\\PM_Pro\\Modules\\sub_tasks\\src\\Models\\Sub_Tasks' => $baseDir . '/modules/sub_tasks/src/Models/Sub_Tasks.php',
    'WeDevs\\PM_Pro\\Modules\\sub_tasks\\src\\Transformers\\Sub_Task_Transformer' => $baseDir . '/modules/sub_tasks/src/Transformers/Sub_Task_Transformer.php',
    'WeDevs\\PM_Pro\\Modules\\sub_tasks\\src\\Validators\\Create_Sub_Task' => $baseDir . '/modules/sub_tasks/src/Validators/Create_Sub_Task.php',
    'WeDevs\\PM_Pro\\Modules\\sub_tasks\\src\\Validators\\Update_Sub_Task' => $baseDir . '/modules/sub_tasks/src/Validators/Update_Sub_Task.php',
    'WeDevs\\PM_Pro\\Modules\\task_recurring\\CreateRecurrentTasks' => $baseDir . '/modules/task_recurring/CreateRecurrentTasks.php',
    'WeDevs\\PM_Pro\\Modules\\task_recurring\\FormatRecurrenceData' => $baseDir . '/modules/task_recurring/FormatRecurrenceData.php',
    'WeDevs\\PM_Pro\\Modules\\time_tracker\\core\\Permissions\\Time_Add' => $baseDir . '/modules/time_tracker/core/Permissions/Time_Add.php',
    'WeDevs\\PM_Pro\\Modules\\time_tracker\\core\\Permissions\\Time_Delete' => $baseDir . '/modules/time_tracker/core/Permissions/Time_Delete.php',
    'WeDevs\\PM_Pro\\Modules\\time_tracker\\core\\Permissions\\Time_Start' => $baseDir . '/modules/time_tracker/core/Permissions/Time_Start.php',
    'WeDevs\\PM_Pro\\Modules\\time_tracker\\core\\Permissions\\Time_Stop' => $baseDir . '/modules/time_tracker/core/Permissions/Time_Stop.php',
    'WeDevs\\PM_Pro\\Modules\\time_tracker\\db\\migrations\\Create_Time_Tracker_Table' => $baseDir . '/modules/time_tracker/db/migrations/create_time_tracker_table.php',
    'WeDevs\\PM_Pro\\Modules\\time_tracker\\libs\\Report_Summary' => $baseDir . '/modules/time_tracker/libs/Report_Summary.php',
    'WeDevs\\PM_Pro\\Modules\\time_tracker\\libs\\Report_Users' => $baseDir . '/modules/time_tracker/libs/Report_Users.php',
    'WeDevs\\PM_Pro\\Modules\\time_tracker\\libs\\Reports' => $baseDir . '/modules/time_tracker/libs/Reports.php',
    'WeDevs\\PM_Pro\\Modules\\time_tracker\\src\\Controllers\\Time_Tracker_Controller' => $baseDir . '/modules/time_tracker/src/Controllers/Time_Tracker_Controller.php',
    'WeDevs\\PM_Pro\\Modules\\time_tracker\\src\\Models\\Time_Tracker' => $baseDir . '/modules/time_tracker/src/Models/Time_Tracker.php',
    'WeDevs\\PM_Pro\\Modules\\time_tracker\\src\\Transformers\\New_Time_Tracker_Transformer' => $baseDir . '/modules/time_tracker/src/Transformers/New_Time_Tracker_Transformer.php',
    'WeDevs\\PM_Pro\\Modules\\time_tracker\\src\\Transformers\\Time_Tracker_Transformer' => $baseDir . '/modules/time_tracker/src/Transformers/Time_Tracker_Transformer.php',
    'WeDevs\\PM_Pro\\Modules\\time_tracker\\src\\Validators\\Time_Tracker_Validator' => $baseDir . '/modules/time_tracker/src/Validators/Time_Tracker_Validator.php',
    'WeDevs\\PM_Pro\\Modules\\woo_project\\src\\Controllers\\Woo_Project_Controller' => $baseDir . '/modules/woo_project/src/Controllers/Woo_Project_Controller.php',
    'WeDevs\\PM_Pro\\Modules\\woo_project\\src\\Transformers\\Product_Transformer' => $baseDir . '/modules/woo_project/src/Transformers/Product_Transformer.php',
    'WeDevs\\PM_Pro\\Reports\\Controllers\\Reports_Controller' => $baseDir . '/src/Reports/Controllers/Reports_Controller.php',
    'WeDevs\\PM_Pro\\Reports\\Transformers\\Project_Transformer' => $baseDir . '/src/Reports/Transformers/Project_Transformer.php',
    'WeDevs\\PM_Pro\\Reports\\Transformers\\Task_Lists_Transformer' => $baseDir . '/src/Reports/Transformers/Task_Lists_Transformer.php',
    'WeDevs\\PM_Pro\\Search\\Controllers\\Search_Controller' => $baseDir . '/src/Search/Controllers/Search_Controller.php',
    'WeDevs\\PM_Pro\\Settings\\Controllers\\Settings_Controller' => $baseDir . '/src/Settings/Controllers/Settings_Controller.php',
    'WeDevs\\PM_Pro\\Update\\Controllers\\Update_Controller' => $baseDir . '/src/Update/Controllers/Update_Controller.php',
);
