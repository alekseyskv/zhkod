<?php

namespace App\Parser;


class Parser implements IParser
{
    protected $fileContent;

    public function __construct($filePath)
    {
        if (file_exists($filePath) ) {
            $this->fileContent = file_get_contents($filePath);
        } else {
            $this->fileContent = '';
        }
    }

    public function parse()
    {

    }

    protected function preparePattern($pattern)
    {
        $str = str_replace('\\', '\\\\', $pattern);
        return $str;
    }

    protected function convert($string)
    {
        return iconv('windows-1251', 'utf-8', $string);
    }

    protected function parseSection($string)
    {
        if (preg_match('/^раздел\s([0-9IVXLCDM\\.]+)\\.\s(.+)$/iu', $string, $match)) {
            array_shift($match);
            return $match;
        }
    }

    protected function parseChapter($string)
    {
        if (preg_match('/^глава\s([0-9\\.]+)\\.\s(.+)$/iu', $string, $match)) {
            array_shift($match);
            return $match;
        }
    }

    protected function parseArticle($string)
    {
        if (preg_match('/^статья\s([0-9\\.]+)\\.\s(.+)$/iu', $string, $match)) {
            array_shift($match);
            return $match;
        }
    }

    protected function roman2arabic($roman)
    {
        $suffix = '';
        if (preg_match('/([IVXLCDM]+)\\.(\d+)/i', $roman, $match)) {
            $roman = $match[1];
            $suffix = '.' . $match[2];
        }

        $map = [
            'I' => 1,
            'II' => 2,
            'III' => 3,
            'IV' => 4,
            'V' => 5,
            'VI' => 6,
            'VII' => 7,
            'VIII' => 8,
            'IX' => 9,
            'X' => 10,
            'XI' => 11,
            'XII' => 12,
            'XIII' => 13,
            'XIV' => 14,
            'XV' => 15,
            'XVI' => 16,
            'XVII' => 17,
            'XVIII' => 18,
            'XIX' => 19,
            'XX' => 20,
        ];
        if (isset($map[$roman])) {
            return str_pad($map[$roman], 2, '0', STR_PAD_LEFT) . $suffix;
        }
        return '';
    }
}