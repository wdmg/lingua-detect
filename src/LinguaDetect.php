<?php

namespace wdmg\lingua;

/**
 * LinguaDetect
 *
 * Language detection by source text.
 *
 * Based on alphabets and language recognition chart. It describes a variety of simple clues one can use to determine
 * what language a document is written in with high accuracy. See more
 * [https://en.wikipedia.org/wiki/Wikipedia:Language_recognition_chart]
 *
 * @category        Library
 * @version         1.0.1
 * @author          Alexsander Vyshnyvetskyy <alex.vyshnyvetskyy@gmail.com>
 * @link            https://github.com/wdmg/lingua-detect
 * @copyright       Copyright (c) 2020 by W.D.M.Group, Ukraine (https://wdmg.com.ua/)
 * @license         https://opensource.org/licenses/MIT Massachusetts Institute of Technology (MIT) License
 *
 *
 * Usage:
 *
 *     $text = 'Chicago has many historic places to visit. Keith found the Chicago Water Tower impressive as it is one
 *     of the few remaining landmarks to have survived the Great Chicago Fire of 1871.';
 *     $detector = new LinguaDetect();
 *     print $detector->process($text);
 *
 */

class LinguaDetect {

    public $alphabets = [
        'en' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', // English
        'ru' => 'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя', // Russian
        'uk' => 'АБВГҐДЕЖЗІЇЙКЛМНОПРСТУФХЦЧШЩИЄЬЮЯабвгґдежзіїйклмнопрстуфхцчшщиєьюя', // Ukranian
        'fr' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZÀÂÆÇÉÈÊËÎÏÔŒÙÛÜŸabcdefghijklmnopqrstuvwxyzàâæçéèêëîïôœùûüÿ', // French (Français)
        'es' => 'AÁBCDEÉFGHIÍJKLMNÑOÓPQRSTUÚVWXYZaábcdeéfghiíjklmnñoópqrstuúvwxyz', // Spanish (Español)
        'de' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZÄÖÜẞabcdefghijklmnopqrstuvwxyzäöüß', // German (Dutch)
        'it' => 'ABCDEFGHILMNOPQRSTUVZÀÈÉÌÍÎÒÓÙÚabcdefghilmnopqrstuvzàèéìíîòóùú', // Italian (Italiano)
        'pl' => 'AĄBCĆDEĘFGHIJKLŁMNŃOÓPQRSŚTUVWXYZŹŻƵaąbcćdeęfghijklłmnńoópqrsśtuvwxyzźżƶ', // Polish (Polski)
        'hu' => 'AÁBCDEÉFGHIÍJKLMNOÓÖŐPRSTUÚÜŰVZQWXYaábcdeéfghiíjklmnoóöőprstuúüűvzqwxy', // Hungarian (Magyar)
        'el' => 'ΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩαβγδεζηθικλμνξοπρστυφχψω', // Greek (Ελληνικά)
        /*'pt' => null, // Portuguese (Português)
        'cs' => null, // Czech (Čeština)*/
    ];

    public $patterns = [
        'en' => [
            '(a|an|and|in|of|on|the|that|to|is|I)', // common words
            '\w+(th|ch|sh|ough|augh)\w+', // letter sequences
            '(ing|tion|ed|age|’s|’ve|n’t|’d)+\b', // word endings
        ],
        'ru' => [
            '[ё|й|ъ|ы|э|щ]', // consist special chars
            '\s(и|или)\s', // common one-letter word
        ],
        'uk' => [
            '[є|і|ї|ґ|є|щ]', // consist special charts
            '\s(і|або|чи|та)\s', // common one-letter word
        ],
        'fr' => [
            '[â|ç|è|é|ê|î|ô|û|ë|ï|œ|æ]', // consist special chars
            '(de|la|le|du|des|il|et)', // common words
            '\w+(l\'|d\'|c\'|j\'|m\'|n\'|s\'|t\')\w+', // apostrophised contractions
            '(aux|eux|oux)+\b', // word endings
        ],
        'es' => [
            '[á|é|í|ó|ú|¿|¡|ñ]', // consist special chars
            '(gü|güe|güi|de|el|del|los|la|las|uno|unos|una|unas)', // common words
            '\b(el|en|ll)+', // word beginnings
            '(o|a|ción|miento|dad)+\b', // word endings
        ],
        'de' => [
            '[ä|ö|ü|ß]', // consist special chars
            '\w+(ch|sch|tsch|tz|ss)\w+', // letter sequences
            '(der|die|das|den|dem|des|er|sie|es|ist|ich|du|aber)', // common words
            '(en|er|ern|st|ung|chen|tät)+\b', // word endings
        ],
        'it' => [
            '[á|é|í|ó|ú|¿|¡|ñ]', // consist special chars
            '\b(?:non|il|per|con|del)[a|e|i|o|u|è]\b', // every native word ends in a vowel
            '\w+(o|a|zione|mento|tà|aggio)+\b', // word endings
            '\s(è|e|al|del|di)\s', // common one-letter word
            '\b(la)+', // word beginnings
            '\w+à', // almost always occurs in the last letter of words
            '(gli|gn|sci)', // letter sequences
            '\w+(tt|zz|cc|ss|bb|pp|ll)\w+', // double consonants are frequent
        ],
        'pl' => [
            '[ą|ę|ć|ś|ł|ń|ó|ż|ź]', // consist special chars
            '\s(w|z|k|we|i|na)\s', // common one-letter word
            '(szcz|ść|ści|źdź|ździ|żdż|rz|sz|cz|prz|trz|jest|się)', // common words
            '\b(był|będzie|jest|być)+', // word beginnings
        ],
        'hu' => [
            '[ő|ű]', // consist special chars
            '\w+(cs|gy|ly|ny|sz|ty|zs)\w+', // letter combinations
            '(a|az|ez|egy|és|van|hogy)', // common words
            '\b(leg)+', // word beginnings
            '(obb|k)+\b', // word endings
        ],
        'el' => '[Ω|Ε|Α|Θ|Γ|Χ|Φ|Ψ|Υ|Ι|ω|ε|α|θ|γ|χ|φ|ψ|υ|ι|και|είναι|ά|έ|ή|ί|ό|ύ|ώ]',
    ];

    public function process($string = null, $detailed = false) {

        $max = 0;
        $summary = 0;
        $rate = [];
        $scores = [];
        $language = null;

        // Step 1
        $chars = str_split($string);
        foreach ($chars as $char) {
            foreach ($this->alphabets as $lang => $alphabet) {

                if (is_null($alphabet))
                    continue;

                if (!isset($scores[$lang]))
                    $scores[$lang] = ['count' => 0, 'score' => 0];

                $count = intval($scores[$lang]['count']);
                $score = intval($scores[$lang]['score']);

                if (preg_match("/[$alphabet]/", $char)) {
                    $score += 1;
                }

                $count++;
                $scores[$lang]['count'] = $count;
                $scores[$lang]['score'] = $score;
            }
        }

        // Step 2
        $words = preg_split("/[\s,]+/", $string, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($words as $word) {
            foreach ($this->patterns as $lang => $pattern) {

                if (!isset($scores[$lang]))
                    $scores[$lang] = ['count' => 0, 'score' => 0];

                $count = intval($scores[$lang]['count']);
                $score = intval($scores[$lang]['score']);

                if (is_array($pattern)) {

                    $hasMatch = false;
                    foreach ($pattern as $value) {
                        if (preg_match("/$value/u", " " . $word. " ")) {
                            $hasMatch = true;
                        }
                    }

                    if ($hasMatch)
                        $score += 10;

                } else {

                    if (preg_match("/$pattern/", $word))
                        $score += 10;

                }

                $count++;
                $scores[$lang]['count'] = $count;
                $scores[$lang]['score'] = $score;
            }
        }

        // Results
        foreach (array_keys($this->alphabets) as $lang) {

            if (!isset($rate[$lang]))
                $rate[$lang] = 0;

            if (isset($scores[$lang])) {
                $score = ($scores[$lang]['score'] / $scores[$lang]['count']);
                $rate[$lang] = round($score, 4);
                $summary += $score;

                if ($score > $max) {
                    $max = $score;
                    $language = $lang;
                }
            }
        }

        if ($detailed)
            return [
                'language' => $language,
                'rate' => $rate
            ];
        else
            return $language;
    }
}