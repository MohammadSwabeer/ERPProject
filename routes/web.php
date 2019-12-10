<?php

// Route::get('/', function () {
//     return view('welcome');
// });
Auth::routes();	
// Route::get('/home', 'HomeController@index')->name('home');
// *************************************** Login Middleware Group ************************************************//
Route::group(['middleware' => 'login.mid'],function(){
	Route::get('/', function () { return view('admin.login'); })->name('welcome');
	Route::get('adminLog','Admin\LoginController@loginForm')->name('admin.login'); 
	Route::post('adminLog','Admin\LoginController@login');                       
	Route::post('admin-password/email','Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
	Route::post('admin-password/reset','Admin\ResetPasswordController@reset')->name('admin.password.update'); 
	Route::get('admin-password/reset','Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
	Route::get('admin-password/reset/{token}','Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
});

Route::post('adminlogout','Admin\LoginController@logout')->name('admin-logout');  
// ****************************************** End Login Middleware Group ******************************************//

// ****************************************** Admin Middleware Group **********************************************//
Route::group(['middleware' => 'admin.mid'], function(){
	// ************************AdminController  Get Group *******************************************//
	Route::get('admin/index','Admin\AdminController@index')->name('admin-home');
	Route::get('admin/register','Admin\RegisterController@showRegistrationForm')->name('register_user');
	// ************************End AdminController Group *******************************************//

	// ************************************** RoleController Group *********************************//
	Route::get('role_page','Admin\RoleController@role')->name('role_page');
	// ************************************** End RoleController Group *****************************//

	// ************************************** ProjectsController Group *****************************//
	Route::get('/projectPage', 'Admin\Projects\FamiliesController@index')->name('projectPage');
	// ************************************** End ProjectsController Group *************************//

	//********************************** FamiliesController(All) routes ****************************//
	// Route::resource('Families','Admin\Projects\FamiliesController');

	Route::get('viewFamiliesPage/{type}/{pCat}/{page}/{status}/{personCat}','Admin\Projects\FamiliesController@similarFamiliesInfo')->name('viewFamiliesPage');

	// Previuos this is HSCC Family view page Route::get('HSCCFamilyPage/{type}','Admin\Projects\FamiliesController@HSCCFamilyIndex')->name('HSCCFamilyPage');
	// Route::get('FamiliesAdd','FamiliesController@create')->name('FamiliesAdd');

	Route::get('HSCCFamiliesAdd/{type}/{pCat}/{page}/{status}/{personCat}/{role}','Admin\Projects\FamiliesController@create')->name('HSCCFamiliesAdd');

	// Route::get('showHSCCFamilyDetails/{hfid}','Admin\Projects\FamiliesController@showHSCCFamilyDetails')->name('showHSCCFamilyDetails');

	Route::get('showFamiliesProfiles/{id}/{hfid}/{type}/{pCat}/{page}/{status}/{personCat}','Admin\Projects\FamiliesController@showFamiliesProfiles')->name('showFamiliesProfiles');

	Route::post('updateHSCCFamilyDetails','Admin\Projects\FamiliesController@updateHSCCFamilyDetails')->name('updateHSCCFamilyDetails');

	Route::get('HSCCHamilyEdit/{id}/{type}/{pCat}/{page}/{status}/{personCat}','Admin\Projects\FamiliesController@editHSCCFamilyDetails')->name('HSCCFamilyEdit');

	Route::get('getMonthlyRation/{hfid}/{type}/{pCat}/{page}/{status}/{personCat}','Admin\Projects\FamiliesController@getMonthlyRation')->name('getMonthlyRation');

	Route::post('HSCCHamilyDelete','Admin\Projects\FamiliesController@destroy')->name('HSCCFamilyRemove');

	//************************************* end FamiliesController routes***************************//

	//**********************************Families StudentController routes***************************//
	Route::get('viewStudentsInfo/{id}/{prType}/{pageType}/{status}/{person}','Admin\Projects\FamilyStudentsController@viewFamiliesStudents')->name('viewStudentsInfo');
	// Route::get('HSCCFamilyStudents/{type}','Admin\Projects\FamilyStudentsController@HSCCFamilyStudents')->name('HSCCFamilyStudents');

	Route::get('showStudentsProfile/{id}/{hfid}/{type}/{prType}/{pageType}/{status}/{person}','Admin\Projects\FamilyStudentsController@showStudentsProfile')->name('showStudentsProfile');

	// Route::get('showHSCCFamilyStudent/{id}/{hfid}','Admin\Projects\FamilyStudentsController@showHSCCFamilyStudent')->name('showHSCCFamilyStudent');
	Route::get('HSCCFamilyStudentAssessment/{id}','Admin\Projects\FamilyStudentsController@showHSCCFamilyStudentAssessment')->name('HSCCFamilyStudentAssessment');

	Route::get('showPerformanceChart/{id}/{hfid}/{type}/{pCat}/{page}/{status}/{personCat}','Admin\Projects\FamilyStudentsController@showPerformanceChart')->name('showPerformanceChart');

	// Route::get('HSCCFamilyStudentsAssessing','Admin\Projects\FamilyStudentsController@HSCCFamilyStudentsAssessing')->name('HSCCFamilyStudentsAssessing');

	Route::get('studentsAssessingPage/{type}','Admin\Projects\FamilyStudentsController@addStudentsAssessment')->name('studentsAssessingPage');

	Route::get('addAssessments/{id}/{hfid}/{type}/{pCat}/{page}/{status}/{personCat}','Admin\Projects\FamilyStudentsController@addAssessments')->name('addAssessments');

	Route::get('timeline/{id}/{hfid}/{type}/{pCat}/{page}/{status}/{personCat}/{servType}','Admin\Projects\FamiliesController@timeline')->name('timeline');

	Route::post('storeHSCCFamilyStudentsAssessment','Admin\Projects\FamilyStudentsController@storeHSCCFamilyStudentsAssessment')->name('storeHSCCFamilyStudentsAssessment');
	//************************************ end Families StudentController routes********************//

	//************************************ OtherStudentsConroller routes****************************//
	Route::get('/addOtherStudentsPage/{type}', 'Admin\Projects\OtherStudentsConroller@index')->name('addOtherStudentsPage');

	Route::get('OtherStudentsView','Admin\Projects\OtherStudentstsConroller@index')->name('OtherStudentsView');

	Route::get('editOtherStudents/{id}','Admin\Projects\OtherStudentsConroller@edit')->name('editOtherStudents');

	Route::post('updateOtherStudents','Admin\Projects\OtherStudentsConroller@update')->name('updateOtherStudents');

	Route::get('OtherStudentsProfile/{id}','Admin\Projects\OtherStudentsConroller@otherStudentsProfile')->name('OtherStudentsProfile');
	//********************************** end OtherStudentsConroller routes *************************//

	//********************************** AttController routes *****************************************//
	// Route::get('/ATTStaffsAddPage', function(){ return view('admin.Organizations.ATT.Staffs.addStaffDetails');})->name('ATTStaffsAddPage');

	// Route::get('ATTStaffsView/{type}/{pageType}','Admin\Organizations\AttController@attStaffViewPage')->name('ATTStaffsView');


	Route::get('editATTStaffDetails/{id}','Admin\Organizations\AttController@editATTStaffDetails')->name('editATTStaffDetails');

	Route::post('updateATTStaffDetails','Admin\Organizations\AttController@updateATTStaffDetails')->name('updateATTStaffDetails');

	// Route::get('ATTStaffProfile/{id}','Admin\Organizations\AttController@viewATTStaffProfile')->name('ATTStaffProfile');

	// ATT Students Details
	Route::get('viewATTStudents','Admin\Organizations\AttController@viewATTStudents')->name('viewATTStudents');

	Route::post('updateATTStudents','Admin\Organizations\AttController@updateATTStudents')->name('updateATTStudents');

	Route::get('editATTStudents/{id}','Admin\Organizations\AttController@editATTStudents')->name('editATTStudents');
	
	Route::get('ATTStudentsProfile/{id}','Admin\Organizations\AttController@ATTStudentsProfile')->name('ATTStudentsProfile');

	Route::get('/ATTStudentsAddPage/{type}/{prType}/{pageType}/{status}/{person}', 'Admin\Organizations\AttController@index')->name('ATTStudentsAddPage');

	Route::get('/ATTPage', function(){ return view('admin.Organizations.ATT.index');})->name('ATTPage');
	//********************************** end AttController routes *****************************************//

	//***************************** OrganizationController routes ***************************************//
	Route::get('OrganizationPage','Admin\Organizations\OrganizationController@index')->name('OrganizationPage');

	Route::get('addMemberInfo/{type}/{prType}/{pageType}/{status}/{person}/{unit}','Admin\Organizations\OrganizationController@create')->name('addMemberInfo');

	Route::get('viewMembers/{type}/{prType}/{pageType}/{status}/{person}/{unit}','Admin\Organizations\OrganizationController@viewAllMembers')->name('viewMembers');

	Route::get('getMemberProfile/{id}/{type}/{unit}/{pageType}','Admin\Organizations\OrganizationController@getMemberProfile')->name('getMemberProfile');

	Route::get('performanceIndicator/{id}/{type}/{unit}/{pageType}','Admin\Organizations\OrganizationController@performanceIndicator')->name('performanceIndicator');

	Route::get('memberPhysicalCredit/{id}/{type}/{unit}/{pageType}/{credit}','Admin\Organizations\OrganizationController@memberPhysicalCredit')->name('memberPhysicalCredit');

	Route::get('memberReport/{id}/{type}/{unit}/{pageType}','Admin\Organizations\OrganizationController@memberReport')->name('memberReport');

	Route::get('printReport/{id}/{type}/{unit}/{pageType}','Admin\Organizations\OrganizationController@printReport')->name('printReport');
	
	Route::get('yearlyPlanner/{id}/{type}/{unit}/{pageType}','Admin\Organizations\OrganizationController@yearlyPlanner')->name('yearlyPlanner');

	
	Route::get('staffAssessments/{id}/{type}/{unit}/{pageType}','Admin\Organizations\OrganizationController@staffAssessments')->name('staffAssessments');
	//************************************* end routes *************************************************//

	//***************************** OtherController routes ************************//
	Route::get('/addOtherFamilies',function(){ return view('admin.Projects.FamiliesInfo.OtherFamilies.addOtherFamilies');})->name('addOtherFamilies');
	//************************************* end routes *************************************************//

});
// ***************************************** End Admin Middleware Group ******************************************//

// ******************************************** All Post Groups **************************************************//
	
	// ************************************** RegisterController Group *****************************//
	Route::post('addsubadmin','Admin\RegisterController@register')->name('admin.register');
	// ************************************** End RegisterController Group *************************//

	// ************************************** RoleController Group *********************************//
	Route::post('roleStore','Admin\RoleController@roleStore')->name('role.store');
	// ************************************** End RoleController Group *****************************//

	// ************************************** ProjectsAjaxController Group *********************************//
	Route::post('hfIdofHead','Admin\Ajax\ProjectsAjaxController@hfIdofHead')->name('hfIdofHead');
	Route::post('isMobileExist','Admin\Ajax\ProjectsAjaxController@isMobileExist')->name('isMobileExist');
	Route::post('appendHSCCData','Admin\Ajax\ProjectsAjaxController@appendHSCCData')->name('appendHSCCData');
	Route::post('serachDataExists','Admin\Ajax\ProjectsAjaxController@serachDataExists')->name('serachDataExists');
	Route::post('serachCity','Admin\Ajax\ProjectsAjaxController@serachCity')->name('serachCity');
	Route::post('/getDocCard','Admin\Ajax\ProjectsAjaxController@getDocCard')->name('getDocCard');
	Route::post('/generalEdu','Admin\Ajax\ProjectsAjaxController@generalEdu')->name('generalEdu');
	Route::post('/spiritualDev','Admin\Ajax\ProjectsAjaxController@spiritualDev')->name('spiritualDev');
	Route::post('/lifeSkillsEval','Admin\Ajax\ProjectsAjaxController@lifeSkillsEval')->name('lifeSkillsEval');
	// ************************************** End ProjectsAjaxController Group *****************************//
	
	// ************************************** AjaxController Group *****************************//
	Route::post('/findStudentDetails','ajaxController@findStudentDetails')->name('findStudentDetails');
	// Route::post('/generalEdu','ajaxController@generalEdu')->name('generalEdu');	
	// ************************************** End AjaxController Group *****************************//

	// ************************************** ATTController Group *****************************//
	Route::post('storeATTStudents','Admin\Organizations\AttController@storeATTStudents')->name('storeATTStudents');

	Route::post('feedServiceConcerns','Admin\Projects\FamiliesController@feedSC')->name('feedServiceConcerns');

	Route::post('feedAssessments','Admin\Projects\FamilyStudentsController@feedAssessments')->name('feedAssessments');

	// ************************************** End ATTController Group *************************//

	// ************************************** OtherStudentController Group *****************************//
	Route::post('storeOtherStudents','Admin\Projects\OtherStudentsConroller@store')->name('storeOtherStudents');
	// ************************************** End OtherStudentController Group *************************//

	// ************************************** OtherStudentController Route Group *****************************//
	Route::post('storeOrganizationinfo','Admin\Organizations\OrganizationController@storeOrganizationDetails')->name('storeOrganizationinfo');
	// ************************************** End OtherStudentController Group *************************//

	// ************************************** FamiliesController Group *************************//
	Route::post('storeHSCCFamilyDetails','Admin\Projects\FamiliesController@storeHSCCFamilyDetails')->name('storeHSCCFamilyDetails');

	Route::post('storeImage','Admin\Projects\FamiliesController@storeImage')->name('storeImage');

	Route::post('storeGeneralEducation','Admin\Projects\FamiliesController@storeGeneralEducation')->name('storeGeneralEducation');
	// ************************************** End FamiliesController Group *************************//

	// ************************************** AssessmentsController Group *************************//
	Route::post('storeSpiritual','Admin\Assessments\Students\AssessmentsController@storeSpiritual')->name('storeSpiritual');
	// ************************************** End FamiliesController Group *************************//
