<?php

namespace TaskForce\utils;

use TaskForce\exceptions\ConvertionException;
use RuntimeException;
use FilesystemIterator;
use SplFileInfo;
use SplFileObject;


class converterCSVinSQL
{
    /**
     * @var SplFileInfo[]
     */
    private array $filesToConvertCSV;

    public function getFilesArray(): array
    {
        return $this->filesToConvertCSV;
    }

    /**
     * Конструктор класса
     * @param string $directory адрес к папке с данными для таблиц БД
     */
    public function __construct(string $directory)
    {
        //
        echo $directory . PHP_EOL;
        if (!is_dir($directory)) {
            throw new ConvertionException('Директория указана не верно.');
        }
        $this->getCSVFiles($directory);
    }

    public function formSQLFiles(?string $outputDirectory): array
    {
        $result = [];
        if (!isset($outputDirectory) || !is_dir($outputDirectory)) {
            $outputDirectory = $this->filesToConvertCSV[0]->getPath();
        }
        echo $outputDirectory . PHP_EOL;
        foreach ($this->filesToConvertCSV as $file) {
            $result[] = $this->convertFile($file, $outputDirectory);
        }
        return $result;
    }


    /**
     * Получаем все CSV файлы из указанной дирректории и записываем в массив
     * @param string $directory адрес к папке с данными для таблиц БД
     * @return array[SplFileInfo] массив найденых файлов в виде экземпляров класса SplFileInfo
     * 
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

    private function convertFile(SplFileInfo $file, ?string $outputDirectory): string
    {
        //открываем файл
        //ЕСЛИ ФАЙЛ НЕ ОТКРЫВАЕТСЯ ТО ИСКЛЮЧЕНИЕ
        try {
            /**
             * @var SplFileObject
             */
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
