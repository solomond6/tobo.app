<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\RepliesController;
use App\Http\Controllers\ThreadSubscriptionsController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminTransactionsController;
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\AdminSalesController;
use App\Http\Controllers\Admin\AdminInspectionsController;
use App\Http\Controllers\Admin\WithdrawalController;

use App\Http\Controllers\Moderator\ModeratorHomeController;
use App\Http\Controllers\Moderator\ModeratorTransactionsController;
// use App\Http\Controllers\Moderator\AgentController;
use App\Http\Controllers\Moderator\ModeratorSalesController;
use App\Http\Controllers\Moderator\ModeratorInspectionsController;

use App\Http\Controllers\Agent\AgentSalesController;
use App\Http\Controllers\Agent\AgentHomeController;
use App\Http\Controllers\Agent\AgentInspectionsController;
use App\Http\Controllers\Agent\AgentTransactionsController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostLikeController;



Route::get('/', [LoginController::class, 'showLoginForm'])->name('loginhome');
Route::get('/', [LoginController::class, 'showLoginForm'])->name('/');
Route::post('login', [LoginController::class, 'login'])->name('login');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/user/verify/{token}', [LoginController::class, 'verifyUser']);
Route::get('/resetpassword', [LoginController::class, 'showForgetPasswordForm'])->name('resetpassword');
Route::post('forgotPassword', [LoginController::class, 'forgotPassword'])->name('forgotPassword');

Route::get('/password/reset/{token}', [LoginController::class, 'showResetPasswordForm'])->name('password.reset');

Route::post('password/reset', [LoginController::class, 'resetPassord'])->name('reset.password.post');

Route::match(['get', 'post'], 'logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/utitility/countries', 'UtitlityController@getCountries')->name('countries.data');
Route::get('/utitility/getCountryStates', 'UtitlityController@getCountryStates')->name('getCountryStates.data');
Route::get('/utitility/cities', 'UtitlityController@getStateCities')->name('cities.data');

Route::get('threads', [ThreadController::class, 'index']);

Route::get('threads/create', [ThreadController::class, 'create'])->name('threads.create');
Route::get('/threads/{channel}', [ThreadController::class, 'index']);
Route::get('threads/{channel}/{thread}', [ThreadController::class, 'show']);
Route::delete('threads/{channel}/{thread}', [ThreadController::class, 'destroy']);
Route::post('threads', [ThreadController::class, 'store']);
Route::post('/threads/{channel}/{thread}/replies', [RepliesController::class, 'store']);
Route::get('/threads/{channel}/{thread}/replies', [RepliesController::class, 'index']);

Route::get('auth-user', [AuthUserController::class, 'show']);
Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts/{post}/comment', [PostCommentController::class, 'store']);
Route::post('/posts/{post}/like', [PostLikeController::class, 'store']);

// subscribe and unsubscribe
Route::post('/threads/{channel}/{thread}/subscriptions', [ThreadSubscriptionsController::class, 'store'])->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', [ThreadSubscriptionsController::class, 'destroy'])->middleware('auth');

// Replies
Route::delete('/replies/{reply}', [RepliesController::class, 'destroy']);
Route::post('/replies/{reply}/favorites', [FavoritesController::class, 'store']);
Route::delete('/replies/{reply}/favorites', [FavoritesController::class, 'destroy']);
Route::patch('/replies/{reply}', [RepliesController::class, 'update']);


// Profile
Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');
Route::get("/profiles/{user}/notifications", 'UserNotificationsController@index');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');

Route::get('send', 'UserManagement\UserController@sendNotification');

//mark as read
Route::get('DatabaseNotificationsMarkasRead', function () {auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('databasenotifications.markasread');

Route::get('send', 'UserManagement\UserController@sendNotification');

//mark as read
Route::get('DatabaseNotificationsMarkasRead', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('databasenotifications.markasread');

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function(){
	
	//admin routes
	Route::get('/dashboard', [AdminHomeController::class, 'index'])->name('admin.dashboard');
	Route::get('/inviteagent', [ReferralController::class, 'adminInvite'])->name('admin.inviteagent');
	Route::match(['get', 'post'], '/agent/register', [AdminHomeController::class, 'register'])->name('admin.addagent');
	Route::match(['get', 'post'], '/agent/addagent', [AdminHomeController::class, 'addagent'])->name('admin.registeragent');

	Route::get('/sales', [AdminSalesController::class, 'index'])->name('admin.salesindex');
	Route::get('/transactions', [AdminTransactionsController::class, 'index'])->name('admin.transactions');
	Route::match(['get', 'post'], '/sales/new', [AdminSalesController::class, 'addSales'])->name('admin.sales.new');
	Route::post('/sendinvite', [ReferralController::class, 'sendInvite'])->name('admin.sendinvite');

	Route::get('/agents', [AgentController::class, 'index'])->name('admin.agents');
	// Route::post('/set-commission/', [AgentController::class, 'setCommission'])->name('admin.setcommission');
	Route::post('/set-commission/', [AdminSalesController::class, 'setCommission'])->name('admin.setcommission');
	Route::post('/sales/update', [AdminSalesController::class, 'updateSales'])->name('admin.updatesales');
	Route::match(['get', 'post'], '/deactive-agent/{id}', [AgentController::class, 'deactivateAgent']);
	Route::match(['get', 'post'], '/active-agent/{id}', [AgentController::class, 'activateAgent'] );
	Route::match(['get', 'post'], '/delete-agent/{id}', [AgentController::class, 'deleteAgent'] );
	Route::match(['get', 'post'], '/view-agent/{id}', [AgentController::class, 'viewAgent'] );
	Route::match(['get', 'post'], '/upload-agent-pic/', [AgentController::class, 'uploadAgentPic'] );

	Route::get('/inspections', [AdminInspectionsController::class, 'index'])->name('admin.inspections');
	Route::match(['get', 'post'], '/inspections/data', [AdminInspectionsController::class, 'inspectionsData'])->name('admin.inspection.data');
	Route::match(['get', 'post'], '/inspection/update', [AdminInspectionsController::class, 'updateInspection'])->name('admin.update.inspection');

	Route::match(['get', 'post'], '/agent/data', [AgentController::class, 'agentData'])->name('agent.data');
	Route::match(['get', 'post'], '/sales/data', [AdminSalesController::class, 'salesData'])->name('sales.data');
	Route::match(['get', 'post'], '/transactions/data', [AdminTransactionsController::class, 'transactionsData'])->name('transactions.data');
	Route::match(['get', 'post'], '/transactions/agentdata', [AgentController::class, 'transactionsData'])->name('transactions.agentdata');
	Route::match(['get', 'post'], '/sales/agentdata', [AgentController::class, 'salesData'])->name('sales.agentdata');
	
	Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('admin.withdrawals');
	Route::match(['get', 'post'], '/withdrawal/data', [WithdrawalController::class, 'withdrawalsData'])->name('withdrawal.data');
	Route::match(['get', 'post'], '/approve-withdrawal/{id}', [WithdrawalController::class, 'approveWithdrawal']);
});

Route::group(['prefix' => 'moderator', 'middleware' => ['auth']], function(){
	
	//moderator routes
	Route::get('/dashboard', [ModeratorHomeController::class, 'index'])->name('moderator.dashboard');
	Route::get('/inviteagent', [ReferralController::class, 'moderatorInvite'])->name('moderator.inviteagent');
	Route::match(['get', 'post'], '/agent/register', [ModeratorHomeController::class, 'register'])->name('moderator.addagent');
	Route::match(['get', 'post'], '/agent/addagent', [moderatorHomeController::class, 'addagent'])->name('moderator.registeragent');

	Route::get('/sales', [ModeratorSalesController::class, 'index'])->name('moderator.sales');
	Route::get('/transactions', [ModeratorTransactionsController::class, 'index'])->name('moderator.transactions');
	Route::match(['get', 'post'], '/sales/new', [ModeratorSalesController::class, 'addSales'])->name('moderator.sales.new');
	Route::post('/sendinvite', [ReferralController::class, 'sendInvite'])->name('moderator.sendinvite');

	Route::get('/agents', [AgentController::class, 'index'])->name('Moderator.agents');

	Route::get('/inspections', [ModeratorInspectionsController::class, 'index'])->name('moderator.inspections');
	Route::match(['get', 'post'], '/inspections/data', [ModeratorInspectionsController::class, 'inspectionsData'])->name('moderator.inspection.data');
	Route::match(['get', 'post'], '/inspection/update', [ModeratorInspectionsController::class, 'updateInspection'])->name('moderator.update.inspection');

	Route::match(['get', 'post'], '/agent/data', [AgentController::class, 'agentData'])->name('agent.data');
	Route::match(['get', 'post'], '/sales/data', [ModeratorSalesController::class, 'salesData'])->name('sales.data');
	Route::match(['get', 'post'], '/transactions/data', [ModeratorTransactionsController::class, 'transactionsData'])->name('transactions.data');
	Route::match(['get', 'post'], '/transactions/agentdata', [AgentController::class, 'transactionsData'])->name('transactions.agentdata');
	Route::match(['get', 'post'], '/sales/agentdata', [AgentController::class, 'salesData'])->name('sales.agentdata');
});


Route::group(['prefix' => 'agent', 'middleware' => ['auth']], function(){
	
	//agent routes
	Route::get('/dashboard', [AgentHomeController::class, 'index'])->name('agent.dashboard');
	Route::get('/inviteagent', [ReferralController::class, 'agentInvite'])->name('agent.inviteagent');
	Route::get('/sales', [AgentSalesController::class, 'index'])->name('agent.sales');
	Route::match(['get', 'post'], '/sales/new', [AgentSalesController::class, 'addSales'])->name('agent.sales.new');
	Route::post('/sendinvite', [ReferralController::class, 'sendAgentInvite'])->name('agent.sendinvite');
	Route::match(['get', 'post'], '/sales/data', [AgentSalesController::class, 'salesData'])->name('agent.sales.data');

	Route::match(['get', 'post'], '/my-profile', [AgentController::class, 'agentProfile'] );
	
	Route::get('/inspections', [AgentInspectionsController::class, 'index'])->name('agent.inspections');
	Route::match(['get', 'post'], '/inspections/new', [AgentInspectionsController::class, 'addInspection'])->name('agent.inspections.new');

	Route::match(['get', 'post'], '/withdrawal', [AgentHomeController::class, 'addWithdrawal'])->name('agent.withdrawal');

	Route::match(['get', 'post'], '/inspections/data', [AgentInspectionsController::class, 'inspectionsData'])->name('agent.inspection.data');

	Route::get('/transactions', [AgentTransactionsController::class, 'index'])->name('agent.transactions');
	Route::match(['get', 'post'], '/transactions/data', [AgentTransactionsController::class, 'transactionsData'])->name('agent.transactions.data');

	Route::match(['get', 'post'], '/withdrawal/agentdata', [AgentTransactionsController::class, 'withdrawalsData'])->name('agent.withdrawal.data');
});