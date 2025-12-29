<?php

use Carbon\Carbon;
use App\Models\student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TCController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\api\smsController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\api\BlogController;
use App\Http\Controllers\frontendController;
use  App\Http\Controllers\api\authController;
use App\Http\Controllers\api\EventController;
use App\Http\Controllers\ResultLogController;
use App\Http\Controllers\SchoolFeeController;
use App\Http\Controllers\api\resultController;
use App\Http\Controllers\api\staffsController;
use App\Http\Controllers\AssessmentController;

use App\Http\Controllers\countryApiController;
use App\Http\Controllers\OnlineexamController;
use App\Http\Controllers\api\GalleryController;
use App\Http\Controllers\api\PaymentController;
use App\Http\Controllers\api\RoutineController;
use App\Http\Controllers\api\HomeworkController;
use App\Http\Controllers\api\studentsController;
use App\Http\Controllers\QuestionbankController;
use App\Http\Controllers\api\SchoolDetailController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getip', function (Request $request) {

 return $_SERVER['REMOTE_ADDR'];


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://tepriganjhighschool.edu.bd/getip.php',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;


});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [authController::class,'login']);
    Route::post('register', [authController::class,'register']);
    Route::post('logout', [authController::class,'logout']);
    Route::post('refresh', [authController::class,'refresh']);
    Route::post('me', [authController::class,'login']);

});


Route::get('/tc', [TCController::class, 'index']);
Route::post('/tc', [TCController::class, 'createTC']);
Route::get('/tc/{id}', [TCController::class, 'getTC']);



// country api
Route::get('/getdivisions', [countryApiController::class,'getdivisions']);
Route::get('/getdistrict', [countryApiController::class,'getdistrict']);
Route::get('/getthana', [countryApiController::class,'getthana']);
Route::get('/getunioun', [countryApiController::class,'getunioun']);
Route::get('/gotoUnion', [countryApiController::class,'gotoUnion']);




Route::post('update/users',[RoleController::class,'updateuser']);

Route::post('/ipn',[PaymentController::class ,'ipn']);

Route::post('/re/call/ipn',[PaymentController::class ,'ReCallIpn']);


Route::post('/check/payments/ipn',[PaymentController::class ,'AkpayPaymentCheck']);


Route::get('/get/annually/report',[PaymentController::class ,'getAnnuallyReport']);



Route::post('/payment/report',[PaymentController::class ,'reports']);
Route::get('/payment/counting',[PaymentController::class ,'paymentCounting']);
Route::post('/payment/data/search',[PaymentController::class ,'Search']);


Route::get('student/applicant/copy/{applicant_id}',[studentsController::class , 'applicant_copy_html']);
Route::post('/student/data/search',[studentsController::class ,'Search']);


Route::get('get/balance',[MessageController::class ,'getBalance']);




Route::get('/users/get',[MessageController::class ,'usersget']);
Route::get('/conversion/get',[MessageController::class ,'conversionget']);
Route::get('/messages/get',[MessageController::class ,'messagesget']);
Route::post('/message/sent',[MessageController::class ,'messagessent']);



Route::get('/student_at_a_glance',[frontendController::class ,'student_at_a_glance']);



Route::post('/users/checks',[SchoolDetailController::class ,'userscheck']);
Route::get('/school_id',[SchoolDetailController::class , 'school_id']);
Route::get('/classes',[SchoolDetailController::class , 'class_list']);
Route::get('/years/list', [SchoolDetailController::class,'yearslist']);
Route::get('/imagetobase64', [SchoolDetailController::class,'base64']);

Route::get('/school/settings',[SchoolDetailController::class , 'index']);
Route::post('/school/settings/submit',[SchoolDetailController::class , 'school_update']);

//student routes
Route::post('/students/reports',[studentsController::class , 'reports']);
Route::get('/students/all/reports',[studentsController::class , 'allReports']);

Route::get('/students/list',[studentsController::class , 'list']);

Route::get('/students/for/change/group',[studentsController::class , 'listforGroup']);

Route::get('/get/pending/student',[studentsController::class , 'getStudents']);

Route::post('/approve/pending/student',[studentsController::class , 'approveStudents']);

Route::post('/student/permission',[studentsController::class , 'permissionAction']);


Route::get('/students/image/get',[studentsController::class , 'imageget']);
Route::post('/students/image/upload',[studentsController::class , 'imageupload']);
Route::get('/students/single',[studentsController::class , 'singlestudent']);
Route::post('/students/form/submit',[studentsController::class , 'student_submit']);
Route::post('/student/{action}',[studentsController::class , 'student_action']);
Route::get('/check/student/roll',[studentsController::class , 'student_roll_check']);
Route::get('/student/check',[studentsController::class , 'student_check']);

Route::get('/student/admissionid/genarate',[studentsController::class , 'AdmissionIdgenarate']);

Route::get('/student/attendance',[studentsController::class , 'student_attendance']);
Route::get('/student/attendance/count',[studentsController::class , 'student_attendance_count']);
Route::post('/student/attendance/submit',[studentsController::class , 'student_attendance_submit']);
Route::get('/student/attendance/row',[studentsController::class , 'student_attendance_row']);

Route::get('/get/form/fillup/students',[studentsController::class , 'formfillupstudents']);


Route::post('/student/transferto/old',[studentsController::class , 'transertoOld']);
Route::post('/another/school/data',[studentsController::class , 'addAnotherSchoolData']);



//staffs routes
Route::get('/staffs/list',[staffsController::class , 'list']);
Route::get('/staffs/image/get',[staffsController::class , 'imageget']);
Route::post('/staffs/image/upload',[staffsController::class , 'imageupload']);

Route::get('/staffs/single',[staffsController::class , 'singlestaff']);
Route::post('/staffs/form/submit',[staffsController::class , 'staff_submit']);
Route::post('/staff/{action}',[staffsController::class , 'staff_action']);
Route::get('/staff/attendance',[staffsController::class , 'staff_attendance']);
Route::post('/staff/attendance/submit',[staffsController::class , 'staff_attendance_submit']);


//students/payments routes
Route::get('/students/payments',[PaymentController::class , 'payments']);
Route::post('/students/payments/submit',[PaymentController::class , 'payments_submit']);


//routine routes
Route::get('/routines',[RoutineController::class , 'list']);
Route::get('/routines/get',[RoutineController::class , 'all_list']);
Route::get('/routines/check',[RoutineController::class , 'check']);
Route::post('/routines/submit',[RoutineController::class , 'submit']);


//result routes
Route::get('/results',[resultController::class , 'Result']);


Route::post('/results/submit',[resultController::class , 'submit']);

Route::get('/all/results/list',[resultController::class , 'AllResultList']);

Route::get('/full/results',[resultController::class , 'fullResult']);

Route::get('/results/check',[resultController::class , 'checkResult']);
Route::get('/public/result/search',[resultController::class , 'searchResult']);
Route::get('/results/single',[resultController::class , 'checkSingleResult']);
Route::post('/results/publish',[resultController::class , 'publishResult']);
Route::post('/results/publish/list',[resultController::class , 'ResultPublish']);



//gallery routes

Route::get('/gallery',[GalleryController::class , 'index']);
Route::get('/gallery/edit',[GalleryController::class , 'galleryedit']);
Route::get('/gallery/delete/{id}',[GalleryController::class , 'galleryDelete']);
Route::get('/gallery_category',[GalleryController::class , 'category']);
Route::get('/gallery_category/delete/{id}',[GalleryController::class , 'categoryDelete']);
Route::post('/gallery_category/submit',[GalleryController::class , 'category_submit']);
Route::post('/gallery/submit',[GalleryController::class , 'gallery_submit']);



//blog routes

Route::get('/blog',[BlogController::class , 'index']);
Route::get('/blog/edit',[BlogController::class , 'blogedit']);
Route::get('/blog/delete/{id}',[BlogController::class , 'blogDelete']);
Route::get('/blog_category',[BlogController::class , 'category']);
Route::get('/blog_category/delete/{id}',[BlogController::class , 'categoryDelete']);
Route::post('/blog_category/submit',[BlogController::class , 'category_submit']);
Route::post('/blog/submit',[BlogController::class , 'blog_submit']);


//event routes

Route::get('/event',[EventController::class , 'index']);
Route::get('/event/edit',[EventController::class , 'eventedit']);
Route::get('/event/delete/{id}',[EventController::class , 'eventDelete']);
Route::post('/event/submit',[EventController::class , 'event_submit']);

//Notice routes
Route::resources([
	'notice' => NoticeController::class,
	'fees' => SchoolFeeController::class,

]);


//homework routes

Route::get('/homework',[HomeworkController::class , 'index']);
Route::get('/homework/edit',[HomeworkController::class , 'homeworkedit']);
Route::get('/homework/delete/{id}',[HomeworkController::class , 'homeworkDelete']);
Route::post('/homework/submit',[HomeworkController::class , 'homework_submit']);
Route::post('/student/homework/submit',[HomeworkController::class , 'student_homework_submit']);
Route::get('/student/homework/submit/check',[HomeworkController::class , 'student_homework_check']);
Route::get('/student/homework/time/check',[HomeworkController::class , 'student_homework_timecheck']);



Route::post('/sent_sms/submit',[smsController::class , 'sent_sms_submit']);
Route::get('/attendence_sheet/sms/{class}/{view}/{date}/{school_id}',[smsController::class , 'attendence_sheet_sms']);



Route::get('/questionbank',[QuestionbankController::class , 'index']);
Route::get('/questionbank/edit',[QuestionbankController::class , 'questionbankedit']);
Route::get('/questionbank/delete/{id}',[QuestionbankController::class , 'questionbankDelete']);
Route::post('/questionbank/submit',[QuestionbankController::class , 'questionbank_submit']);


Route::get('/onlineexam',[OnlineexamController::class , 'index']);
Route::get('/onlineexam/view',[OnlineexamController::class , 'examview']);
Route::post('/onlineexam/start',[OnlineexamController::class , 'examstart']);
Route::get('/onlineexam/edit',[OnlineexamController::class , 'onlineexamsedit']);
Route::get('/onlineexam/delete/{id}',[OnlineexamController::class , 'onlineexamsDelete']);
Route::post('/onlineexam/submit',[OnlineexamController::class , 'onlineexams_submit']);


Route::post('visitorcreate',[VisitorController::class, 'visitorcreate']);
Route::get('visitorcount',[VisitorController::class, 'visitorCount']);


Route::post('resultlogCount',[ResultLogController::class,'index']);
Route::post('result/edit/mode',[ResultLogController::class,'editmode']);
Route::get('result/log',[ResultLogController::class,'indexlist']);


Route::get('/answeres',[OnlineexamController::class , 'answeres']);


Route::get('/school/fees',[SchoolFeeController::class , 'index']);
Route::get('/school/fees/{id}',[SchoolFeeController::class , 'show']);
Route::post('/school/update/fees',[SchoolFeeController::class , 'update']);





Route::get('/assessments',[AssessmentController::class , 'getStudentAssessment']);
Route::post('/assessments',[AssessmentController::class , 'store']);
Route::get('/assessment/students',[AssessmentController::class , 'getStudent']);

    // Route::prefix('v1')->group(function () {




    //     Route::post('login', [authController::class, 'login']);
    //     Route::post('register', [authController::class, 'register']);

    //     Route::get('login', function () {
    //         return sent_error('Unauthorised', '', 401);
    //     })->name('login');

    //     Route::middleware('auth:api')->group(function () {

    //         Route::post('logout', [authController::class, 'logout']);


    //         Route::get('users', [authController::class, 'index']);
    //         Route::post('users/{id}/edit', [authController::class, 'Edit']);
    //         Route::delete('users/{id}/delete', [authController::class, 'delete']);
    //         Route::get('users/restore/{id}', [authController::class, 'restore']);
    //         Route::get('users/restore/', [authController::class, 'restoreAll']);
    //         Route::get('users/deleted/', [authController::class, 'deleted']);
    //         Route::get('users/{id}', [authController::class, 'show']);
    //     });
    // });





Route::post('atten/webhook', function (Request $request) {

    $payload = $request->all();
    Log::info('Webhook Hit', $payload);

    $data = $payload['data'] ?? null;
    if (!$data || empty($data['user_id']) || empty($data['timestamp'])) {
        return response()->json('Invalid payload', 400);
    }

    /*
    |--------------------------------------------------------------------------
    | Find Student
    |--------------------------------------------------------------------------
    */
    $student = Student::find($data['user_id']);
    if (!$student) {
        return response()->json('Student not found', 404);
    }

    $date  = Carbon::parse($data['timestamp'])->toDateString();
    $month = Carbon::parse($data['timestamp'])->format('F');
    $year  = Carbon::parse($data['timestamp'])->year;

    /*
    |--------------------------------------------------------------------------
    | Normalize Phone Number (🔥 VERY IMPORTANT)
    |--------------------------------------------------------------------------
    */
    $rawPhone = $student->StudentPhoneNumber;
    $phone = preg_replace('/\D/', '', $rawPhone); // remove + - space

    if (strlen($phone) == 11) {
        $phone = $phone;
    }

    /*
    |--------------------------------------------------------------------------
    | Today Attendance Row
    |--------------------------------------------------------------------------
    */
    $attendanceRow = Attendance::where([
        'student_class' => $student->StudentClass,
        'date'          => $date,
        'year'          => $year,
    ])->first();

    /*
    |--------------------------------------------------------------------------
    | CASE 1: FIRST PUNCH → CREATE ATTENDANCE
    |--------------------------------------------------------------------------
    */
    if (!$attendanceRow) {

        $students = Student::where([
            'StudentClass'  => $student->StudentClass,
            'Year'          => $student->Year,
            'StudentStatus' => $student->StudentStatus,
        ])->get();

        $attendanceArray = [];

        foreach ($students as $stu) {
            $attendanceArray[] = [
                'id'         => $stu->id,
                'stu_roll'   => $stu->StudentRoll,
                'stu_id'     => $stu->StudentID,
                'stu_name'   => $stu->StudentName,
                'attendence' => ($stu->id == $student->id) ? 'Present' : 'Absent',
            ];
        }

        Attendance::create([
            'school_id'     => $student->school_id,
            'date'          => $date,
            'month'         => $month,
            'year'          => $year,
            'student_class' => $student->StudentClass,
            'attendance'    => json_encode($attendanceArray, JSON_UNESCAPED_UNICODE),
            'status'        => 'Pending',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ✅ SEND SMS (FIRST PUNCH)
        |--------------------------------------------------------------------------
        */
        if ($phone) {

            $message = "সম্মানিত অভিভাবক, আপনার সন্তান {$student->StudentName} আজ {$date} তারিখে বিদ্যালয়ে উপস্থিত হয়েছে।";

            Log::info('SMS TRY (FIRST)', [
                'phone' => $phone,
                'message' => $message
            ]);

            SmsNocSmsSend($message, $phone);
        }

        return response()->json('Attendance created & SMS sent', 200);
    }

    /*
    |--------------------------------------------------------------------------
    | CASE 2: ATTENDANCE EXISTS → UPDATE PRESENT
    |--------------------------------------------------------------------------
    */
    $attendanceList = json_decode($attendanceRow->attendance, true);
    $alreadyPresent = false;

    foreach ($attendanceList as &$row) {
        if ($row['stu_id'] == $student->StudentID) {

            if ($row['attendence'] === 'Present') {
                $alreadyPresent = true;
                break;
            }

            $row['attendence'] = 'Present';
            break;
        }
    }

    if ($alreadyPresent) {
        return response()->json('Student already present today', 200);
    }

    /*
    |--------------------------------------------------------------------------
    | ✅ SEND SMS (LATE PRESENT)
    |--------------------------------------------------------------------------
    */
    if ($phone) {

        $message = "সম্মানিত অভিভাবক, আপনার সন্তান {$student->StudentName} আজ {$date} তারিখে বিদ্যালয়ে উপস্থিত হয়েছে।";

        Log::info('SMS TRY (LATE)', [
            'phone' => $phone,
            'message' => $message
        ]);

        SmsNocSmsSend($message, $phone);
    }

    $attendanceRow->attendance = json_encode($attendanceList, JSON_UNESCAPED_UNICODE);
    $attendanceRow->save();

    return response()->json('Student attendance updated & SMS sent', 200);
});


/*
|--------------------------------------------------------------------------
| All Students
|--------------------------------------------------------------------------
*/
Route::get('all/students', function () {

    $students = Student::where([
        'StudentStatus' => 'Active',
        'Year'          => date('Y')
    ])->select('id', 'StudentName', 'StudentNameEn', 'StudentClass')
      ->get();

    return response()->json(['data' => $students]);
});

/*
|--------------------------------------------------------------------------
| All Students API
|--------------------------------------------------------------------------
*/
Route::get('all/students', function () {

    $students = Student::where([
        'StudentStatus' => 'Active',
        'Year'          => date('Y')
    ])->select('id', 'StudentName', 'StudentNameEn', 'StudentClass')
      ->get();

    return response()->json(['data' => $students]);
});



// INSERT INTO `attendances` (`id`, `school_id`, `date`, `month`, `year`, `student_class`, `attendance`, `status`, `message_status`, `created_at`, `updated_at`) VALUES (NULL, '2019', '2023-01-11', 'January', '2023', 'Six', '[{\"id\":341,\"stu_roll\":\"12\",\"fatherName\":\"MD.ASHRAFUL\",\"motherName\":\"MST.AKTER BANU\",\"stu_id\":\"201923062012\",\"stu_name\":\"\\u09b8\\u09c1\\u09ae\\u09be \\u0986\\u0995\\u09cd\\u09a4\\u09be\\u09b0\",\"phone\":\"01780975682\",\"attendence\":\"Absent\",\"status\":\"pending\"},{\"id\":342,\"stu_roll\":\"4\",\"fatherName\":\"Md. Aktar hossin\",\"motherName\":\"mst. Shanaz khatun\",\"stu_id\":\"201923062004\",\"stu_name\":\"\\u0986\\u0996\\u09bf \\u09ae\\u09a8\\u09bf \\u09ae\\u09bf\\u09b6\\u09c1\",\"phone\":\"01770630265\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":343,\"stu_roll\":\"26\",\"fatherName\":\"Ramesh chandra ray\",\"motherName\":\"menoka rani\",\"stu_id\":\"201923062016\",\"stu_name\":\"\\u0995\\u09ae\\u09b2\\u09c0\\u0995\\u09be \\u09b0\\u09be\\u09a8\\u09c0\",\"phone\":\"01723706109\",\"attendence\":\"Absent\",\"status\":\"pending\"},{\"id\":344,\"stu_roll\":\"18\",\"fatherName\":\"md. Aminur rahman\",\"motherName\":\"MST.shajade begum\",\"stu_id\":\"201923062018\",\"stu_name\":\"\\u09ae\\u09cb\\u0983 \\u0986\\u09b8\\u09be\\u09a6\\u09c1\\u099c\\u09cd\\u099c\\u09be\\u09ae\\u09be\\u09a8 \\u0986\\u0995\\u09be\\u09b6\",\"phone\":\"01744873590\",\"attendence\":\"Absent\",\"status\":\"pending\"},{\"id\":345,\"stu_roll\":\"15\",\"fatherName\":\"md. Maznu mia\",\"motherName\":\"mst. Anna begum\",\"stu_id\":\"201923062015\",\"stu_name\":\"\\u09ae\\u09cb\\u0983 \\u09b8\\u09be\\u09a6\\u09bf\\u0995\\u09c1\\u09b2 \\u0987\\u09b8\\u09b2\\u09be\\u09ae\",\"phone\":\"01705128708\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":347,\"stu_roll\":\"17\",\"fatherName\":\"Sukumar roy\",\"motherName\":\"biroja rani\",\"stu_id\":\"201923062017\",\"stu_name\":\"\\u09a6\\u09bf\\u09aa\\u09cd\\u09a4\\u09c0 \\u09b0\\u09be\\u09a3\\u09c0\",\"phone\":\"01755405717\",\"attendence\":\"Absent\",\"status\":\"pending\"},{\"id\":348,\"stu_roll\":\"9\",\"fatherName\":\"bidhan chandra roy\",\"motherName\":\"protima rani\",\"stu_id\":\"201923062009\",\"stu_name\":\"\\u0985\\u09ad\\u09bf\\u099c\\u09bf\\u09ce \\u099a\\u09a8\\u09cd\\u09a6\\u09cd\\u09b0 \\u09b0\\u09be\\u09df\",\"phone\":\"01744762555\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":350,\"stu_roll\":\"1\",\"fatherName\":\"MD. Murad hossain modol\",\"motherName\":\"mst.moyna begum\",\"stu_id\":\"201923062001\",\"stu_name\":\"\\u09ae\\u09cb\\u0983 \\u0986\\u09b2 \\u0986\\u09ae\\u09bf\\u09a8 \\u09ae\\u09a8\\u09cd\\u09a1\\u09b2\",\"phone\":\"01965979256\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":351,\"stu_roll\":\"14\",\"fatherName\":\"md. Sarfat ali\",\"motherName\":\"Mst. Mukta begum\",\"stu_id\":\"201923062014\",\"stu_name\":\"\\u09ae\\u09cb\\u0983 \\u09ae\\u09be\\u09b8\\u09c1\\u09a6 \\u09b0\\u09be\\u09a8\\u09be\",\"phone\":\"01776865958\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":353,\"stu_roll\":\"3\",\"fatherName\":\"md. Sahidul islam\",\"motherName\":\"mst.sahaj parvin\",\"stu_id\":\"201923062003\",\"stu_name\":\"\\u09ae\\u09cb\\u099b\\u09be\\u0983 \\u09b8\\u09c1\\u09ac\\u09b0\\u09cd\\u09a8\\u09be \\u0986\\u0995\\u09cd\\u09a4\\u09be\\u09b0 \\u09b8\\u09cd\\u09ac\\u09aa\\u09cd\\u09a8\\u09be\",\"phone\":\"01311882198\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":354,\"stu_roll\":\"2\",\"fatherName\":\"md. Tonuman islam\",\"motherName\":\"mst.sukhi khatun\",\"stu_id\":\"201923062002\",\"stu_name\":\"\\u09ae\\u09cb\\u0983 \\u09b8\\u09cc\\u09b0\\u09ad \\u09b9\\u09cb\\u09b8\\u09c7\\u09a8\",\"phone\":\"01788013472\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":356,\"stu_roll\":\"6\",\"fatherName\":\"Nazrul islam\",\"motherName\":\"Mst. Forida yesmin\",\"stu_id\":\"201923062006\",\"stu_name\":\"\\u09ab\\u09b0\\u09bf\\u09a6\\u09c1\\u09b2 \\u0987\\u09b8\\u09b2\\u09be\\u09ae\",\"phone\":\"01784985744\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":358,\"stu_roll\":\"8\",\"fatherName\":\"tarikul islam\",\"motherName\":\"moriom begum\",\"stu_id\":\"201923062008\",\"stu_name\":\"\\u09ae\\u09cb\\u0983 \\u09b9\\u09be\\u099b\\u09be\\u09a8 \\u0986\\u09b2\\u09c0\",\"phone\":\"01767176019\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":360,\"stu_roll\":\"16\",\"fatherName\":\"md. Ajijul haque\",\"motherName\":\"mst. Mariam begum\",\"stu_id\":\"201923062016\",\"stu_name\":\"\\u09ae\\u09cb\\u0983 \\u09ae\\u09a8\\u09bf\\u09b0\\u09c1\\u09b2 \\u0987\\u09b8\\u09b2\\u09be\\u09ae\",\"phone\":\"01307330057\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":362,\"stu_roll\":\"5\",\"fatherName\":\"md. Jamser ali\",\"motherName\":\"mst. Mazeda begum\",\"stu_id\":\"201923062005\",\"stu_name\":\"\\u09ae\\u09cb\\u099b\\u09be\\u0983 \\u09b0\\u09c1\\u09ae\\u09be \\u0986\\u0995\\u09cd\\u09a4\\u09be\\u09b0\",\"phone\":\"01706786297\",\"attendence\":\"Absent\",\"status\":\"pending\"},{\"id\":364,\"stu_roll\":\"10\",\"fatherName\":\"md. Arphan ali\",\"motherName\":\"surza banu\",\"stu_id\":\"201923062010\",\"stu_name\":\"\\u09ae\\u09cb\\u0983 \\u09b8\\u09c1\\u09ae\\u09a8 \\u0987\\u09b8\\u09b2\\u09be\\u09ae\",\"phone\":\"01321283993\",\"attendence\":\"Absent\",\"status\":\"pending\"},{\"id\":365,\"stu_roll\":\"13\",\"fatherName\":\"md. Surus ali\",\"motherName\":\"Mst. Lipi akter\",\"stu_id\":\"201923062013\",\"stu_name\":\"\\u09ae\\u09cb\\u0983 \\u09b2\\u09bf\\u0996\\u09a8 \\u0987\\u09b8\\u09b2\\u09be\\u09ae\",\"phone\":\"01713769893\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":367,\"stu_roll\":\"11\",\"fatherName\":\"liton chandra\",\"motherName\":\"nilema rani\",\"stu_id\":\"201923062011\",\"stu_name\":\"\\u09b6\\u09c1\\u09ad \\u09aa\\u09cd\\u09b0\\u09ad\\u09be\\u09a4\",\"phone\":\"01721558036\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":368,\"stu_roll\":\"21\",\"fatherName\":\"ROBIUL islam\",\"motherName\":\"jharna begum\",\"stu_id\":\"201923062021\",\"stu_name\":\"\\u09b0\\u09c1\\u09ac\\u09bf\\u09a8\\u09be \\u0986\\u0995\\u09cd\\u09a4\\u09be\\u09b0\",\"phone\":\"01984364411\",\"attendence\":\"Absent\",\"status\":\"pending\"},{\"id\":371,\"stu_roll\":\"19\",\"fatherName\":\"ROBIUL islam\",\"motherName\":\"mst. Alif laila\",\"stu_id\":\"201923062019\",\"stu_name\":\"\\u0986\\u09b0\\u09be\\u09ab\\u09be\\u09a4 \\u0987\\u09b8\\u09b2\\u09be\\u09ae \\u0986\\u09ac\\u09bf\\u09b0\",\"phone\":\"01737749408\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":372,\"stu_roll\":\"25\",\"fatherName\":\"md. Joynal abedin\",\"motherName\":\"Mst. kamola begum\",\"stu_id\":\"201923062025\",\"stu_name\":\"\\u09ae\\u09cb\\u099b\\u09be\\u0983 \\u099c\\u09c1\\u0987 \\u0986\\u0995\\u09cd\\u09a4\\u09be\\u09b0\",\"phone\":\"01740261219\",\"attendence\":\"Absent\",\"status\":\"pending\"},{\"id\":373,\"stu_roll\":\"22\",\"fatherName\":\"vabesh chandra ray\",\"motherName\":\"shapna rani\",\"stu_id\":\"201923062022\",\"stu_name\":\"\\u09ac\\u09c3\\u09b7\\u09cd\\u099f\\u09bf \\u09b0\\u09be\\u09a8\\u09c0\",\"phone\":\"01306048027\",\"attendence\":\"Absent\",\"status\":\"pending\"},{\"id\":375,\"stu_roll\":\"7\",\"fatherName\":\"FORIdul islam\",\"motherName\":\"peara begum\",\"stu_id\":\"201923062007\",\"stu_name\":\"\\u09ae\\u09cb\\u0983 \\u099c\\u09be\\u09b9\\u09bf\\u09a6 \\u09b9\\u09be\\u09b8\\u09be\\u09a8\",\"phone\":\"01737749408\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":376,\"stu_roll\":\"20\",\"fatherName\":\"md. Rostom ali\",\"motherName\":\"Rofika begum\",\"stu_id\":\"201923062020\",\"stu_name\":\"\\u09ae\\u09cb\\u0983 \\u09b0\\u09be\\u09ab\\u09bf\\u0989\\u09b2 \\u0987\\u09b8\\u09b2\\u09be\\u09ae \\u09b0\\u09be\\u09b9\\u09c0\",\"phone\":\"01788248681\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":377,\"stu_roll\":\"23\",\"fatherName\":\"semanta chandra roy\",\"motherName\":\"tiloktoma\",\"stu_id\":\"201923062023\",\"stu_name\":\"\\u0995\\u09b0\\u09c1\\u09a8\\u09be \\u09b0\\u09be\\u09a8\\u09c0 \\u09b0\\u09be\\u09df\",\"phone\":\"01737749408\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":378,\"stu_roll\":\"24\",\"fatherName\":\"md. Minhaj\",\"motherName\":\"Mst. Golapi\",\"stu_id\":\"201923062024\",\"stu_name\":\"\\u0993\\u09df\\u09be\\u09b2\\u09bf\\u09a6 \\u09b9\\u09be\\u09b8\\u09be\\u09a8 \\u09b0\\u09bf\\u09df\\u09be\\u09a6\",\"phone\":\"01737749408\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":379,\"stu_roll\":\"29\",\"fatherName\":\"md. Omor faruk\",\"motherName\":\"mst. Nargis akter\",\"stu_id\":\"201923062029\",\"stu_name\":\"\\u09ae\\u09cb\\u099b\\u09be\\u0983 \\u0989\\u09ae\\u09cd\\u09ae\\u09c7 \\u09ab\\u09be\\u09b0\\u09bf\\u099c\\u09be\",\"phone\":\"01723997045\",\"attendence\":\"Absent\",\"status\":\"pending\"},{\"id\":380,\"stu_roll\":\"28\",\"fatherName\":\"md. hafizur rahman\",\"motherName\":\"mst. RUMA akter\",\"stu_id\":\"201923062028\",\"stu_name\":\"\\u09ae\\u09cb\\u099b\\u09be\\u0983 \\u09b9\\u09c7\\u09a8\\u09be \\u0986\\u0995\\u09cd\\u09a4\\u09be\\u09b0\",\"phone\":\"01794839263\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":381,\"stu_roll\":\"27\",\"fatherName\":\"md. MOKADdes hossan\",\"motherName\":\"anoara AKHtar\",\"stu_id\":\"201923062027\",\"stu_name\":\"\\u09ae\\u09cb\\u0983 \\u0986\\u09b9\\u09b8\\u09be\\u09a8 \\u09b9\\u09be\\u09ac\\u09bf\\u09ac \\u0986\\u09b2\\u09bf\\u09ab\",\"phone\":\"01762608619\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":382,\"stu_roll\":\"30\",\"fatherName\":\"md. Shahajahan ali\",\"motherName\":\"mst. rupali begum\",\"stu_id\":\"201923062030\",\"stu_name\":\"\\u09ae\\u09cb\\u099b\\u09be\\u0983 \\u09b8\\u09c1\\u09ae\\u09be\\u0987\\u09df\\u09be \\u0986\\u0995\\u09cd\\u09a4\\u09be\\u09b0\",\"phone\":\"01737749408\",\"attendence\":\"Absent\",\"status\":\"pending\"},{\"id\":383,\"stu_roll\":\"31\",\"fatherName\":\"topon CHANDRo roy\",\"motherName\":\"shondha rani roy\",\"stu_id\":\"201923062031\",\"stu_name\":\"\\u09b8\\u09cc\\u09b0\\u09ad \\u099a\\u09a8\\u09cd\\u09a6\\u09cd\\u09b0 \\u09b0\\u09be\\u09df\",\"phone\":\"01923036995\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":384,\"stu_roll\":\"32\",\"fatherName\":\"Md. hafizul islam\",\"motherName\":\"mst. Yasmin akter\",\"stu_id\":\"201923062032\",\"stu_name\":\"\\u09ae\\u09cb\\u099b\\u09be\\u0983 \\u09b9\\u09cd\\u09af\\u09be\\u09aa\\u09bf \\u0986\\u0995\\u09cd\\u09a4\\u09be\\u09b0\",\"phone\":\"01737749408\",\"attendence\":\"Present\",\"status\":\"pending\"},{\"id\":385,\"stu_roll\":\"33\",\"fatherName\":\"md. Asadul haque\",\"motherName\":\"mst. Pervin begum\",\"stu_id\":\"201923062033\",\"stu_name\":\"\\u09ae\\u09cb\\u099b\\u09be\\u0983 \\u0986\\u09b6\\u09be \\u09ae\\u09a8\\u09bf\",\"phone\":\"01737749408\",\"attendence\":\"Present\",\"status\":\"pending\"}]', NULL, 'Pending', '2023-01-11 21:45:03', '2023-01-11 21:45:03')
