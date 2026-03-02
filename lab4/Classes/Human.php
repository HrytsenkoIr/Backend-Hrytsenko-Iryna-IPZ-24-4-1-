<?php
namespace Classes;

/**
 * Абстрактний клас Human, що описує загальні властивості людини.
 * Реалізує інтерфейс HouseCleaning.
 */
abstract class Human implements HouseCleaning {
    /** @var float Зріст людини */
    protected $height;
    /** @var float Маса людини */
    protected $weight;
    /** @var int Вік людини */
    protected $age;

    /**
     * Конструктор класу Human.
     * @param float $h Зріст
     * @param float $w Маса
     * @param int $age Вік
     */
    public function __construct($h, $w, $age) {
        $this->height = $h;
        $this->weight = $w;
        $this->age = $age;
    }

    /**
     * Абстрактний метод для повідомлення про народження дитини.
     */
    abstract protected function birthNotification();

    /**
     * Метод "Народження дитини", що викликає абстрактний метод birthNotification.
     */
    public function birth() {
        return $this->birthNotification();
    }

    /**
     * @return float
     */
    public function getHeight() { return $this->height; }
    /**
     * @param float $h
     */
    public function setHeight($h) { $this->height = $h; }
    /**
     * @return float
     */
    public function getWeight() { return $this->weight; }
    /**
     * @param float $w
     */
    public function setWeight($w) { $this->weight = $w; }
    /**
     * @return int
     */
    public function getAge() { return $this->age; }
    /**
     * @param int $age
     */
    public function setAge($age) { $this->age = $age; }
}