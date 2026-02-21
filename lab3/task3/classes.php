<?php

class Guestbook {
    private $filename = 'comments.txt';

    public function addComment($name, $comment) {
        $data = $name . "|" . $comment . PHP_EOL;
        file_put_contents($this->filename, $data, FILE_APPEND);
    }

    public function getComments() {
        if (!file_exists($this->filename)) return [];
        $comments = [];
        $fp = fopen($this->filename, "r");

        while (($line = fgets($fp)) !== false) {
            $comments[] = explode("|", trim($line));
        }
        fclose($fp);
        return $comments;
    }
}

class FileSetManager {
    public function processFiles($file1, $file2) {
        $arr1 = explode(' ', file_get_contents($file1));
        $arr2 = explode(' ', file_get_contents($file2));

        $onlyFirst = array_diff($arr1, $arr2);
        file_put_contents('only_first.txt', implode(' ', $onlyFirst));

        $both = array_intersect($arr1, $arr2);
        file_put_contents('both.txt', implode(' ', $both));

        $freq1 = array_filter(array_count_values($arr1), fn($v) => $v > 2);
        $freq2 = array_filter(array_count_values($arr2), fn($v) => $v > 2);
        file_put_contents('more_than_two.txt', implode(' ', array_keys($freq1)) . " | " . implode(' ', array_keys($freq2)));
    }

    public function deleteFile($filename) {
        if (file_exists($filename) && in_array($filename, ['only_first.txt', 'both.txt', 'more_than_two.txt'])) {
            unlink($filename);
            return "Файл $filename успішно видалено.";
        }
        return "Файл не знайдено або доступ заборонено.";
    }
}

class WordSorter {
    public function sortWords($filename) {
        $content = file_get_contents($filename);
        $words = preg_split('/\s+/', $content, -1, PREG_SPLIT_NO_EMPTY);
        sort($words);
        file_put_contents('sorted_words.txt', implode("\n", $words));
    }
}