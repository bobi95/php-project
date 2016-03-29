<?php
namespace App\Models;


class SubjectAssessment {
    private $studentId;
    private $subjectName;
    private $subjectId;
    private $maxLectures;
    private $maxExercises;
    private $lectures;
    private $exercises;
    private $assessment;

    /**
     * @return int
     */
    public function getStudentId() {
        return $this->studentId;
    }

    /**
     * @param int $studentId
     */
    public function setStudentId($studentId) {
        $this->studentId = $studentId;
    }

    /**
     * @return string
     */
    public function getSubjectName() {
        return $this->subjectName;
    }

    /**
     * @param string $subjectName
     */
    public function setSubjectName($subjectName) {
        $this->subjectName = $subjectName;
    }

    /**
     * @return int
     */
    public function getSubjectId() {
        return $this->subjectId;
    }

    /**
     * @param int $subjectId
     */
    public function setSubjectId($subjectId) {
        $this->subjectId = $subjectId;
    }

    /**
     * @return int
     */
    public function getLectures() {
        return $this->lectures;
    }

    /**
     * @param int $lectures
     */
    public function setLectures($lectures) {
        $this->lectures = $lectures;
    }

    /**
     * @return int
     */
    public function getExercises() {
        return $this->exercises;
    }

    /**
     * @param int $exercises
     */
    public function setExercises($exercises) {
        $this->exercises = $exercises;
    }

    /**
     * @return int
     */
    public function getAssessment() {
        return $this->assessment;
    }

    /**
     * @param int $assessment
     */
    public function setAssessment($assessment) {
        $this->assessment = $assessment;
    }

    /**
     * @return int
     */
    public function getMaxLectures() {
        return $this->maxLectures;
    }

    /**
     * @param int $maxLectures
     */
    public function setMaxLectures($maxLectures) {
        $this->maxLectures = $maxLectures;
    }

    /**
     * @return int
     */
    public function getMaxExercises() {
        return $this->maxExercises;
    }

    /**
     * @param int $maxExercises
     */
    public function setMaxExercises($maxExercises) {
        $this->maxExercises = $maxExercises;
    }
}