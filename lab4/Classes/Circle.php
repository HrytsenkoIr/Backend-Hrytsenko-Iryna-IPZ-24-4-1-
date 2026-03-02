<?php
namespace Classes;

/**
 * Клас Circle для роботи з колом.
 */
class Circle {
    /** @var float Координата X */
    private $x;
    /** @var float Координата Y */
    private $y;
    /** @var float Радіус */
    private $radius;

    /**
     * @param float $x
     * @param float $y
     * @param float $radius
     */
    public function __construct($x, $y, $radius) {
        $this->x = $x;
        $this->y = $y;
        $this->radius = $radius;
    }

    /**
     * Повертає опис кола.
     * @return string
     */
    public function __toString() {
        return "Коло з центром в ({$this->x}, {$this->y}) і радіусом {$this->radius}";
    }

    /**
     * @return float
     */
    public function getX() { return $this->x; }
    /**
     * @param float $x
     */
    public function setX($x) { $this->x = $x; }
    /**
     * @return float
     */
    public function getY() { return $this->y; }
    /**
     * @param float $y
     */
    public function setY($y) { $this->y = $y; }
    /**
     * @return float
     */
    public function getRadius() { return $this->radius; }
    /**
     * @param float $r
     */
    public function setRadius($r) { $this->radius = $r; }

    /**
     * Перевірка перетину з іншим колом.
     * @param Circle $other
     * @return bool
     */
    public function intersects(Circle $other) {
        $dist = sqrt(pow($this->x - $other->x, 2) + pow($this->y - $other->y, 2));
        return $dist < ($this->radius + $other->radius);
    }
}