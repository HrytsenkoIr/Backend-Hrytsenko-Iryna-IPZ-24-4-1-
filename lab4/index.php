<?php
/**
 * Файл для демонстрації функціоналу лабораторної роботи №4.
 */

require_once 'autoload.php';

use Models\UserModel;
use Controllers\UserController;
use Views\UserView;
use Classes\Circle;
use Classes\FileManager;
use Classes\Student;
use Classes\Programmer;
use Classes\HouseCleaning;

echo "<h2>Лабораторна робота №4</h2>";

echo "<b>1. MVC та Автозавантаження</b><br>";
$model = new UserModel();
$controller = new UserController();
$view = new UserView();

echo "Model: " . $model->getName() . "<br>";
echo "Controller: " . $controller->index() . "<br>";
echo "View: " . $view->render() . "<br><br>";

echo "<b>2. Клас Circle (Інкапсуляція, __toString)</b><br>";
$c1 = new Circle(10, 10, 5);
$c2 = new Circle(12, 12, 3);

echo "Об'єкт 1: " . $c1 . "<br>";
echo "Об'єкт 2: X=" . $c2->getX() . ", Y=" . $c2->getY() . ", R=" . $c2->getRadius() . "<br>";
echo "Перетин: " . ($c1->intersects($c2) ? "Так" : "Ні") . "<br>";

$c2->setX(20);
echo "Після переміщення об'єкта 2 на X=20 перетин: " . ($c1->intersects($c2) ? "Так" : "Ні") . "<br><br>";

echo "<b>3. FileManager (Статика та Файли)</b><br>";
echo "Директорія: " . FileManager::$dir . "<br>";

$testFile = "log.txt";
FileManager::writeToFile($testFile, "Запис: " . date('H:i:s'));

$content = trim(FileManager::readFromFile($testFile));
$lines = explode(PHP_EOL, $content);
echo "Останній запис у $testFile: " . end($lines) . "<br>";

echo "Файли в директорії: ";
$files = glob("text/*.txt");
$fileNames = array_map('basename', $files);
echo implode(", ", $fileNames) . "<br>";

FileManager::clearFile("file3.txt");
echo "Файл file3.txt очищено методом clearFile.<br><br>";

echo "<b>4. Наслідування та Інтерфейси (Human, Student, Programmer)</b><br>";

$student = new Student(180, 75, 20, "КНУ", 3);
$programmer = new Programmer(190, 85, 28, 5);

$student->setWeight(78);
$programmer->setHeight(195);

echo "Поліморфізм (birth):<br>";
echo "- " . $student->birth() . "<br>";
echo "- " . $programmer->birth() . "<br>";

echo "Методи інтерфейсу HouseCleaning:<br>";
$people = [$student, $programmer];
foreach ($people as $person) {
    echo get_class($person) . ": " . $person->cleanRoom() . ", " . $person->cleanKitchen() . "<br>";
}

echo "Специфічні методи:<br>";
echo "Студент: курс " . $student->getCourse();
$student->nextCourse();
echo " -> " . $student->getCourse() . "<br>";

$programmer->addLanguage("PHP");
echo "Програміст: мови (" . implode(", ", $programmer->getLanguages()) . "), ";
echo "зріст " . $programmer->getHeight() . " см.<br>";
