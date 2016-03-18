<?php namespace App\Controllers;


use App\Models\Controller;

class StudentsController extends Controller {

    public function index() {
        $page = Input::get('page');

        $sort = Input::get('sort');

        $sorts = [
            'order', 'names', 'lectures', 'exercises', 'grade'
        ];
    }
}