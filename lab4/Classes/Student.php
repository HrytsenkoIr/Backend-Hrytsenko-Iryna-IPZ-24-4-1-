<?php
namespace Classes;

/**
 * Клас Student, що успадковує Human.
 */
class Student extends Human {
    /** @var string Назва ВНЗ */
    private $university;
    /** @var int Поточний курс */
    private $course;

    /**
     * @param float $h Зріст
     * @param float $w Маса
     * @param int $age Вік
     * @param string $uni ВНЗ
     * @param int $course Курс
     */
    public function __construct($h, $w, $age, $uni = "", $course = 1) {
        parent::__construct($h, $w, $age);
        $this->university = $uni;
        $this->course = $course;
    }

    protected function birthNotification() {
        return "Студент народився! Повідомлення при народженні дитини.";
    }

    /**
     * @return string
     */
    public function getUniversity() { return $this->university; }
    /**
     * @param string $uni
     */
    public function setUniversity($uni) { $this->university = $uni; }
    /**
     * @return int
     */
    public function getCourse() { return $this->course; }
    /**
     * @param int $c
     */
    public function setCourse($c) { $this->course = $c; }

    /**
     * Переводить студента на новий курс (збільшує на 1).
     */
    public function nextCourse() {
        $this->course++;
    }

    /**
     * @return string
     */
    public function cleanRoom() {
        return "Студент прибирає кімнату";
    }

    /**
     * @return string
     */
    public function cleanKitchen() {
        return "Студент прибирає кухню";
    }
}