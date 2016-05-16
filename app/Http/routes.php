<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Backup features
Route::any('db_back_up', [
    'as' => 'db_back_up',
    'uses' => 'BackupController@db_back_up'
]);


Route::any('test_email_queue_jobs', [
    'as' => 'test_email_queue_jobs',
    'uses' => 'HomeController@test_email_queue_jobs'
]);


Route::any('user-login', [
    'as' => 'user-login',
    'uses' => 'UserController@user_login'
]);
Route::any("login", [
    "as"   => "login",
    "uses" => "UserController@login"
]);

Route::any('user/forgot-password', [
    'as' => 'user.forgot-password',
    'uses' => 'AdminController@forgot_password'
]);

Route::any('user/password_reminder_mail',
    ['as'=>'user.password_reminder_mail',
        'uses'=>'AdminController@user_password_reminder_mail']);

Route::any('user/password_reset_confirm/{reset_password_token}',
    ['as'=>'user/password_reset_confirm',
        'uses'=>'AdminController@user_password_reset_confirm']);

Route::any('user/save-new-password',
    ['as'=>'user/save-new-password',
        'uses'=>'AdminController@save_new_password']);

Route::any('home_reminder_mail', [
    'as' => 'home_reminder_mail',
    'uses' => 'HomeController@home_reminder_mail'
]);


Route::any('user-activation/{remember_token}',
    ['as'=>'user.user-activation',
        'uses'=>'UserController@user_activation']);


Route::any('generate_password/{remember_token}',
    ['as'=>'generate_password',
        'uses'=>'AdminController@generate_password']);

Route::any('user/save_password',
    ['as'=>'user/save_password',
        'uses'=>'AdminController@save_password']);



//user activation for signup...

Route::any('user-confirmation/{remember_token}',
    ['as'=>'user.user-confirmation',
        'uses'=>'UserController@user_confirm']);

Route::any('user-signup/store/{user_id}', [
    'as' => 'user-signup.store',
    'uses' => 'UserController@store'
]);

Route::group(['middleware' => 'auth'], function()
{
/*
 * -------------------  Start CRUD area ------------------------
 */

Route::any('dashboard', [
    'as' => 'dashboard',
    'uses' => 'CrudController@dashboard'
]);
Route::any('crud/index', [
    'as' => 'crud.index',
    'uses' => 'CrudController@index'
]);
Route::any('crud/create', [
    'as' => 'crud.create',
    'uses' => 'CrudController@create'
]);
Route::any('crud/store', [
    'as' => 'crud.store',
    'uses' => 'CrudController@store'
]);
Route::any('crud/show-data/{id}', [
    'as' => 'crud.show.data',
    'uses' => 'CrudController@show'
]);
Route::any('crud/edit/{id}', [
    'as' => 'crud.edit',
    'uses' => 'CrudController@edit'
]);
Route::any('crud/update/{id}', [
    'as' => 'crud.update',
    'uses' => 'CrudController@update'
]);
Route::any('crud/destroy/{id}', [
    'as' => 'crud.destroy',
    'uses' => 'CrudController@destroy'
]);


/*
 *  ------------------- END CRUD area -----------------------
 */

Route::get('/', [
    'as' => 'home', 'uses' => 'HomeController@index'
]);

Route::get('boxed-page', [
    'as' => 'boxed-page', 'uses' => 'HomeController@layout_box_page'
]);

Route::get('horizontal-menu', [
    'as' => 'horizontal-menu', 'uses' => 'HomeController@layout_horizontal_menu'
]);

Route::get('language-switch-bar', [
    'as' => 'language-switch-bar', 'uses' => 'HomeController@layout_language_switch_bar'
]);
//ui-elements...
Route::get('general', [
    'as' => 'general', 'uses' => 'HomeController@elements_general'
]);

Route::get('buttons', [
    'as' => 'buttons', 'uses' => 'HomeController@elements_buttons'
]);

Route::get('widget', [
    'as' => 'widget', 'uses' => 'HomeController@elements_widget'
]);

Route::get('slider', [
    'as' => 'slider', 'uses' => 'HomeController@elements_slider'
]);

Route::get('nestable', [
    'as' => 'nestable', 'uses' => 'HomeController@elements_nestable'
]);

Route::get('font-awesome', [
    'as' => 'font-awesome', 'uses' => 'HomeController@elements_font_awesome'
]);

//component........
Route::get('grids', [
    'as' => 'grids', 'uses' => 'HomeController@component_grid'
]);

Route::get('calender', [
    'as' => 'calender', 'uses' => 'HomeController@component_calender'
]);

Route::get('gallery', [
    'as' => 'gallery', 'uses' => 'HomeController@component_gallery'
]);

Route::get('todo-list', [
    'as' => 'todo-list', 'uses' => 'HomeController@component_todo_list'
]);
//form-stuff..
Route::get('advanced-components', [
    'as' => 'advanced-components', 'uses' => 'HomeController@stuff_adv_components'
]);

Route::get('dropzone-file-upload', [
    'as' => 'dropzone-file-upload', 'uses' => 'HomeController@stuff_dropzone_file_upload'
]);
Route::get('form-components', [
    'as' => 'form-components', 'uses' => 'HomeController@stuff_form_components'
]);
Route::get('form-validation', [
    'as' => 'form-validation', 'uses' => 'HomeController@stuff_form_validation'
]);
Route::get('form-wizard', [
    'as' => 'form-wizard', 'uses' => 'HomeController@stuff_form_wizard'
]);
Route::get('image-cropping', [
    'as' => 'image-cropping', 'uses' => 'HomeController@stuff_image_cropping'
]);
Route::get('inline-editor', [
    'as' => 'inline-editor', 'uses' => 'HomeController@stuff_inline_editor'
]);
//data-tables..
Route::get('basic-table', [
    'as' => 'basic-table', 'uses' => 'HomeController@data_tables_basic'
]);
Route::get('responsive-table', [
    'as' => 'responsive-table', 'uses' => 'HomeController@data_tables_responsive'
]);
Route::get('dynamic-table', [
    'as' => 'dynamic-table', 'uses' => 'HomeController@data_tables_dynamic'
]);
Route::get('advanced-table', [
    'as' => 'advanced-table', 'uses' => 'HomeController@data_tables_adv'
]);
Route::get('editable-table', [
    'as' => 'editable-table', 'uses' => 'HomeController@data_tables_editable'
]);

//mail...
Route::get('mail', [
    'as' => 'mail', 'uses' => 'HomeController@mail'
]);

//charts...
Route::get('chartjs', [
    'as' => 'chartjs', 'uses' => 'HomeController@chart_js'
]);
Route::get('flot-charts', [
    'as' => 'flot-charts', 'uses' => 'HomeController@chart_flot'
]);
Route::get('morris', [
    'as' => 'morris', 'uses' => 'HomeController@chart_morris'
]);
Route::get('x-chart', [
    'as' => 'x-chart', 'uses' => 'HomeController@chart_x'
]);

//shop...
Route::get('list-view', [
    'as' => 'list-view', 'uses' => 'HomeController@shop_list_view'
]);
Route::get('details-view', [
    'as' => 'details-view', 'uses' => 'HomeController@shop_details_view'
]);

//google_map....
Route::get('google-map', [
    'as' => 'google-map', 'uses' => 'HomeController@google_map'
]);

//extra...
Route::get('404-error', [
    'as' => '404-error', 'uses' => 'HomeController@extra_404_error'
]);
Route::get('500-error', [
    'as' => '500-error', 'uses' => 'HomeController@extra_500_error'
]);
Route::get('blank-page', [
    'as' => 'blank-page', 'uses' => 'HomeController@extra_blank_page'
]);
Route::get('invoice', [
    'as' => 'invoice', 'uses' => 'HomeController@extra_invoice'
]);
Route::get('lock-screen', [
    'as' => 'lock-screen', 'uses' => 'HomeController@extra_lock_screen'
]);
Route::get('profile', [
    'as' => 'profile', 'uses' => 'HomeController@extra_profile'
]);
Route::get('search-result', [
    'as' => 'search-result', 'uses' => 'HomeController@extra_search_result'
]);

//login...
Route::get('login', [
    'as' => 'login', 'uses' => 'HomeController@login'
]);

////multilevel-menu....
Route::get('menu-item-1', [
    'as' => 'menu-item-1', 'uses' => 'HomeController@menu_item_1'
]);
Route::get('menu-item-2', [
    'as' => 'menu-item-2', 'uses' => 'HomeController@menu_item_2'
]);





/*
 *  Social API
 *
 */

Route::any("api/", [
    "as"   => "api",
    "uses" => "GApiController@index"
]);


Route::any("api/gauth/{auth?}", [
    "as"   => "api.google.auth",
    "uses" => "GApiController@google_login"
]);


Route::any("api/google/logout", [
    "as"   => "api.google.logout",
    "uses" => "GApiController@google_logout"
]);


Route::any("api/fauth/{auth?}", [
    "as"   => "api.facebook.logout",
    "uses" => "FacebookApiController@facebook_login"
]);



/*
 *  Form Validation
 *
 */

Route::any("form-validation", [
    "as"   => "form.validation",
    "uses" => "HomeController@form_validation"
]);

Route::any("advanced-form", [
    "as"   => "advanced.form",
    "uses" => "HomeController@new_advanced_form"
]);

Route::any("modal-form", [
    "as"   => "modal.form",
    "uses" => "HomeController@modal_form"
]);



/*
 * Auth controller in Http/EmailQueueController
 *
 */

Route::get('auth/google', 'EmailQueueController@redirectToProvider');
Route::get('auth/google/callback', 'EmailQueueController@handleProviderCallback');
Route::get('auth/google/msg', 'EmailQueueController@listMessages');


// Popped Messages
Route::any("popped-message", [
    "as"   => "popped.message",
    "uses" => "PoppedMessageController@index"
]);


// Popped Messages
Route::any("mail-queue", [
    "as"   => "mail.queue",
    "uses" => "EmailQueueController@mail_queue"
]);

Route::any("email-queue-process", [
    "as"   => "email.queue.process",
    "uses" => "EmailQueueController@email_queue_process"
]);


Route::any("sendReminderEmail", [
    "as"   => "sendReminderEmail",
    "uses" => "EmailQueueController@sendReminderEmail"
]);




// Imap Messages
Route::any("imap_email", [
    "as"   => "imap_email",
    "uses" => "EmailQueueController@imap_email"
]);

Route::any("reply_email/{id}", [
    "as"   => "reply_email",
    "uses" => "EmailQueueController@reply_email"
]);

Route::any("mail_queue_reply/{id}", [
    "as"   => "mail_queue_reply",
    "uses" => "EmailQueueController@mail_queue_reply"
]);


Route::any("bulk_mail_queue_reply", [
    "as"   => "bulk_mail_queue_reply",
    "uses" => "EmailQueueController@bulk_mail_queue_reply"
]);



    /*
     *
     * Campaign Stat
     */

Route::any("active-change-stat/{id}", [
    "as"   => "active.change.stat",
    "uses" => "CampaignController@change_stat_active"
]);

Route::any("inactive-change-stat/{id}", [
    "as"   => "inactive.change.stat",
    "uses" => "CampaignController@change_stat_inactive"
]);


Route::any("check_keyword_exists", [
    "as"   => "check_keyword_exists",
    "uses" => "HomeController@check_keyword_exists"
]);

Route::any("mail_thread", [
    "as"   => "mail_thread",
    "uses" => "EmailQueueController@mail_thread"
]);

Route::any("mail_detail/{id}", [
    "as"   => "mail_detail",
    "uses" => "EmailQueueController@mail_detail"
]);

Route::any("reset_count_mails", [
    "as"   => "reset_count_mails",
    "uses" => "EmailQueueController@reset_count_mails"
]);

Route::any("string_replace", [
    "as"   => "string_replace",
    "uses" => "EmailQueueController@string_replace"
]);


Route::any("send_custom_msg", [
    "as"   => "send_custom_msg",
    "uses" => "EmailQueueController@send_custom_msg"
]);


Route::any("settings", [
    "as"   => "settings",
    "uses" => "HomeController@settings"
]);

Route::any("test_ldap", [
    "as"   => "test_ldap",
    "uses" => "HomeController@test_ldap"
]);



//ToDo :: Home Dashboard

Route::any("home-dashboard", [
    "as"   => "home-dashboard",
    "uses" => "HomeController@home_dashboard"
]);


Route::any("google_login_api", [
    "as"   => "google_login_api",
    "uses" => "HomeController@google_login_api"
]);

Route::any("test_gmail_api", [
    "as"   => "test_gmail_api",
    "uses" => "HomeController@test_gmail_api"
]);
Route::any("api/api_test_gmail_api", [
    "as"   => "api/api_test_gmail_api",
    "uses" => "HomeController@api_test_gmail_api"
]);


Route::any("providerLogin", [
    "as"   => "providerLogin",
    "uses" => "HomeController@providerLogin"
]);



Route::any("boot_fun", [
    "as"   => "boot_fun",
    "uses" => "HomeController@boot_fun"
]);

Route::any("boot_fun/callback", [
    "as"   => "boot_fun/callback",
    "uses" => "HomeController@boot_fun_callback"
]);





// imap routes --------------------------------------
    Route::any('imap/index', [
        'as' => 'imap.index',
        'uses' => 'ImapController@index'
    ]);
    Route::any('imap/create', [
        'as' => 'imap.create',
        'uses' => 'ImapController@create'
    ]);
    Route::any('imap/store', [
        'as' => 'imap.store',
        'uses' => 'ImapController@store'
    ]);
    Route::any('imap/show-data/{id}', [
        'as' => 'imap.show.data',
        'uses' => 'ImapController@show'
    ]);
    Route::any('imap/edit/{id}', [
        'as' => 'imap.edit',
        'uses' => 'ImapController@edit'
    ]);
    Route::any('imap/update/{id}', [
        'as' => 'imap.update',
        'uses' => 'ImapController@update'
    ]);
    Route::any('imap/destroy/{id}', [
        'as' => 'imap.destroy',
        'uses' => 'ImapController@destroy'
    ]);


// message routes --------------------------------------
    Route::any('message/index/{campaign_id}', [
        'as' => 'message.index',
        'uses' => 'MessageController@index'
    ]);
    Route::any('message/create', [
        'as' => 'message.create',
        'uses' => 'MessageController@create'
    ]);
    Route::any('message/store', [
        'as' => 'message.store',
        'uses' => 'MessageController@store'
    ]);
    Route::any('message/show-data/{id}', [
        'as' => 'message.show.data',
        'uses' => 'MessageController@show'
    ]);
    Route::any('message/edit/{id}', [
        'as' => 'message.edit',
        'uses' => 'MessageController@edit'
    ]);
    Route::any('message/update/{id}', [
        'as' => 'message.update',
        'uses' => 'MessageController@update'
    ]);
    Route::any('message/destroy/{id}', [
        'as' => 'message.destroy',
        'uses' => 'MessageController@destroy'
    ]);


// Sub message routes --------------------------------------
    Route::any('sub-message/index/{message_id}/{campaign_id}', [
        'as' => 'sub-message.index',
        'uses' => 'SubMessageController@index'
    ]);
    Route::any('sub-message/create', [
        'as' => 'sub-message.create',
        'uses' => 'SubMessageController@create'
    ]);
    Route::any('sub-message/add-index/{message_id}/{campaign_id}', [
        'as' => 'sub-message.add-index',
        'uses' => 'SubMessageController@add_index'
    ]);
    Route::any('sub-message/store', [
        'as' => 'sub-message.store',
        'uses' => 'SubMessageController@store'
    ]);
    Route::any('sub-message/show-data/{id}', [
        'as' => 'sub-message.show.data',
        'uses' => 'SubMessageController@show'
    ]);

    Route::any('sub-message/image-show/{id}', [
        'as' => 'sub-message.image.show',
        'uses' => 'SubMessageController@image_show'
    ]);

    Route::any('sub-message/edit/{id}', [
        'as' => 'sub-message.edit',
        'uses' => 'SubMessageController@edit'
    ]);
    Route::any('sub-message/update/{id}', [
        'as' => 'sub-message.update',
        'uses' => 'SubMessageController@update'
    ]);
    Route::any('sub-message/destroy/{id}', [
        'as' => 'sub-message.destroy',
        'uses' => 'SubMessageController@destroy'
    ]);
    Route::any('attachment/destroy-file/{id}', [
        'as' => 'attachment.destroy.file',
        'uses' => 'SubMessageController@destroy_file'
    ]);

// Send email with delay time --------------------------------------
    Route::any('send-email/with-delay', [
        'as' => 'send.email.with.delay',
        'uses' => 'HomeController@send_email_with_delay'
    ]);

// Generate email in cpanel --------------------------------------
    Route::any('generate-email', [
        'as' => 'generate.email',
        'uses' => 'SenderEmailController@generate_email'
    ]);

// Delete email account using cpanel --------------------------------------
    Route::any('delete-email-cpanel/{email}/{id}/{campaign_id}', [
        'as' => 'delete.email.cpanel',
        'uses' => 'SenderEmailController@delete_email_cpanel'
    ]);

// bulk email using upload csv file --------------------------------------
    Route::any('bulk-email', [
        'as' => 'bulk.email',
        'uses' => 'SenderEmailController@bulk_email'
    ]);


    // SET Max Sender Email --------------------------------------
    Route::any('set_max_email_send', [
        'as' => 'set_max_email_send',
        'uses' => 'SenderEmailController@set_max_email_send'
    ]);

//google api socialite for authentication popping email--------------------------------

    Route::any('auth/googleac', [
        'as' => 'auth.googleac',
        'uses' => 'GoogleApiController@index'
    ]);

    Route::get('auth/google/app', 'GoogleApiController@redirectToProvider');

    Route::get('auth/google/callback/app', 'GoogleApiController@handleProviderCallback');

//dashboard ------------------------------------------

    Route::any("dashboard-new", [
        "as"   => "dashboard-new",
        "uses" => "DashboardController@home_dashboard"
    ]);


//gmail authentication with google API------------------------------------------------

    Route::any("google-api-auth-store", [
        "as"   => "google-api-auth-store",
        "uses" => "PoppingEmailController@google_api_auth_store"
    ]);
    Route::any("google-api-auth-store/callback", [
        "as"   => "google-api-auth-store-callback",
        "uses" => "PoppingEmailController@boot_fun_callback"
    ]);


    /*
     * -------------------  Start SMTP area ------------------------
     */

    Route::any('smtp/index', [
        'as' => 'smtp.index',
        'uses' => 'SmtpController@index'
    ]);


    Route::any('smtp/create', [
        'as' => 'smtp.create',
        'uses' => 'SmtpController@create'
    ]);


    Route::any('smtp/store', [
        'as' => 'smtp.store',
        'uses' => 'SmtpController@store'
    ]);


    Route::any('smtp/show-data/{id}', [
        'as' => 'smtp.show.data',
        'uses' => 'SmtpController@show'
    ]);

    Route::any('smtp/edit/{id}', [
        'as' => 'smtp.edit',
        'uses' => 'SmtpController@edit'
    ]);

    Route::any('smtp/update/{id}', [
        'as' => 'smtp.update',
        'uses' => 'SmtpController@update'
    ]);

    Route::any('smtp/destroy/{id}', [
        'as' => 'smtp.destroy',
        'uses' => 'SmtpController@destroy'
    ]);

    /*
    *  ------------------- END SMTP area -----------------------
     */




    /*
    * -------------------  Start Token area ------------------------
     */

    Route::any('token/index', [
        'as' => 'token.index',
        'uses' => 'TokenController@index'
    ]);


    Route::any('token/create', [
        'as' => 'token.create',
        'uses' => 'TokenController@create'
    ]);


    Route::any('token/store', [
        'as' => 'token.store',
        'uses' => 'TokenController@store'
    ]);


    Route::any('token/show-data/{id}', [
        'as' => 'token.show.data',
        'uses' => 'TokenController@show'
    ]);

    Route::any('token/edit/{id}', [
        'as' => 'token.edit',
        'uses' => 'TokenController@edit'
    ]);

    Route::any('token/update/{id}', [
        'as' => 'token.update',
        'uses' => 'TokenController@update'
    ]);

    Route::any('token/destroy/{id}', [
        'as' => 'token.destroy',
        'uses' => 'TokenController@destroy'
    ]);

    /*
    *  ------------------- END Token area -----------------------
     */




    /*
    * -------------------  Start Filter area ------------------------
     */

    Route::any('filter/index', [
        'as' => 'filter.index',
        'uses' => 'FilterController@index'
    ]);


    Route::any('filter/store', [
        'as' => 'filter.store',
        'uses' => 'FilterController@store'
    ]);


    Route::any('filter/show-data/{id}', [
        'as' => 'filter.show.data',
        'uses' => 'FilterController@show'
    ]);

    Route::any('filter/edit/{id}', [
        'as' => 'filter.edit',
        'uses' => 'FilterController@edit'
    ]);

    Route::any('filter/update/{id}', [
        'as' => 'filter.update',
        'uses' => 'FilterController@update'
    ]);

    Route::any('filter/destroy/{id}', [
        'as' => 'filter.destroy',
        'uses' => 'FilterController@destroy'
    ]);

    /*
    *  ------------------- END Filter area -----------------------
     */


    /*
    * -------------------  Start Sender_Email area ------------------------
     */


    //Api for sender email // store to db only
    Route::any("se_boot", [
        "as"   => "se_boot",
        "uses" => "SenderEmailController@se_boot"
    ]);

    Route::any("se_boot/callback", [
        "as"   => "se_boot/callback",
        "uses" => "SenderEmailController@se_boot_callback"
    ]);

    //test send message
    Route::any("test_send_message", [
        "as"   => "test_send_message",
        "uses" => "SenderEmailController@test_send_message"
    ]);



    //sender email
    Route::any('sender-email/index/{id}', [
        'as' => 'sender-email.index',
        'uses' => 'SenderEmailController@index'
    ]);
    Route::any('sender-email/store', [
        'as' => 'sender-email.store',
        'uses' => 'SenderEmailController@store'
    ]);
    Route::any('sender-email/show-data/{id}', [
        'as' => 'sender-email.show.data',
        'uses' => 'SenderEmailController@show'
    ]);
    Route::any('sender-email/edit/{id}', [
        'as' => 'sender-email.edit',
        'uses' => 'SenderEmailController@edit'
    ]);
    Route::any('sender-email/update/{id}', [
        'as' => 'sender-email.update',
        'uses' => 'SenderEmailController@update'
    ]);
    Route::any('sender-email/destroy/{id}', [
        'as' => 'sender-email.destroy',
        'uses' => 'SenderEmailController@destroy'
    ]);


    Route::any('check-email-status/{id}', [
        'as' => 'check-email-status',
        'uses' => 'SenderEmailController@check_email_status'
    ]);


    /*
    *  ------------------- END Sender_Email area -----------------------
     */




    /*
    * -------------------  Start Sender_User area ------------------------
     */


    Route::any('sender-email/create-user', [
        'as' => 'sender-email.create-user',
        'uses' => 'SenderEmailController@create_user'
    ]);

    /*
    *  ------------------- END Sender_User area -----------------------
     */


    /*
    * -------------------  Start Poping_Email area ------------------------
     */

    Route::any('popping-email/index', [
        'as' => 'popping_email.index',
        'uses' => 'PoppingEmailController@index'
    ]);
    Route::any('popping-email/store', [
        'as' => 'popping_email.store',
        'uses' => 'PoppingEmailController@store'
    ]);
    Route::any('popping-email/show-data/{id}', [
        'as' => 'popping_email.show.data',
        'uses' => 'PoppingEmailController@show'
    ]);
    Route::any('popping-email/edit/{id}', [
        'as' => 'popping_email.edit',
        'uses' => 'PoppingEmailController@edit'
    ]);
    Route::any('popping-email/update/{id}', [
        'as' => 'popping_email.update',
        'uses' => 'PoppingEmailController@update'
    ]);
    Route::any('popping-email/destroy/{id}', [
        'as' => 'popping_email.destroy',
        'uses' => 'PoppingEmailController@destroy'
    ]);

    /*
    *  ------------------- END Poping_Email area -----------------------
     */


    /*
    * -------------------  Auto Mail Send Area ------------------------
     */

    Route::any('mail/auto-mail', [
        'as' => 'mail.automail',
        'uses' => 'QueueMailController@send_email_queue'
    ]);

    /*
    * -------------------  User Profile Area Start------------------------
     */

    Route::any("user/profile-info", [
        "as"   => "user.profile-info",
        "uses" => "UserController@profile"
    ]);


    Route::any('user-signup/update/{id}', [
        'as' => 'user-signup.update',
        'uses' => 'UserController@updateProfile'
    ]);

    Route::any('user-signup/reset_password/{id}',
        ['as'=>'user-signup.reset_password',
            'uses'=>'UserController@password_change_view']);

    Route::any('user-signup/update_password/{id}', [
        'as' => 'user-signup.update_password',
        'uses' => 'UserController@update_passwd'
    ]);

    /*
    * -------------------  User Profile Area End ------------------------
     */


    /*
    * -------------------  User List Area Start------------------------
     */

    Route::any('user/inactive/{id}', [
        'as' => 'user.inactive',
        'uses' => 'UserController@status_inactive'
    ]);

    Route::any('user/active/{id}', [
        'as' => 'user.active',
        'uses' => 'UserController@status_active'
    ]);


    Route::any('user/status_active_mail/{remember_token}',
        ['as'=>'user/status_active_mail',
            'uses'=>'UserController@active_user_login']);

    /*
    * -------------------  User List Area End------------------------
     */

    /*
    * -------------------  Clean System Start------------------------
     */

    Route::any('system-clean/system-wise', [
        'as' => 'system-clean.system-wise',
        'uses' => 'CleanSystemController@system_wise_clean'
    ]);

    Route::any('system-clean/system-wise-delete', [
        'as' => 'system-clean.system-wise-delete',
        'uses' => 'CleanSystemController@system_wise_delete'
    ]);

    Route::any('system-clean/sender-mail-delete', [
        'as' => 'system-clean.sender-mail-delete',
        'uses' => 'CleanSystemController@system_wise_sender_mail_delete'
    ]);

    Route::any('combing-clean', [
        'as' => 'combing-clean',
        'uses' => 'CleanSystemController@combing_clean'
    ]);

    Route::any('combing-clean-level2', [
        'as' => 'combing-clean-level2',
        'uses' => 'CleanSystemController@combing_clean_level2'
    ]);

    /*
    * -------------------  Clean System End------------------------
     */

    /*
    * -------------------  Read Sender Emsil-----------------------
     */


    Route::any('sender-emial/sender-email-checking/{id}', [
        'as' => 'sender-email.check-sender-email',
        'uses' => 'SenderEmailController@check_sender_email'
    ]);

    /*
    * -------------------  Mail Thread-----------------------
     */

    Route::any('mail-thread/destroy/{id}', [
        'as' => 'mail-thread.destroy',
        'uses' => 'EmailThreadController@destroy'
    ]);


    Route::any('mail-thread/all-destroy', [
        'as' => 'mail-thread.all-destroy',
        'uses' => 'EmailThreadController@all_destroy'
    ]);

    Route::any('mail-thread/inactive-list', [
        'as' => 'mail-thread.inactive-list',
        'uses' => 'EmailThreadController@inactive_list'
    ]);


    Route::any('mail-thread/active/{id}', [
        'as' => 'mail-thread.active',
        'uses' => 'EmailThreadController@active'
    ]);

    Route::any('mail-thread/all-active', [
        'as' => 'mail-thread.all-active',
        'uses' => 'EmailThreadController@all_active'
    ]);

//Campaign...



    Route::any('user/dashboard', [
        'as' => 'user.dashboard',
        'uses' => 'UserController@user_dashboard'
    ]);

    Route::any('campaign/index', [
        'as' => 'campaign.index',
        'uses' => 'CampaignController@index'
    ]);


    Route::any('campaign/store', [
        'as' => 'campaign.store',
        'uses' => 'CampaignController@store'
    ]);
    Route::any('campaign/show-data/{id}', [
        'as' => 'campaign.show.data',
        'uses' => 'CampaignController@show'
    ]);
    Route::any('campaign/edit/{id}', [
        'as' => 'campaign.edit',
        'uses' => 'CampaignController@edit'
    ]);
    Route::any('campaign/update/{id}', [
        'as' => 'campaign.update',
        'uses' => 'CampaignController@update'
    ]);
    Route::any('campaign/destroy/{id}', [
        'as' => 'campaign.destroy',
        'uses' => 'CampaignController@destroy'
    ]);

    //message-followup...
    Route::any('message-followup/index/{campaign_id}', [
        'as' => 'message-followup.index',
        'uses' => 'MessageFollowupController@index'
    ]);
    Route::any('message-followup/store', [
        'as' => 'message-followup.store',
        'uses' => 'MessageFollowupController@store'
    ]);
    Route::any('message-followup/show-data/{id}', [
        'as' => 'message-followup.show.data',
        'uses' => 'MessageFollowupController@show'
    ]);
    Route::any('message-followup/image-show/{id}', [
        'as' => 'message-followup.image.show',
        'uses' => 'MessageFollowupController@image_show'
    ]);
    Route::any('message-followup/edit/{id}', [
        'as' => 'message-followup.edit',
        'uses' => 'MessageFollowupController@edit'
    ]);
    Route::any('message-followup/update/{id}', [
        'as' => 'message-followup.update',
        'uses' => 'MessageFollowupController@update'
    ]);
    Route::any('message-followup/destroy/{id}', [
        'as' => 'message-followup.destroy',
        'uses' => 'MessageFollowupController@destroy'
    ]);
    Route::any('message-followup/destroy-file/{id}', [
        'as' => 'message-followup.destroy-file',
        'uses' => 'MessageFollowupController@destroy_file'
    ]);

    //sub-message-followup....
    Route::any('sub-message-followup/index/{campaign_id}/{message_followup_id}', [
        'as' => 'sub-message-followup.index',
        'uses' => 'SubMessageFollowupController@index'
    ]);
    Route::any('sub-message-followup/add-index/{campaign_id}/{message_followup_id}', [
        'as' => 'sub-message-followup.add-index',
        'uses' => 'SubMessageFollowupController@add_index'
    ]);
    Route::any('sub-message-followup/store', [
        'as' => 'sub-message-followup.store',
        'uses' => 'SubMessageFollowupController@store'
    ]);
    Route::any('sub-message-followup/show-data/{id}', [
        'as' => 'sub-message-followup.show.data',
        'uses' => 'SubMessageFollowupController@show'
    ]);
    Route::any('sub-message-followup/image-show/{id}', [
        'as' => 'sub-message-followup.image.show',
        'uses' => 'SubMessageFollowupController@image_show'
    ]);
    Route::any('sub-message-followup/edit/{id}', [
        'as' => 'sub-message-followup.edit',
        'uses' => 'SubMessageFollowupController@edit'
    ]);
    Route::any('sub-message-followup/update/{id}', [
        'as' => 'sub-message-followup.update',
        'uses' => 'SubMessageFollowupController@update'
    ]);
    Route::any('sub-message-followup/destroy/{id}', [
        'as' => 'sub-message-followup.destroy',
        'uses' => 'SubMessageFollowupController@destroy'
    ]);
    Route::any('sub-message-followup/destroy-file/{id}', [
        'as' => 'sub-message-followup.destroy.file',
        'uses' => 'SubMessageFollowupController@destroy_file'
    ]);

    /** User Controller **/
    Route::any('user/request', [
        'as' => 'user.request',
        'uses' => 'UserController@request'
    ]);

    Route::any('user/send-request', [
        'as' => 'user.send-request',
        'uses' => 'UserController@user_request_mail'
    ]);

    /*Route::any('user-confirmation/{remember_token}',
        ['as'=>'user.user-confirmation',
            'uses'=>'UserController@user_confirm']);

    Route::any('user-signup/store/{user_id}', [
        'as' => 'user-signup.store',
        'uses' => 'UserController@store'
    ]);



    Route::any('user-activation/{remember_token}',
        ['as'=>'user.user-activation',
            'uses'=>'UserController@user_activation']);*/

    Route::any('user/logout', [
        'as' => 'user.logout',
        'uses' => 'UserController@logout'
    ]);

// User List...
    Route::any('user/user-list', [
        'as' => 'user.user-list',
        'uses' => 'AdminController@user_list'
    ]);

    Route::any('user/create/{id}', [
        'as' => 'user.create',
        'uses' => 'AdminController@create'
    ]);

    Route::any('user/store/{id}', [
        'as' => 'user.store',
        'uses' => 'AdminController@store'
    ]);


    Route::any('user/show-data/{id}', [
        'as' => 'user.show.data',
        'uses' => 'AdminController@show'
    ]);

    Route::any('user/edit/{id}', [
        'as' => 'user.edit',
        'uses' => 'AdminController@edit'
    ]);

    Route::any('user/update/{id}', [
        'as' => 'user.update',
        'uses' => 'AdminController@update'
    ]);

    Route::any('user/destroy/{id}', [
        'as' => 'user.destroy',
        'uses' => 'AdminController@destroy'
    ]);


    Route::any('create/new-user',
        ['as'=>'create.new-user',
            'uses'=>'AdminController@create_new_user']);

//Clean System......

    Route::any('clean-system',
        ['as'=>'clean-system',
            'uses'=>'CleanSystemController@clean_system_per_campaign']);

    Route::any('clean-system/per-campaign/delete',
        ['as'=>'clean-system.per-campaign.delete',
            'uses'=>'CleanSystemController@delete_customer_mail_per_camp']);

    Route::any('clean-system/delete/mail-server',
        ['as'=>'clean-system.delete.mail-server',
            'uses'=>'CleanSystemController@delete_mail_server_per_camp']);

//Central Settings...

    Route::any('central-settings',
        ['as'=>'central-settings',
            'uses'=>'CentralSettingsController@central_settings']);

    Route::any('central-settings/edit/{id}', [
        'as' => 'central-settings.edit',
        'uses' => 'CentralSettingsController@edit'
    ]);
    Route::any('central-settings/update/{id}', [
        'as' => 'central-settings.update',
        'uses' => 'CentralSettingsController@update'
    ]);

    Route::any('central-settings/show/{id}', [
        'as' => 'central-settings.show',
        'uses' => 'CentralSettingsController@show'
    ]);
    /* Public Domain*/

    Route::any('public_domain', [
        'as' => 'public_domain.index',
        'uses' => 'PublicDomainController@index'
    ]);


    Route::any('public_domain/store', [
        'as' => 'public_domain.store',
        'uses' => 'PublicDomainController@store'
    ]);

    Route::any('public_domain/show/{id}', [
        'as' => 'public_domain.show',
        'uses' => 'PublicDomainController@show'
    ]);

    Route::any('public_domain/edit/{id}', [
        'as' => 'public_domain.edit',
        'uses' => 'PublicDomainController@edit'
    ]);

    Route::any('public_domain/update/{id}', [
        'as' => 'public_domain.update',
        'uses' => 'PublicDomainController@update'
    ]);

    Route::any('public_domain/destroy/{id}', [
        'as' => 'public_domain.destroy',
        'uses' => 'PublicDomainController@destroy'
    ]);


    Route::any('email-filter', [
        'as' => 'email-filter',
        'uses' => 'EmailQueueController@email_filt'
    ]);

    Route::any("followup-mail-queue", [
        "as"   => "followup-mail-queue",
        "uses" => "EmailQueueController@mail_queue_followup"
    ]);

    Route::any('test-dashboard', [
        'as' => 'test-dashboard',
        'uses' => 'DashboardController@home_dashboard'
    ]);


    Route::any('sender-email/inactive-email/{id}', [
        'as' => 'sender-email/inactive-email',
        'uses' => 'SenderEmailController@inactive_emails'
    ]);

    Route::any('sender-email/batch-delete', [
        'as' => 'sender-email/batch-delete',
        'uses' => 'SenderEmailController@batch_delete'
    ]);

    //Failed Email

    Route::any('failed-mail/index', [
        'as' => 'failed-mail/index',
        'uses' => 'SendMailFailedController@index'
    ]);

    Route::any('failed-mail/single-send/{id}', [
        'as' => 'failed-mail/single-send',
        'uses' => 'SendMailFailedController@single_send'
    ]);

    Route::any('failed-mail/destroy/{id}', [
        'as' => 'failed-mail/destroy',
        'uses' => 'SendMailFailedController@destroy'
    ]);

    Route::any('failed-mail/batch-delete', [
        'as' => 'failed-mail/batch-delete',
        'uses' => 'SendMailFailedController@batch_delete'
    ]);

    Route::any('failed-mail/batch-send', [
        'as' => 'failed-mail/batch-send',
        'uses' => 'SendMailFailedController@batch_send'
    ]);


    //Email Attachment
    Route::any('email_attachment', [
        'as' => 'email_attachment',
        'uses' => 'HomeController@email_attachment'
    ]);


});