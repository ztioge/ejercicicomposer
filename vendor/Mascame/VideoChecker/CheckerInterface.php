<?php

namespace Mascame\VideoChecker;

/**
 * Interface CheckerInterface
 * @package Mascame\VideoChecker
 */
interface CheckerInterface {

    /**
     * @param $id
     * @param null $country
     * @return mixed
     */
    public function check($id, $country = null);

}