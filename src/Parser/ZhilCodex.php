<?php


namespace App\Parser;


use App\Repository\ArticleRepository;
use App\Repository\HeadingRepository;

class ZhilCodex extends Parser
{
    const SECTION   = '\pard\plain\outlinelevel0\s2\f2\fs24\qc\fi0\li0\b\i0\nosupersub\ul0\strike0\itap0';
    const CHAPTER   = '\pard\plain\outlinelevel1\s2\f2\fs24\qc\fi0\li0\b\i0\nosupersub\ul0\strike0\itap0';

    const ARTICLE_1 = '\pard\plain\outlinelevel2\s2\f2\fs24\qj\fi540\li0\b\i0\nosupersub\ul0\strike0\itap0';
    const ARTICLE_2 = '\pard\plain\outlinelevel1\s2\f2\fs24\qj\fi540\li0\b\i0\nosupersub\ul0\strike0\itap0';
    const ARTICLE_3 = '\pard\plain\outlinelevel2\s2\f2\fs24\qj\fi540\li0\b\i0\nosupersub\ul0\strike0\sb300\itap0';
    const ARTICLE_4 = '\pard\plain\outlinelevel1\s2\f2\fs24\qj\fi540\li0\b\i0\nosupersub\ul0\strike0\sb300\itap0';

    const BLOCK_NOTE = '\pard\plain\s0\f0\fs24\qj\fi0\li0\b0\i0\nosupersub\ul0\strike0\itap0';
    const HEADER_NOTE = '\pard\plain\s0\f0\fs24\qc\fi0\li0\b0\i0\nosupersub\ul0\strike0\itap0';

    const NL = '\pard\plain\itap0';
    const HEADER_NL = '\pard\plain\s2\f2\fs24\qc\fi0\li0\b\i0\nosupersub\ul0\strike0\itap0';

    const PARAGRAF_1 = '\pard\plain\s0\f0\fs24\qj\fi540\li0\b0\i0\nosupersub\ul0\strike0\itap0';
    const PARAGRAF_2 = '\pard\plain\s0\f0\fs24\qj\fi540\li0\b0\i0\nosupersub\ul0\strike0\sb240\itap0';
    const PARAGRAF_3 = '\pard\plain\s0\f0\fs24\qj\fi540\li0\b0\i0\nosupersub\ul0\strike0\sb300\itap0';

    const END    = '\par';


    private function getPatternsArray()
    {
        return [
            self::NL,
            self::SECTION,
            self::CHAPTER,
            self::ARTICLE_1,
            self::ARTICLE_2,
            self::ARTICLE_3,
            self::ARTICLE_4,
            self::HEADER_NL,
            self::BLOCK_NOTE,
            self::HEADER_NOTE,
            self::PARAGRAF_1,
            self::PARAGRAF_2,
            self::PARAGRAF_3,
        ];
    }


    public function parse()
    {
        $this->fileContent = $this->prepareContent();

//        $fp = fopen("editable.rtf", "w");
//        fwrite($fp, $this->fileContent);
//        fclose($fp);

        $lines = explode(PHP_EOL, $this->fileContent);

        $sectionPattern = $this->preparePattern(self::SECTION) . '(.+)' . $this->preparePattern(self::END);
        $chapterPattern = $this->preparePattern(self::CHAPTER) . '(.+)' . $this->preparePattern(self::END);
        $articlePattern = '(' .
            $this->preparePattern(self::ARTICLE_1) . '|' .
            $this->preparePattern(self::ARTICLE_2) . '|' .
            $this->preparePattern(self::ARTICLE_3) . '|' .
            $this->preparePattern(self::ARTICLE_4) . ')' .
            '(.+)' . $this->preparePattern(self::END);
        $headerNotePattern = $this->preparePattern(self::HEADER_NOTE) . '(.+)' . $this->preparePattern(self::END);

        $section = null;
        $chapter = null;
        $article = null;

        $sectionId = '';
        $chapterId = '';
        $articleId = '';

        $articleRep = new ArticleRepository(db());
        $headingRep = new HeadingRepository(db());

        try {
            foreach ($lines as $line) {
                if ($line) {
                    if (preg_match('/' . $sectionPattern . '/', $line, $match)) {
                        $title = $this->convert($match[1]);
                        $secNumName = $this->parseSection($title);
                        $section = [
                            'title' => $title,
                            'number' => $this->roman2arabic($secNumName[0]),
                            'name' => $secNumName[1],
                        ];
                        $sectionId = $headingRep->findSectionByNumberAndSave($section);
                        $chapter = null; $chapterId = '';
                        $article = null; $articleId = '';
                    } elseif (preg_match('/' . $chapterPattern . '/', $line, $match)) {
                        $title = $this->convert($match[1]);
                        $chaptNumName = $this->parseChapter($title);
                        $chapter = [
                            'title' => $title,
                            'number' => $chaptNumName[0],
                            'name' => $chaptNumName[1],
                            'parent_id' => $sectionId,
                        ];
                        $chapterId = $headingRep->findChapterByNumberAndSave($chapter);
                        $article = null; $articleId = '';
                    } elseif (preg_match('/' . $headerNotePattern . '/', $line, $match)) {
                        $note = $this->convert($match[1]);
                        if ($article) {
                            $data = [
                                'id' => $articleId,
                                'note' => $note,
                            ];
                            $r = $articleRep->save($data);
                        } elseif ($chapter) {
                            $data = [
                                'id' => $chapterId,
                                'note' => $note,
                            ];
                            $r = $headingRep->save($data);
                        } elseif($section) {
                            $data = [
                                'id' => $sectionId,
                                'note' => $note,
                            ];
                            $r = $headingRep->save($data);
                        }
                    } elseif (preg_match('/' . $articlePattern . '/', $line, $match)) {
                        $title = $this->convert($match[2]);
                        $artNumName = $this->parseArticle($title);
                        $article = [
                            'title' => $title,
                            'number' => $artNumName[0],
                            'name' => $artNumName[1],
                            'parent_id' => $chapterId ?: $sectionId,
                            'description' => 'Жилищный кодекс РФ: ' . $title,
                            'updated' => date('Y-m-d'),
                            'content' => '',
                        ];
                        $articleId = $articleRep->findArticleByNumberAndSave($article);
                    } else {
                        if ($article) {
                            $article['content'] .= $this->convert($line) . PHP_EOL;
                            $article['id'] = $articleId;

                            $r = $articleRep->save($article);
                        }
                    }

                }
            }
        } finally {
            unset($articleRep);
            unset($headingRep);
        }
    }

    private function prepareContent()
    {
        $content = $this->fileContent;

        // возврат каретки, новая строка, табуляция
        $content = preg_replace('/[\r\n\t]+/', '', $content);

        // пустые блоки
        $patterns = $this->getPatternsArray();
        foreach ($patterns as $pattern) {
            $pattern = '/' . $this->preparePattern($pattern) . $this->preparePattern(self::END) . '/';
            $content = preg_replace($pattern, '', $content);
        }

        // переносы в заголовках разделов и глав
        $pattern = '/' . $this->preparePattern(self::END) . $this->preparePattern(self::HEADER_NL) . '/';
        $content = preg_replace($pattern, ' ', $content);

        // абзацы в статьях
        $pattern = '/(' . $this->preparePattern(self::PARAGRAF_1) .'|'.
            $this->preparePattern(self::PARAGRAF_2) . '|' .
            $this->preparePattern(self::PARAGRAF_3) .')(.+)'.
            $this->preparePattern(self::END) . '/U';
        $content = preg_replace_callback($pattern, function ($match) {
            if ($match) {
                return PHP_EOL . '<p>' . trim($match[2]) . '</p>' . PHP_EOL;
            }
        }, $content);

        // примечания в статьях
        $pattern = '/' . $this->preparePattern(self::BLOCK_NOTE) . '(.+)'. $this->preparePattern(self::END) . '/U';
        $content = preg_replace_callback($pattern, function ($match) {
            if ($match) {
                return PHP_EOL . '<p class="note">' . trim($match[1]) . '</p>' . PHP_EOL;
            }
        }, $content);

        // примечание К+
        $pattern = '/\\{\\\\trowd.+\\\\row\\}/U';
        $content = preg_replace($pattern, '', $content);

        // ссылки
        $pattern = '/\\}\{\\\\fldrslt\\\\cf2(.+)\\}\\}/U';
        $content = preg_replace_callback($pattern, function ($match) {
            if ($match) {
                return trim($match[1]);
            }
        }, $content);

        // остальное в фигурных скобках
        $pattern = '/\{.+\}/U';
        $content = preg_replace($pattern, '', $content);

        // с новой строки
        foreach ($patterns as $pattern) {
            $content = preg_replace('/' . $this->preparePattern($pattern). '/', PHP_EOL . $pattern, $content);
        }

        return $content;
    }
}