<?php
Route::get('/', function () { return redirect('/admin/home'); });

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Change Photo...
$this->get('change_photo', 'Auth\ChangePhotoController@showChangePhotoForm')->name('change_photo');
$this->post('change_photo_submit', 'Auth\ChangePhotoController@changePhoto')->name('change_photo_submit');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'HomeController@index');
    Route::resource('permissions', 'Admin\PermissionsController');
    Route::post('permissions_mass_destroy', ['uses' => 'Admin\PermissionsController@massDestroy', 'as' => 'permissions.mass_destroy']);
    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);
});

// Password Reset Routes...
$this->get('notification/send/index', 'Notification\NotificationController@index')->name('notification.send.index');
$this->post('notification/send/save', 'Notification\NotificationController@save')->name('notification.send.save');
$this->get('notification/overview/index','Notification\NotificationController@overview')->name('notification.overview.index');
$this->get('notification/overview/reminder/{id}','Notification\NotificationController@reminder')->name('notification.overview.reminder');
$this->post('notification/delete','Notification\NotificationController@delete')->name('notification.delete');
$this->get('notification/history','Notification\NotificationController@history')->name('notification.history');
$this->get('notification/acknowledgment','Notification\NotificationController@acknowledgment')->name('notification.acknowledgment');
$this->get('notification/acknowledgment/getmessage','Notification\NotificationController@getcontent')->name('notification.acknowledgment.get');
$this->post('notification/acknowledgment/confirm','Notification\NotificationController@confirm')->name('notification.acknowledgment.confirm');
$this->get('receipt/upload/index','Receipt\ReceiptController@index')->name('receipt.upload.index');
$this->post('receipt/upload/upload','Receipt\ReceiptController@save')->name('receipt.upload.upload');
$this->get('receipt/myreceipt','Receipt\ReceiptController@myreceipt')->name('receipt.myreceipt');
$this->post('receipt/delete','Receipt\ReceiptController@delete')->name('receipt.delete');
$this->get('receipt/fieldreceipt','Receipt\ReceiptController@fieldreceipt')->name('receipt.fieldreceipt');
$this->get('receipt/downfile/{id}','Receipt\ReceiptController@downfile')->name('receipt.downfile');
$this->get('notification/getcount','Notification\NotificationController@getcount')->name('notification.count');
$this->get('receipt/getcount','Receipt\ReceiptController@getcount')->name('receipt.count');

Route::get('sendbasicemail','MailController@basic_email');
Route::get('sendhtmlemail','MailController@html_email');
Route::get('sendattachmentemail','MailController@attachment_email');

Route::get('pdf/{id}', 'NotesController@pdf')->name('notification.pdf');