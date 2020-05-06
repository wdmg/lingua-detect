[![Downloads](https://img.shields.io/packagist/dt/wdmg/lingua-detect.svg)](https://packagist.org/packages/wdmg/lingua-detect)
[![Packagist Version](https://img.shields.io/packagist/v/wdmg/lingua-detect.svg)](https://packagist.org/packages/wdmg/lingua-detect)
![Progress](https://img.shields.io/badge/progress-ready_to_use-green.svg)
[![GitHub license](https://img.shields.io/github/license/wdmg/lingua-detect.svg)](https://github.com/wdmg/lingua-detect/blob/master/LICENSE)


# LinguaDetect

Language detection by source text.

Based on alphabets and language recognition chart. It describes a variety of simple clues one can use to determine
what language a document is written in with high accuracy. See more [https://en.wikipedia.org/wiki/Wikipedia:Language_recognition_chart]

Support `en`, `ru`, `uk`, `fr`, `es`, `de`, `it`, `pl`, `hu`, `el` locales.

# Requirements 
* PHP 5.6 or higher

# Installation
To install the library, run the following command in the console:

`$ composer require "wdmg/lingua-detect"`

# Usage

    <?php
    
        $text = 'Chicago has many historic places to visit. Keith found the Chicago Water Tower impressive as it is one
        of the few remaining landmarks to have survived the Great Chicago Fire of 1871.';
        $detector = new LinguaDetect();
        print $detector->process($text);
    
    ?>

# Status and version [ready to use]
* v.1.0.1 - Added namespace
* v.1.0.0 - Added LinguaDetect() class

# Copyrights
* Copyright (c) 2020 W.D.M.Group, Ukraine (https://wdmg.com.ua/)
* Copyright (c) 2020 by Alexsander Vyshnyvetskyy <alex.vyshnyvetskyy@gmail.com>