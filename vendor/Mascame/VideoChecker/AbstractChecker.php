<?php

namespace Mascame\VideoChecker;

/**
 * Class AbstractChecker
 * @package Mascame\VideoChecker
 */
abstract class AbstractChecker implements CheckerInterface {

    /**
     * @var null
     */
    protected $url = null;

    /**
     * @throws \Exception
     */
    public function __construct() {
        if (! $this->url) {
            throw new \Exception('No url provided for ' . get_called_class());
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function buildURL($id, $url = null) {
        if (! $url) $url = $this->url;

        return str_replace('{id}', $id, $url);
    }

    /**
     * @param string|array $id
     * @return bool|array
     */
    public function check($id, $country = null) {
        if (is_array($id)) {
            $results = [];

            foreach ($id as $videoId) {
                $results[$videoId] = $this->check($videoId, $country);
            }

            return $results;
        }

        $headers = get_headers($this->buildURL($id));

        if (! $headers) return false;

        return (strpos($headers[0], '200 OK') !== false);
    }
}