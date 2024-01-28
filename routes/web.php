<?php

use App\Http\Controllers\CourseController;
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

//Route::get('/', function () {
//    return view('welcome');
//});

//Only Guest Accessed Routes
Route::group([
    'middleware'    => ['api', 'guest'],
    'namespace'     => 'App\Http\Controllers',
], function ($router) {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/login', 'AuthController@login')->name('login');
    Route::post('/login', 'AuthController@authenticate')->name('authenticate');
    Route::get('/register', 'AuthController@create')->name('register');
    Route::post('/register', 'AuthController@store')->name('register.store');
});

Route::group([
    'middleware'    => ['api', 'auth'],
    'namespace'     => 'App\Http\Controllers',
], function ($router) {
    Route::get('student', 'AuthController@index')->name('student.index');
    Route::get('/user/{user}', 'AuthController@show')->name('profile.show');
    Route::put('/user', 'AuthController@update')->name('profile.update');
    Route::put('/user/update-password', 'AuthController@updatePassword')->name('profile.update-password');
    Route::get('/logout', 'AuthController@logout')->name('logout');

    Route::get('/home', 'DashboardController@index')->name('dashboard');
    Route::get('/landing', 'HomeController@landing')->name('landing');

    Route::resource('department', 'DepartmentController');
    Route::resource('semester', 'SemesterController');
    Route::post('semester/{semester}/timeline', 'SemesterController@timelineStore')->name('semester.timeline.store');

    Route::resource('job', 'JobController');
    Route::post('job/{job}/requirement', 'JobController@updateRequirement')->name('job.update.requirement');
    Route::post('job-active-toggle', 'JobController@ajaxActiveToggle')->name('job.ajax.active-toggle');

    Route::get('blog/create', 'BlogController@create')->name('blog.create');
    Route::post('blog', 'BlogController@store')->name('blog.store');
    Route::get('blog/{blog}/edit', 'BlogController@edit')->name('blog.edit');
    Route::put('blog/{blog}', 'BlogController@update')->name('blog.update');
    Route::delete('blog/{blog}', 'BlogController@destroy')->name('blog.delete');

    Route::resource('todo-list', 'TodoListController');
    Route::get('report', 'ReportController@index')->name('report.index');
    Route::get('report/{course_id}', 'ReportController@show')->name('report.show');

    Route::get('event/create', 'EventController@create')->name('event.create');
    Route::post('event', 'EventController@store')->name('event.store');
});

Route::group([
    'middleware'    => ['api'],
    'namespace'     => 'App\Http\Controllers',
], function ($router) {
    Route::resource('/courses', 'CourseController');
    Route::get('courses/{course}/enroll', 'CourseController@enroll')->name('courses.enroll');
    Route::post('courses/{course}/enroll', 'CourseController@authenticate')->name('courses.authenticate');
    Route::post('courses/{course}/resource', 'CourseController@resourceStore')->name('courses.resource.store');
    Route::get('courses/resource/download/{file_name}', 'CourseController@resourceDownload')->name('courses.resource.download');
//    Route::post('courses/resource/upload', 'CourseController@resourceUpload')->name('courses.resource.upload');

    Route::group(['prefix' => 'courses/{course}'], function () {
        Route::resource('/quiz', 'QuizController');
        Route::post('/quiz/{quiz_id}/question', 'QuizController@storeQuestion')->name('quiz.question.store');
        Route::post('/quiz/{quiz_id}/answer', 'QuizController@storeAnswer')->name('quiz.answer.store');
        Route::get('quiz/{quiz_id}/submission/{submission_id}', 'QuizController@showSubmission')->name('quiz.show.submission');

        Route::resource('/class-test', 'ClassTestController');
        Route::post('/class-test/{class_test_id}/question', 'ClassTestController@storeQuestion')->name('class-test.question.store');
        Route::post('/class-test/{class_test_id}/answer', 'ClassTestController@storeAnswer')->name('class-test.answer.store');
        Route::get('class-test/downlaod/{file_name}', 'ClassTestController@downloadPdf')->name('class-test.download.pdf');
        Route::get('class-test/{class_test_id}/submission/{submission_id}', 'ClassTestController@showSubmission')->name('class-test.show.submission');
        Route::post('class-test/{class_test_id}/submission/{submission_id}', 'ClassTestController@storeSubmissionMark')->name('class-test.store.submission.mark');

        Route::resource('/attendance', 'AttendanceController');
        Route::post('/start-attendance', 'AttendanceController@startAttendance')->name('attendance.start');

        Route::resource('assignment', 'AssignmentController');
        Route::post('assignment/{assignment_id}/answer', 'AssignmentController@storeAnswer')->name('assignment.answer.store');
        Route::get('assignment/downlaod/{file_name}', 'AssignmentController@downloadPdf')->name('assignment.download.pdf');
        Route::get('assignment/{assignment_id}/submission/{submission_id}', 'AssignmentController@showSubmission')->name('assignment.show.submission');
        Route::post('assignment/{assignment_id}/submission/{submission_id}', 'AssignmentController@storeSubmissionMark')->name('assignment.store.submission.mark');

        Route::resource('presentation', 'PresentationController');
        Route::post('presentation/{presentation_id}/answer', 'PresentationController@storeAnswer')->name('presentation.answer.store');
        Route::get('presentation/downlaod/{file_name}', 'PresentationController@downloadPdf')->name('presentation.download.pdf');
        Route::get('presentation/{presentation_id}/submission/{submission_id}', 'PresentationController@showSubmission')->name('presentation.show.submission');
        Route::post('presentation/{presentation_id}/submission/{submission_id}', 'PresentationController@storeSubmissionMark')->name('presentation.store.submission.mark');

        Route::get('midterm/mark-release', 'MidtermController@markRelease')->name('midterm.mark-release');
        Route::post('midterm/mark-release', 'MidtermController@storeMarkRelease')->name('midterm.store.mark-release');

        Route::get('final-exam/mark-release', 'FinalExamController@markRelease')->name('final-exam.mark-release');
        Route::post('final-exam/mark-release', 'FinalExamController@storeMarkRelease')->name('final-exam.store.mark-release');
    });

    Route::resource('/instructor', 'InstructorController');

    Route::get('/job', 'JobController@index')->name('job.index');

    Route::get('/blog', 'BlogController@index')->name('blog.index');
    Route::get('/blog/{blog}', 'BlogController@show')->name('blog.show');

    Route::resource('/library', 'LibraryController');
    Route::get('library/resource/download/{file_name}', 'LibraryController@resourceDownload')->name('library.resource.download');

    Route::get('event', 'EventController@index')->name('event.index');
    Route::get('get-event-count', 'EventController@ajaxGetEventCount')->name('ajax.event.count');
});
