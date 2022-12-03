<?php
use App\Models\Role;
use App\Models\payment;

use App\Models\student;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\frontendController;
use App\Http\Controllers\api\resultController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\api\PaymentController;
use App\Http\Controllers\api\RoutineController;
use App\Http\Controllers\api\studentsController;
use App\Http\Controllers\NotificationsController;

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


Route::get('genrate-sitemap', function(){

    // create new sitemap object
    $sitemap = App::make("sitemap");

    // add items to the sitemap (url, date, priority, freq)
    $sitemap->add(URL::to('teachers'), '2012-08-25T20:10:00+02:00', '1.0', 'daily');
    $sitemap->add(URL::to('student_at_a_glance'), '2012-08-26T12:30:00+02:00', '0.9', 'daily');
    $sitemap->add(URL::to('student_list'), '2012-08-26T12:30:00+02:00', '0.9', 'daily');
    $sitemap->add(URL::to('routine'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');
    $sitemap->add(URL::to('result'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');
    $sitemap->add(URL::to('weakly_result'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');
    $sitemap->add(URL::to('web/notice'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');
    $sitemap->add(URL::to('blogs'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');
    $sitemap->add(URL::to('contact-us'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');
    $sitemap->add(URL::to('student/register'), '2012-08-26T12:30:00+02:00', '1.0', 'daily');
    $sitemap->add(URL::to('student/payment'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');

    // // get all posts from db
    // $categories = Category::all();

    // // add every post to the sitemap
    // foreach ($categories as $category)
    // {
    //     $sitemap->add(URL::to('categories/'.$category->id.'/edit'), $category->updated_at, '1.0', 'daily');
    // }

    // generate your sitemap (format, filename)
    $sitemap->store('xml', 'sitemap');
    // this will generate file mysitemap.xml to your public folder

    return redirect(url('sitemap.xml'));
});








Route::get('/smstest', function () {

    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];
    $subject = 'hello subject';

    \Mail::to('freelancernishad123@gmail.com')->send(new \App\Mail\MyTestMail($details,$subject));

    dd("Email is Sent.");


});

Route::get('details',[NotificationsController::class,'details']);







Route::get('/unioncreate', function () {

return view('unioncreate');


});
Route::get('/inviceverify', function (Request $request) {

$trx = $request->trx;

return redirect("/student/applicant/invoice/$trx");

});

Route::get('/payment/success', function (Request $request) {

    // return $request->all();
    $transId = $request->transId;

    echo "
    <h3 style='text-align:center'>Please wait 5 seconds.This page is auto redirect you</h3>

    <script>

    setTimeout(() => {
    window.location.href='/payment/success/confirm?transId=$transId'
    }, 5000);

    </script>

    ";
    // return redirect("/payment/success/confirm?transId=$transId");





});

Route::get('/payment/success/confirm', function (Request $request) {

    // return $request->all();
    $transId = $request->transId;

     $payment = payment::where(['trxid'=>$transId,'status'=>'Paid'])->first();
     $AdmissionID = $payment->admissionId;
     $student = student::where(['AdmissionID'=>$AdmissionID])->first();
    return view('applicationSuccess',compact('payment','student'));
    return redirect("/student/applicant/copy/$payment->admissionId");

});







Route::get('/payment/fail', function (Request $request) {
echo "payment fail";
return $request->all();
});

Route::get('/payment/cancel', function (Request $request) {
    $transId = $request->transId;
    $payment = payment::where('trxid',$transId)->first();


    return redirect("/student/payment?adminssionId=$payment->admissionId&type=$payment->type");
});


Auth::routes([
    'login'=>false,
]);
Route::post('login',[LoginController::class,'login']);
Route::post('logout',[LoginController::class,'logout']);
// Route::group(['middleware' => ['is_admin']], function() {
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// });
// Route::group(['middleware' => ['CustomerMiddleware']], function() {
// Route::get('/sub', [App\Http\Controllers\HomeController::class, 'sub'])->name('sub');
// });




Route::get('/payment',[PaymentController::class ,'paymentCreate']);


Route::get('/report/export', [PaymentController::class,'export']);


Route::get('/allow/application/notification', function () {

    return view('applicationNotification');


    });

    Route::get('pdfgen', function () {

        return view('pdftest');
        });


        Route::get('student/applicant/copy/{applicant_id}',[studentsController::class , 'applicant_copy']);
        Route::get('student/applicant/invoice/{trxid}',[studentsController::class , 'applicant_invoice']);



        Route::get('school/payment/invoice/{id}',[PaymentController::class , 'invoice']);




        Route::get('/pdf/{school_id}/{class}/{roll}/{year}/{exam}',[frontendController::class ,'view_result_pdf']);

        Route::get('/routines/{school_id}/{class}/{year}/download',[RoutineController::class , 'routine_download'])->name('routines.routine_download');




Route::group(['prefix' => 'dashboard','middleware' => ['auth']], function() {


    Route::get('/import', function () {
        return view('import');


        });
        Route::post('import',[studentsController::class,'import']);



        // Route::get('students/card',[studentsController::class , 'card_form']);
        Route::post('students/card/submit',[studentsController::class , 'card_form_submit']);
        Route::get('student/card/{class}/{id}/{school_id}',[studentsController::class , 'card']);

        Route::get('/attendence_sheet/pdf/{school_id}/{class}/{view}/{date}',[studentsController::class , 'attendence_sheet_result_pdf']);

        Route::get('student/{school_id}/{class}/{year}/{type}/paymnetsheet', [PaymentController::class,'paymentsheet']);

      Route::get('/result_sheet/pdf/{school_id}/{group}/{class}/{exam}/All/{date}',[resultController::class , 'resultViewpdf']);

      Route::get('/student_list/pdf/{year}/{class}/{school_id}',[studentsController::class ,'student_list_pdf']);






    Route::get('/{vue_capture?}', function () {
        // return   Auth::user()->roles->permission;
        //   Auth::user()->roles;
          $roles = Role::all();
           $classess = json_encode(['Six', 'Seven', 'Eight', 'Nine', 'Ten']);



        return view('layout',compact('roles','classess'));
    })->where('vue_capture', '[\/\w\.-]*')->name('dashboard');
});
Route::get('/{vue_capture?}', function () {



        // return  Uniouninfo::find(1);
 $uniounDetials['defaultColor']  = 'green';
      $uniounDetials = json_decode(json_encode($uniounDetials));
      $classess = json_encode(['Six', 'Seven', 'Eight', 'Nine', 'Ten']);


     return view('frontlayout',compact('uniounDetials','classess'));

})->where('vue_capture', '.*')->name('frontend');
