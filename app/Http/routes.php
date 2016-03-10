<?php

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

Route::group(['middleware' => ['web']], function () {

    /**
     * List all courses
     */

    Route::get('/painel', function () {
        $courses = Course::orderBy('created_at', 'asc')->get();

        return view('courses', [
            'courses' => $courses
        ]);
    });

    /**
     * Add a course
     */

    Route::post('/course', function (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/painel')
                ->withInput()
                ->withErrors($validator);
        }

        $course = new Course();
        $course->name = $request->name;
        $course->date = $request->date;
        $course->save();

        return redirect('/painel');

    });

    /**
     * Delete a course
     */

    Route::delete('/course/{course}', function (Course $course) {
        $course->delete();

        return redirect('/painel');
    });
});




Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/', 'HomeController@index');
    Route::get('/template', 'HomeController@chat');
});
