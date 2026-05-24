<?php

use App\Http\Controllers\AccountAdminController;
use App\Http\Controllers\ActivityTypeController;
use App\Http\Controllers\api\ServiceController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\BusinessAccountController;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\Boxicons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\ManageAccountController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController as ControllersServiceController;
use App\Http\Controllers\ServiceRatingController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Models\BusinessAccount;
use App\Models\City;
use App\Models\Service;
use App\Http\Controllers\api\MessagesController;
use App\Http\Controllers\ConversationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

// Main Page Route
Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');

// layout
Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

// pages
Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');

// cards
Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');

// User Interface
Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

// extended ui
Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');

// icons
Route::get('/icons/boxicons', [Boxicons::class, 'index'])->name('icons-boxicons');

// form elements
Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');

// form layouts
Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');

// tables
Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');


//Route::get('/test', function() {return view('admin.home');})->name('test');
Route::get('/l', function() {return view('admin.login');});
Route::get('/d', function() {return view('admin.addcategory');});

//my Routes
Route::get('/admin/login',[AuthController::class,'showloginpage'])->name('admin.login');
Route::post('/admin/login',[AuthController::class,'login'])->name('login');
Route::middleware(['auth'])->group(function () {
  //logout
  Route::post('/admin/logout',[AuthController::class,'logout'])->name('admin.logout');

  //home
Route::get('/home', [ManageAccountController::class,'home'])->name('admin.home');
//category
Route::get('/categories', [CategoryController::class,'index'])->name('index.category');
Route::get('/addcategory', [CategoryController::class,'view'])->name('view.category')->middleware('permission:add-category');
Route::post('/addcatagory', [CategoryController::class,'store'])->name('add.category')->middleware('permission:add-category');
Route::get('/updatecategory/{category}',[CategoryController::class,'pageeditcategory'])->name('pageeditcategory')->middleware('permission:edit-category');
Route::put('/updatecategory/{category}',[CategoryController::class,'updatecategory'])->name('update.category')->middleware('permission:edit-category');
Route::delete('deletecategory/{category}',[CategoryController::class,'deletecategory'])->name('delete.category')->middleware('permission:delete-category');
Route::get('category_dynamicfields/{id}',[CategoryController::class,'getdynamicfields'])->name('cat.fields');
//subcategory
Route::get('/addcategory/{category}/addsubcategories', [CategoryController::class,'addsubcategory'])->name('view.subcategory');
Route::post('addcategory/{category}/addsubcategories', [CategoryController::class,'storesubcategory'])->name('add.subcategory')->middleware('permission:add-Subcategory');
Route::get('updatesubcategory/{subcategory}',[CategoryController::class,'pageupdatesubcategory'])->name('pageupdatesubcategory')->middleware('permission:edit-Subcategory');
Route::put('updatesubcategory/{subcategory}',[CategoryController::class,'updatesubcategory'])->name('update.subcategory')->middleware('permission:edit-Subcategory');
Route::delete('deletesubcategory/{sub}',[CategoryController::class,'deletesubcategory'])->name('delete.subcategory')->middleware('permission:delete-Subcategory');


//dynamic field
Route::get('/dynamicfileds',[CategoryController::class,'pagedynamicfiled'])->name('dynamicfileds')->middleware('permission:add-dynamicField');
Route::post('/dynamicfileds',[CategoryController::class,'storedynamicfiled'])->name('dynamic-fields.store')->middleware('permission:add-dynamicField');
Route::get('/viewdynamicfields',[CategoryController::class,'viewdynamicfields'])->name('viewdynamicfields');
Route::get('/editdynamicfield/{id}',[CategoryController::class,'vieweditdynamic'])->name('edit.dynamicfields')->middleware('permission:edit-dynamicField');
Route::put('/updatedynamicfield/{id}',[CategoryController::class,'updatedynamicfield'])->name('dynamic-fields.update')->middleware('permission:edit-dynamicField');
Route::delete('/dynamic-fields/{id}', [CategoryController::class, 'destroyfield'])->name('dynamic-fields.destroy')->middleware('permission:delete-dynamicField');


//account
//admin
Route::get('/account', [ManageAccountController::class,'addaccount'])->name('add.account')->middleware('permission:add-admin');
Route::post('/account', [ManageAccountController::class,'store'])->name('store.account')->middleware('permission:add-admin');
Route::get('/viewaccount', [ManageAccountController::class,'viewaccount'])->name('view.account');
Route::get("/editadmin/{admin}",[ManageAccountController::class,'pageeditadmin'])->name('admin.edit')->middleware('permission:edit-admin');
Route::put("/editadmin/{admin}",[ManageAccountController::class,'updateadmin'])->name('admin.update')->middleware('permission:edit-admin');
Route::delete("/deleteadmin/{admin}",[ManageAccountController::class,'deleteadmin'])->name('admin.delete');

//users
Route::get("/adduser",[ManageAccountController::class,'pageaddusers'])->name('add.pagenormalusers');
Route::post("/adduser",[ManageAccountController::class,'addusers'])->name('add.normalusers');
Route::get("/users/search",[ManageAccountController::class,'search'])->name('search');
Route::get("/edituser/{id}",[ManageAccountController::class,'pageedituser'])->name('edit.pagenormalusers');
Route::put("/updateuser/{id}",[ManageAccountController::class ,'updatenormaluser'])->name('update.normalusers');
Route::delete('deleteuser/{id}',[ManageAccountController::class ,'deleteuser'])->name('delete.normalusers');

//business account
 Route::get("/checkaccount",[BusinessAccountController::class,'check'])->name('check');
 Route::get("/viewaccount/{account}",[BusinessAccountController::class,'view'])->name('business.view');
 Route::post("/accept{account}",[BusinessAccountController::class,'accept'])->name('accept')->middleware('permission:accept-businessAccount');
 Route::post("/reject{account}",[BusinessAccountController::class,'reject'])->name('reject')->middleware('permission:reject-businessAccount');
 Route::get("/city/{city}/businessaccount",[BusinessAccountController::class,'businesscity'])->name('business.cities');
Route::delete("/deletebusinessaccout/{id}",[BusinessAccountController::class,'deleteBusiness'])->name('delete.businessaccount');
Route::post('/business/{id}/toggle', [BusinessAccountController::class, 'toggle'])->name('toggle.business.account');
//roles
Route::get('/roles-permissions', [RoleController::class, 'index'])->name('roles.permissions');
Route::get('/addroles-permissions', [RoleController::class, 'addrolepage'])->name('addroles.permissions')->middleware(['permission:add-role']);
Route::post('/addroles-permissions',[RoleController::class,'store'])->name('add.roles')->middleware(['permission:add-role']);
Route::delete('/deleteroles-permissions/{role}',[RoleController::class,'destroy'])->name('delete.roles')->middleware('permission:delete-role');
Route::get('/updateroles-permissions/{role}',[RoleController::class,'updaterole'])->name('show.updateroles')->middleware(['permission:edit-role','permission:assign-RolePermission']);
Route::put('/updateroles-permissions/{role}',[RoleController::class,'update'])->name('update.roles')->middleware(['permission:edit-role','permission:assign-RolePermission']);
Route::get('/viewroles-permissions/{role}',[RoleController::class,'viewuser'])->name('show.userroles');
//cities
Route::get('/viewcities',[BusinessAccountController::class,'viewcities'] )->name('view.cities');
Route::get('/addcity',[BusinessAccountController::class,'addcitypage'])->name('page.addcity')->middleware('permission:add-city');
Route::post('/addcity',[BusinessAccountController::class,'addcity'])->name('store.city')->middleware('permission:add-city');
Route::get('/editcity/{id}',[BusinessAccountController::class,'pageeditcity'])->name('page.editcity');
Route::put('/update/city/{id}',[BusinessAccountController::class,'updatecity'])->name('update.city');

Route::delete('/delete-city/{id}',[BusinessAccountController::class,'deletecity'])->name('delete.city');
//localization
  Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'ar'])) {
        abort(400);
    }

    session(['locale' => $locale]);

    return back();
})->name('lang.switch');



//activitytype
Route::get('/activitytypes',[ActivityTypeController::class,'pageactivitytype'])->name('activitytype.index');
Route::post('/addactivitytype',[ActivityTypeController::class,'store'])->name('activitytype.store');
Route::put('/updateactivitytype/{activity}',[ActivityTypeController::class,'update'])->name('activitytype.update');
Route::delete('/deleteactivitytype/{activity}',[ActivityTypeController::class,'delete'])->name('activitytype.delete');


//services
Route::get('/services',[ControllersServiceController::class,'show'])->name('view.services');
Route::get('/service/{service}',[ControllersServiceController::class,'view'])->name('service');
Route::post("/accept/{service}",[ControllersServiceController::class,'accept'])->name('accept.service');
Route::post("/reject/{service}",[ControllersServiceController::class,'reject'])->name('reject.service');
Route::get("/orders",[ControllersServiceController::class,'indexorder'])->name('view.orders');
Route::delete("/delete-service/{id}",[ControllersServiceController::class,'deleteService'])->name('delete.service');
Route::get('/check-service/{id}', [ControllersServiceController::class, 'checkService']);
//notification
Route::post('/admin/save-token', [NotificationsController::class, 'saveToken']);
Route::get('/admin/notifications', [NotificationsController::class, 'notifications']);
Route::post('/admin/notifications/read/{id}', [NotificationsController::class, 'markAsRead']);
Route::post('/admin/notifications/read-all', [NotificationsController::class, 'markAllAsRead']);
//sliders
Route::get('/sliders', [SliderController::class, 'index'])->name('admin.sliders.index');
Route::get('/sliders/create', [SliderController::class, 'create'])->name('admin.sliders.create')->middleware('permission:media-sliderManagement');
Route::post('/sliders', [SliderController::class, 'store'])->name('admin.sliders.store')->middleware('permission:media-sliderManagement');
Route::delete('/sliders/{id}', [SliderController::class, 'destroy'])
->name('admin.sliders.destroy')->middleware('permission:media-sliderManagement');
Route::get('/slider/{id}/edit',[SliderController::class, 'edit'])->name('sliders.edit')->middleware('permission:media-sliderManagement');
Route::put('/sliders/{id}', [SliderController::class, 'update'])->name('admin.sliders.update')->middleware('permission:media-sliderManagement');
//ratings
Route::get('/ratings', [RatingController::class, 'index'])->name('ratings.index');
 Route::get('/ratings/{id}', [RatingController::class, 'show'])->name('ratings.show');
//services ratings
Route::get('/services-ratings', [ServiceRatingController::class, 'index'])->name('services.ratings.index');
Route::get('/services-ratings/{id}', [ServiceRatingController::class, 'show'])->name('services.ratings.show');
//reports
Route::get('/reports', [ReportController::class, 'index'])
->name('admin.reports.index')->middleware('permission:manage-Reports');

Route::post('/reports/{id}', [ReportController::class, 'update'])
->name('admin.reports.update')->middleware('permission:manage-Reports');
//

//my account
Route::get('/myaccount', [AccountAdminController::class, 'viewmyaccount'])
->name('view.myaccount');
Route::put('/updatemyaccount',[AccountAdminController::class ,'updateadmin'])->name('updatemyaccount');
Route::get('/editmyaccount', [AccountAdminController::class, 'showupdate'])
->name('edit.myaccount');


// Route::get('/chat/{id}', function ($id) {
//   $user=auth()->user();
// return view('admin.chat', [
//     'conversationId' => $id,
//     'token' => session('api_token') // أو تمرير من JS لاحقًا
// ]);});






});



// Route::get('/chat/{conversation}', function ($conversation) {
//   return view('admin.chat', compact('conversation'));
// });
Route::get('/chat/{conversation}/{user}', [ConversationController::class, 'open']);
