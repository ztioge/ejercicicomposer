<?php

namespace Mascame\VideoChecker;

/**
 * Class VimeoProvider
 * @package Mascame\VideoChecker
 */
class VimeoProvider extends AbstractChecker {

    /**
     * @var string
     */
    protected $url = 'https://player.vimeo.com/video/{id}';

}