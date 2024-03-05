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
use App\Http\Controllers\API\StripePaymentController;
use App\Http\Controllers\API\commentsNewsEvents;
use App\Http\Controllers\API\PaymentController;


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

Route::post('homePageSecDescAccom', [HomePageDataController::class, 'storeHomeDataDescAccomplishment']);
 
Route::post('homePageSecMeetExec', [HomePageDataController::class, 'storeHomeDataMeetExecutive']);
Route::post('homePageSecCampNews', [HomePageDataController::class, 'storeHomeDataCampNews']);
Route::post('homepageSecSponPartner', [HomePageDataController::class, 'storeHomeSponPartner']);
Route::post('homePageStaticData', [HomePageDataController::class, 'storeHomeStaticData']);
Route::post('campaignPageEquityManagement', [campaignPageController::class, 'storeCampaignEquityManagement']);
Route::post('eventCategory', [eventPageController::class, 'storeEventCategory']);
Route::post('eventPromoImage', [eventPageController::class, 'storeEventPromoImage']);

Route::post('eventManagement', [eventPageController::class, 'storeEventManagement']);
Route::post('storeUserEventSelectionData', [eventPageController::class, 'storeUserEventSelectionData']);
Route::post('donationFormData', [donatePageController::class, 'donationFormData']);

Route::post('donationType', [donatePageController::class, 'donationType']);
Route::post('envolvedInterest', [getEnvolvedController::class, 'storeGetEnvIntrestList']);
Route::post('signUp', [getEnvolvedController::class, 'storeSignUp']);
Route::post('learnMore', [getEnvolvedController::class, 'storeLearnMore']);
Route::post('deletelearnMore', [getEnvolvedController::class, 'deleteLearnMore']);
Route::post('deleteSignUp', [getEnvolvedController::class, 'deleteSignUp']);
Route::post('contactUs', [contacUsController::class, 'storeContactUsData']);
Route::post('storeUserDataForm', [contacUsController::class, 'userContactFormData']);
Route::post('storeStripePaymentData', [StripePaymentController::class, 'storeStripePaymentData']);
Route::post('doPayment', [StripePaymentController::class, 'stripePost']);
Route::post('payment', [PaymentController::class, 'payment']); 
Route::post('order/pay',[PaymentController::class,'payByStripe']);

Route::post('storeComments', [commentsNewsEvents::class, 'storeComments']);
Route::post('contactPost', [contacUsController::class, 'contactPost']);
Route::post('deleteContactUs', [contacUsController::class, 'deleteContactUsData']);

     
Route::middleware('auth:sanctum')->group( function () {
    //Route::resource('blogs', BlogController::class);
 //   Route::post('homepage', [HomePageController::class, 'storehomedata']);



});
//home page routs
//Route::post('homepage_sec_meetOurFounder', [HomePageDataController::class, 'storeHomeDataMeetFounder']);
//Route::post('homepage_sec_missionVission', [HomePageDataController::class, 'storeHomeDataMissionVission']);
//Route::post('homepage_sec_PuttingChicagoToWork', [HomePageDataController::class, 'storeHomeDataPuttingChicagoToWork']);


Route::get('downloadRSVPLists', [eventPageController::class, 'downloadRSVPList']);

Route::get('getHomeDescAccomAndMeetExecutive', [HomePageDataController::class, 'getHomeDataDescAccomplishment']);

//as above get api


Route::get('getHomeCampNewsAndSponsPartner', [HomePageDataController::class, 'getHomeDataCampNews']);
Route::get('getFeaturedImage', [HomePageDataController::class, 'getFeaturedImage']);


//as above get API


Route::get('getHomePageStaticData', [HomePageDataController::class, 'getHomeStaticData']);



//capaign page routs

Route::get('getCampaignPageEquityManagement', [campaignPageController::class, 'getCampaignEquityManagement']);
Route::get('getCampaignPageEquityManagementAdmin', [campaignPageController::class, 'getCampaignEquityManagementAdmin']);


//event page routs

Route::get('getEventCategory', [eventPageController::class, 'getEventCategory']);


Route::get('getEventPromoImage', [eventPageController::class, 'getEventPromoImage']);

//get data of rsvp list
Route::get('getRsvpList', [eventPageController::class, 'getRsvpList']);
//Route::get('downloadRSVPLists', [eventPageController::class, 'downloadRSVPList']);
Route::post('deleteRsvpListData', [eventPageController::class, 'deleteRsvpListData']);



Route::get('getEventManagementFilterData', [eventPageController::class, 'getEventManagementFilterData']);
Route::get('getEventManagement', [eventPageController::class, 'getEventManagement']);
Route::get('downloadUserEventRegisteredData', [eventPageController::class, 'downloadUserRegisteredData']);
Route::get('downloadEventList', [eventPageController::class, 'downloadEventList']);



Route::get('getUserEventSelectionData', [eventPageController::class, 'getUserEventSelectionData']);



//donate page routs 

Route::get('getDonationFormData', [donatePageController::class, 'getdonationFormData']);

Route::get('getDonationType', [donatePageController::class, 'getDonationType']);
//download donation tracking data
Route::get('downloadDonationList', [donatePageController::class, 'donationListDownload']);


//get envolved page routs 

Route::get('getEnvolvedInterest', [getEnvolvedController::class, 'getEnvIntrestList']);

// get evolved page signup

Route::get('getSignUp', [getEnvolvedController::class, 'getSignUpData']);


// get evolved page learn more

//Route::get('getLearnMore', [getEnvolvedController::class, 'getLearMoreData']);

//download api of learn more date
Route::get('learnMoreListDownload', [getEnvolvedController::class, 'learnMoreListDownload']);


// get evolved page learn more section filter data
Route::get('getLearnMoreFilter', [getEnvolvedController::class, 'getInterestReport']);
Route::get('getSignUpReport', [getEnvolvedController::class, 'singnUpTodayDownloadList']);

//contact us routes 


Route::get('getcontactUs', [contacUsController::class, 'getContactUsData']);

//donate page all the images
Route::get('getDonatePageAllImages', [HomePageDataController::class, 'getImagesOfAllSection']);

//category search
Route::get('searchCategoryData', [eventPageController::class, 'searchCategory']);

//using api payment

//save comments of event and news

Route::get('getComments', [commentsNewsEvents::class, 'getComments']);
Route::get('getFilteredComments', [commentsNewsEvents::class, 'getFilteredComments']);

///contact us form data from user

Route::get('getContactUsUserFormData', [contacUsController::class, 'getContactUsUserFormData']);