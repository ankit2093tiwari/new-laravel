<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HomePageDataController;
use App\Http\Controllers\API\campaignPageController;
use App\Http\Controllers\API\eventPageController;
use App\Http\Controllers\API\donatePageController;
use App\Http\Controllers\API\getEnvolvedController;
use App\Http\Controllers\API\contacUsController;
use App\Http\Controllers\API\stripePaymentController;
use App\Http\Controllers\API\commentsNewsEvents;


//use App\Http\Controllers\HomePageController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'signup']);
	
/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

     
Route::middleware('auth:sanctum')->group( function () {
    //Route::resource('blogs', BlogController::class);
 //   Route::post('homepage', [HomePageController::class, 'storehomedata']);
});
//home page routs
//Route::post('homepage_sec_meetOurFounder', [HomePageDataController::class, 'storeHomeDataMeetFounder']);
//Route::post('homepage_sec_missionVission', [HomePageDataController::class, 'storeHomeDataMissionVission']);
//Route::post('homepage_sec_PuttingChicagoToWork', [HomePageDataController::class, 'storeHomeDataPuttingChicagoToWork']);
Route::post('homePageSecDescAccom', [HomePageDataController::class, 'storeHomeDataDescAccomplishment']);
Route::get('getHomeDescAccomAndMeetExecutive', [HomePageDataController::class, 'getHomeDataDescAccomplishment']);

Route::post('homePageSecMeetExec', [HomePageDataController::class, 'storeHomeDataMeetExecutive']);
//as above get api

Route::post('homePageSecCampNews', [HomePageDataController::class, 'storeHomeDataCampNews']);
Route::get('getHomeCampNewsAndSponsPartner', [HomePageDataController::class, 'getHomeDataCampNews']);

Route::post('homepageSecSponPartner', [HomePageDataController::class, 'storeHomeSponPartner']);
//as above get API

Route::post('homePageStaticData', [HomePageDataController::class, 'storeHomeStaticData']);
Route::get('getHomePageStaticData', [HomePageDataController::class, 'getHomeStaticData']);



//capaign page routs
Route::post('campaignPageEquityManagement', [campaignPageController::class, 'storeCampaignEquityManagement']);
Route::get('getCampaignPageEquityManagement', [campaignPageController::class, 'getCampaignEquityManagement']);
Route::get('getCampaignPageEquityManagementAdmin', [campaignPageController::class, 'getCampaignEquityManagementAdmin']);


//event page routs
Route::post('eventCategory', [eventPageController::class, 'storeEventCategory']);
Route::get('getEventCategory', [eventPageController::class, 'getEventCategory']);

Route::post('eventPromoImage', [eventPageController::class, 'storeEventPromoImage']);
Route::get('getEventPromoImage', [eventPageController::class, 'getEventPromoImage']);

Route::post('eventManagement', [eventPageController::class, 'storeEventManagement']);
Route::get('getEventManagementFilterData', [eventPageController::class, 'getEventManagementFilterData']);
Route::get('getEventManagement', [eventPageController::class, 'getEventManagement']);

Route::post('storeUserEventSelectionData', [eventPageController::class, 'storeUserEventSelectionData']);
Route::get('getUserEventSelectionData', [eventPageController::class, 'getUserEventSelectionData']);



//donate page routs 
Route::post('donationFormData', [donatePageController::class, 'donationFormData']);
Route::get('getDonationFormData', [donatePageController::class, 'getdonationFormData']);

Route::post('donationType', [donatePageController::class, 'donationType']);
Route::get('getDonationType', [donatePageController::class, 'getDonationType']);
//download donation tracking data
Route::get('downloadDonationList', [donatePageController::class, 'donationListDownload']);


//get envolved page routs 
Route::post('envolvedInterest', [getEnvolvedController::class, 'storeGetEnvIntrestList']);
Route::get('getEnvolvedInterest', [getEnvolvedController::class, 'getEnvIntrestList']);

// get evolved page signup
Route::post('signUp', [getEnvolvedController::class, 'storeSignUp']);
Route::get('getSignUp', [getEnvolvedController::class, 'getSignUpData']);


// get evolved page learn more
Route::post('learnMore', [getEnvolvedController::class, 'storeLearnMore']);
//Route::get('getLearnMore', [getEnvolvedController::class, 'getLearMoreData']);

// get evolved page learn more section filter data
Route::get('getLearnMoreFilter', [getEnvolvedController::class, 'getInterestReport']);
Route::get('getSignUpReport', [getEnvolvedController::class, 'singnUpTodayDownloadList']);

//contact us routes 
Route::post('contactUs', [contacUsController::class, 'storeContactUsData']);
Route::post('storeUserDataForm', [contacUsController::class, 'userContactFormData']);

Route::get('getcontactUs', [contacUsController::class, 'getContactUsData']);

//donate page all the images
Route::get('getDonatePageAllImages', [HomePageDataController::class, 'getImagesOfAllSection']);

//category search
Route::get('searchCategoryData', [eventPageController::class, 'searchCategory']);

//using api payment
Route::post('storeStripePaymentData', [stripePaymentController::class, 'storeStripePaymentData']);

//save comments of event and news
Route::post('storeComments', [commentsNewsEvents::class, 'storeComments']);
Route::get('getComments', [commentsNewsEvents::class, 'getComments']);


Route::post('contactPost', [contacUsController::class, 'contactPost']);
Route::get('getContactUsUserFormData', [commentsNewsEvents::class, 'getContactUsUserFormData']);

