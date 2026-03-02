<?php
namespace Classes;

/**
 * Клас Programmer, що успадковує Human.
 */
class Programmer extends Human {
    /** @var array Масив мов програмування */
    private $languages = [];
    /** @var int Досвід роботи */
    private $experience;

    /**
     * @param float $h Зріст
     * @param float $w Маса
     * @param int $age Вік
     * @param int $exp Досвід
     */
    public function __construct($h, $w, $age, $exp = 0) {
        parent::__construct($h, $w, $age);
        $this->experience = $exp;
    }

    protected function birthNotification() {
        return "Програміст народився! Повідомлення при народженні дитини.";
    }

    /**
     * @return array
     */
    public function getLanguages() { return $this->languages; }
    /**
     * @param array $langs
     */
    public function setLanguages($langs) { $this->languages = $langs; }
    
    /**
     * Додає нову мову в масив.
     * @param string $lang
     */
    public function addLanguage($lang) {
        $this->languages[] = $lang;
    }

    /**
     * @return int
     */
    public function getExperience() { return $this->experience; }
    /**
     * @param int $exp
     */
    public function setExperience($exp) { $this->experience = $exp; }

    /**
     * @return string
     */
    public function cleanRoom() {
        return "Програміст прибирає кімнату";
    }

    /**
     * @return string
     */
    public function cleanKitchen() {
        return "Програміст прибирає кухню";
    }
}