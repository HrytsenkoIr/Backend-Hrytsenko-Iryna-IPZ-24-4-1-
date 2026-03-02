<?php
namespace Classes;

/**
 * Клас FileManager для роботи з текстовими файлами.
 */
class FileManager {
    /** @var string Директорія з файлами */
    public static $dir = "text";

    /**
     * Дописує рядок у файл.
     * @param string $filename
     * @param string $content
     */
    public static function writeToFile($filename, $content) {
        if (!is_dir(self::$dir)) mkdir(self::$dir, 0777, true);
        file_put_contents(self::$dir . '/' . $filename, $content . PHP_EOL, FILE_APPEND);
    }

    /**
     * Читає вміст файлу.
     * @param string $filename
     * @return string
     */
    public static function readFromFile($filename) {
        $path = self::$dir . '/' . $filename;
        return file_exists($path) ? file_get_contents($path) : "Файл не знайдено";
    }

    /**
     * Очищує вміст файлу.
     * @param string $filename
     */
    public static function clearFile($filename) {
        $path = self::$dir . '/' . $filename;
        if (file_exists($path)) {
            file_put_contents($path, "");
        }
    }
}