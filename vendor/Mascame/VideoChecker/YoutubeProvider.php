<?php

namespace Mascame\VideoChecker;

/**
 * Class YoutubeProvider
 * @package Mascame\VideoChecker
 */
class YoutubeProvider extends AbstractChecker {

    /**
     * @var null
     */
    private $apiKey = null;

    /**
     * @var null
     */
    protected $apiResponse = null;

    /**
     * @var string
     */
    protected $url = 'https://www.youtube.com/watch?v={id}';

    /**
     * @var string
     */
    protected $checkRegex = "/id=\\\"player-unavailable\\\" class=\\\".*(hid\\s).*?\\\"/";

    /**
     * @var array
     */
    protected $storedIds = [];

    /**
     * @var int
     */
    protected $apiCallsCount = 0;


    /**
     * @param null $apiKey
     * @throws \Exception
     */
    public function __construct($apiKey = null) {
        parent::__construct();

        $this->apiKey = $apiKey;
    }

    /**
     * @param string|array $id
     * @param bool|false $country ISO
     * @return bool|array
     * @throws \Exception
     */
    public function check($id, $country = false) {
        if (! $this->apiKey) return $this->checkByRegex($id);

        $this->apiRequest($id);

        if (is_array($id)) return $this->arrayCheck($id, $country);

        if ($this->simpleCheck($id)) {
            if ($country) return $this->checkByCountry($id, $country);

            return true;
        }

        return false;
    }

    /**
     * Use if you don't have API key or you make low volume requests
     *
     * @param $id
     * @return bool
     */
    public function checkByRegex($id) {
        $contents = file_get_contents(
            $this->buildURL($id, $this->url)
        );

        preg_match($this->checkRegex, $contents, $matches);

        // If there are no matches its not available
        return (empty($matches)) ? false : true;
    }

    /**
     * @param array $ids
     * @param null $country
     * @return array
     */
    protected function arrayCheck(array $ids, $country = null) {
        $result = [];

        foreach ($ids as $id) {
            $result[$id] = $this->check($id, $country);
        }

        return $result;
    }

    /**
     * If there are results, video exists (you still should take care of country)
     *
     * @param $id
     * @return bool
     */
    protected function simpleCheck($id) {
        return isset($this->storedIds[$id]) && ($this->storedIds[$id] != false);
    }

    /**
     * @param $id
     * @param bool|false $country
     * @return bool
     * @throws \Exception
     */
    protected function checkByCountry($id, $country = false) {
        $item = $this->storedIds[$id];

        if (! isset($item['contentDetails']['regionRestriction'])) return true;

        $regionRestriction = $item['contentDetails']['regionRestriction'];

        return (
            isset($regionRestriction['allowed']) && in_array($country, $regionRestriction['allowed'])
            || isset($regionRestriction['blocked']) && ! in_array($country, $regionRestriction['blocked'])
        );
    }

    /**
     * Wont make new calls if we already stored an ID
     *
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    protected function apiRequest($id) {
        $idParam = $id;

        if (is_array($id)) {
            if (count($id) > 50) new \Exception('Maximum simultaneous ids for Youtube API call is 50.');

            $idParam = implode(',', $id);
        } else {
            if (isset($this->storedIds[$id])) return $this->storedIds[$id];
        }

        $response = file_get_contents('https://www.googleapis.com/youtube/v3/videos?id=' . $idParam . '&key=' . $this->apiKey . '&part=contentDetails');

        if ($response) $response = json_decode($response, true);

        if ( ! $response || isset($response['error'])) {
            // Avoids continuing with the validation... else we always gonna have falsey results
            throw new \Exception('Youtube API responded with errors: ' . $response['error']);
        }

        $this->apiCallsCount++;

        if (is_array($id)) {
            $this->storeIndividually($id, $response);
        } else {
            $this->storedIds[$id] = isset($response['items'][0]) ? $response['items'][0] : null;
        }

        return $this->apiResponse = $response;
    }

    /**
     * @param $ids
     * @param $response
     * @return array
     */
    protected function storeIndividually($ids, $response) {
        foreach ($ids as $id) {
            $this->storedIds[$id] = false;
        }

        foreach ($response['items'] as $item) {
            $this->storedIds[$item['id']] = $item;
        }

        return $this->storedIds;
    }

    /**
     * @return int
     */
    public function getApiCallsCount()
    {
        return $this->apiCallsCount;
    }
}