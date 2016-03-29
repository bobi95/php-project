<?php namespace App\DataAccess;


use App\Models\Student;
use App\Models\SubjectAssessment;

class SubjectAssessmentRepository {
    private $db;

    public function __construct() {
        $this->db = DB::getInstance();
    }

    public function getByStudent(Student $student) {
        $entity = $this->db->queryAll(self::$sql, [
            ':sa_student_id' => $student->getId()
        ]);

        $result = [];

        if (!empty($entity)) {
            foreach ($entity as $item) {
                $result[] = self::mapModel($item);
            }
        }

        return $result;
    }

    private static function mapModel($entity) {
        $model = new SubjectAssessment();
        $model->setStudentId($entity->sa_student_id);
        $model->setSubjectId($entity->subject_id);
        $model->setSubjectName($entity->subject_name);
        $model->setMaxLectures($entity->max_lectures);
        $model->setMaxExercises($entity->max_exercises);
        $model->setLectures($entity->sa_workload_lectures);
        $model->setExercises($entity->sa_workload_exercises);
        $model->setAssessment($entity->sa_assesment);
        return $model;
    }

    private static $sql = <<<TAG
select  sa.sa_student_id,
        su.subject_id,
        su.subject_name,
        su.subject_workload_lectures as max_lectures,
        su.subject_workload_exercises as max_exercises,
        sa.sa_workload_lectures,
        sa.sa_workload_exercises,
        sa.sa_assesment
from `students_assessments` as sa

join `subjects` as su
    on su.subject_id = sa.sa_subject_id

where sa.sa_student_id = :sa_student_id
TAG;

}