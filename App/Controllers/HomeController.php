<?php namespace App\Controllers;

use App\Core\Controller;
use App\DataAccess\CourseRepository;
use App\DataAccess\SpecialityRepository;
use App\DataAccess\StudentRepository;
use App\DataAccess\SubjectAssessmentRepository;
use App\Helpers\Input;
use App\Models\Course;
use App\Models\Speciality;
use App\Models\Student;
use App\Models\SubjectAssessment;
use App\Services\AuthenticationService;
use App\Services\AuthorizationService;
use App\Services\PagingService;

class HomeController extends Controller {

    public function Index() {
        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        if (AuthorizationService::requireRole('administrator')) {
            return $this->redirectToAction('studentAssessments');
        }

        return $this->view();
    }

    public function StudentAssessments() {

        $page = Input::get('page');
        $sort = Input::get('sort');

        if ($sort === 'name_desc') {
            $sortType = 'DESC';
        } else {
            $sortType = 'ASC';
        }

        $sortArr = [
            'student_fname' => $sortType,
            'student_lname' => $sortType
        ];

        $studentsRepo = new StudentRepository();



        /** @var Student[] $students */
        $pagedModel = PagingService::getElements($studentsRepo, $page, 15, $sortArr);
        $students = $pagedModel['elements'];

        $saRepo = new SubjectAssessmentRepository();

        $assessments = [];
        $subjects = [];

        foreach ($students as $student) {

            /** @var SubjectAssessment[] $sa */
            $sa = $saRepo->getByStudent($student);

            $subjCollection = [];

            foreach($sa as $item) {
                $subjects[$item->getSubjectId()] = $item->getSubjectName();
                $subjCollection[$item->getSubjectId()] = $item;
            }

            $assessments[$student->getId()] = $subjCollection;
        }
/*

student 1 =>  subject 2 => assessment 1
              subject 3 => assessment 2
              subject 4 => assessment 3

student 2 =>  subject 2 => assessment 4
              subject 3 => assessment 5
              subject 4 => assessment 6
 */

        /** @var Course[] $courses */
        $courses = (new CourseRepository())->getAll();
        $courseCol = [];

        foreach ($courses as $course) {
            $courseCol[$course->getId()] = $course;
        }

        /** @var Speciality[] $specialities */
        $specialities = (new SpecialityRepository())->getAll();
        $specialityCol = [];

        foreach ($specialities as $speciality) {
            $specialityCol[$speciality->getId()] = $speciality;
        }

        $model = [
            'students' => $students,
            'subjects' => $subjects,
            'courses' => $courseCol,
            'specialities' => $specialityCol,
            'assessments' => $assessments,
            'page' => $pagedModel['page'],
            'pages' => $pagedModel['pages'],
            'numbers' => $pagedModel['numbers'],
            'count' => $pagedModel['count'],
            'params' => [
                'sort' => $sort
            ]
        ];

        return $this->view($model);
    }
}