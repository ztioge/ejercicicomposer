<?php

namespace Mascame\VideoChecker;

/**
 * Class DailymotionProvider
 * @package Mascame\VideoChecker
 */
class DailymotionProvider extends AbstractChecker {

    /**
     * @var string
     */
    protected $url = 'https://api.dailymotion.com/video/{id}';

}