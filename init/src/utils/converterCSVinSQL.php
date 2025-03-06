<?php

namespace TaskForce\utils;

use TaskForce\exceptions\ConvertionException;
use RuntimeException;
use FilesystemIterator;
use SplFileInfo;
use SplFileObject;

/*
Возможно доработка:
Передача иной имени таблицы
Передача иных имен столбцов
*/

class converterCSVinSQL
{
    /**
     * @var SplFileInfo[]
     */
    private ?array $filesToConvertCSV = null;
    private ?SplFileInfo $fileInfo = null;
    /**
     * @var string[]
     */
    private ?array $convertedFiles = null;

    /**
     * Отображает файлы, выбранные к обработке
     * @return SplFileInfo[] | SplFileInfo объект или массив объектов-файлов
     */
    public function getFilesArray(): array | SplFileInfo
    {
        return ($this->filesToConvertCSV) ?? $this->fileInfo;
    }

    /**
     * Конструктор класса
     * @param string $directory адрес к папке с данными для таблиц БД или файлу
     * @throws ConvertionException, если неверный формат файла или неверная дирректория
     * @throws UnexpectedValueException, если директория directory не существует
     * @throws ValueError, если параметр directory содержит пустую строку или дирректория для выходных данных не существует
     */
    public function __construct(string $directory): void
    {
        //
        echo $directory . PHP_EOL;
        if (is_dir($directory)) {
            $this->getCSVFiles($directory);
        } else if (is_file($directory)) {
            $fileinfo = new SplFileInfo($directory);
            if ($fileinfo->getExtension() !== "csv") {
                throw new ConvertionException('Выбран файл неверного формата');
            }
            $this->fileInfo = $fileinfo;
        } else {
            throw new ConvertionException('Директория указана не верно.');
        }
    }

    /**
     * Обрабатывает с конвертирует файл(ы) в указанную директорию
     * @param ?string $outputDirectory Путь к папке, в которую произойдет конвертация
     * @return array Массив путей к итоговым сконвертированным файлам
     * @throws ConvertionException, если не удается открыть файл
     */
    public function formSQLFiles(?string $outputDirectory): array
    {
        if (isset($this->filesToConvertCSV)) {
            if (!isset($outputDirectory) || !is_dir($outputDirectory)) {
                $outputDirectory = $this->filesToConvertCSV[0]->getPath();
            }
            foreach ($this->filesToConvertCSV as $file) {
                $result[] = $this->convertFile($file, $outputDirectory);
            }
        } else {
            if (!isset($outputDirectory) || !is_dir($outputDirectory)) {
                $outputDirectory = $this->fileInfo->getPath();
            }
            $result[] = $this->convertFile($this->fileInfo, $outputDirectory);
        }

        $this->convertedFiles = $result;
        return $result;
    }

    /**
     * Функция вывода результата конвертации
     */
    public function printConvertionResult(): void
    {
        if ($this->convertedFiles) {
            echo "Сконвертированы новые файлы:" . PHP_EOL;
            foreach ($this->convertedFiles as $convertedFile) {
                echo "Путь нового файла:" . $convertedFile . PHP_EOL;
            }
        } else {
            echo "Нет сконвертированных файлов" . PHP_EOL;
        }
    }


    /**
     * Получаем все CSV файлы из указанной дирректории и записываем в массив
     * @param string $directory адрес к папке с данными для таблиц БД
     * @throws UnexpectedValueException, если директория directory не существует
     * @throws ValueError, если параметр directory содержит пустую строку
     */
    private function getCSVFiles(string $directory): void
    {
        $iterator = new FilesystemIterator($directory, FilesystemIterator::CURRENT_AS_FILEINFO);
        foreach ($iterator as $fileinfo) {
            if ($fileinfo->getExtension() === "csv") {
                $this->filesToConvertCSV[] = $fileinfo;
            }
        }
    }

    /**
     * Конвертация файла
     * @param SplFileInfo $file объект файла для конвертации
     * @param ?string $outputDirectory путь к дирректории для вставки файла, если нет то будет вставлен в исходную
     * @return string имя и путь сформированного файла
     */
    private function convertFile(SplFileInfo $file, ?string $outputDirectory): string
    {
        try {
            $fileObject = new SplFileObject($file->getRealPath());
            $fileObject->setFlags(SplFileObject::READ_CSV);
        } catch (RuntimeException $exception) {
            throw new ConvertionException("Не удалось открыть файл на чтение");
        }
        //получаем имя файла = имя будущей таблицы SQL без '.csv'
        $tableName = $file->getBasename(".csv");
        //значения первой строки - имена столбцов таблицы
        $columns = $fileObject->fgetcsv();
        //получаем значения для выделенных полей
        $values = [];
        //проходим по каждой строке до конца файла
        while (!$fileObject->eof()) {
            $values[] = $fileObject->fgetcsv();
        }
        //из полученных данных формируем sql
        $sqlContent = $this->getSqlContent($tableName, $columns, $values);
        return $this->saveSqlContent($tableName, $outputDirectory, $sqlContent);
    }

    /**
     * Формирование sql-запроса
     * @param string $tableName
     * @param array $columns
     * @param array $data
     * @return string строка sql-запроса
     */
    private function getSqlContent(string $tableName, array $columns, array $data): string
    {
        $columnsString = implode(', ', $columns);
        $sql =  "INSERT INTO $tableName ($columnsString) VALUES ";

        foreach ($data as $row) {
            array_walk($row, function (&$value) {
                $value = addslashes($value);
                $value = "'$value'";
            });

            $sql .= "( " . implode(', ', $row) . "), ";
        }

        $sql = substr($sql, 0, -2);

        return $sql;
    }

    /**
     * Формирование файла и сохраниение SQL
     * @param string $tableName имя таблицы, которое станет названием файла
     * @param string $directory Путь для сохранения файла
     * @param string $content Содержитое файла
     * @return string имя и путь сформированного файла
     */
    private function saveSqlContent(string $tableName, string $directory, string $content): string
    {
        if (!is_dir($directory)) {
            throw new ConvertionException('Директория для выходных файлов не существует');
        }

        $filename = $directory . DIRECTORY_SEPARATOR . $tableName . '.sql';
        file_put_contents($filename, $content);

        return $filename;
    }
}
