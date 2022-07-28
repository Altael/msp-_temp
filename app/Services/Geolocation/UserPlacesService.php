<?php

namespace App\Services\Geolocation;

use App\Contracts\User\UserPlacesRepositoryInterface;

class UserPlacesService
{
    private const GOOGLE_MAPS_API_URL = 'https://maps.googleapis.com/maps/api/place/';
    private const LANGS = [
        'en',
        'ru'
    ];
    private const CACHE_KEY = 'place_details:';

    /**
     * @var UserPlacesRepositoryInterface
     */
    private $userPlacesRepository;

    /**
     * UserPlacesService constructor.
     * @param UserPlacesRepositoryInterface $userPlacesRepository
     */
    public function __construct(UserPlacesRepositoryInterface $userPlacesRepository)
    {
        $this->userPlacesRepository = $userPlacesRepository;
    }

    /**
     * @param string $placeId
     * @return array
     */
    public function getByPlaceId(string $placeId): array
    {
        return $this->userPlacesRepository->getById($placeId);
    }

    /**
     * @param string $placeId
     * @throws \Exception
     */
    public function save(string $placeId): void
    {
        $data['id'] = $placeId;

        foreach (self::LANGS as $lang) {
            $data['name_' . $lang] = $this->getPlaceNameByIdByLang($placeId, $lang);
        }

        $this->userPlacesRepository->save($data);
    }

    /**
     * @param string $placeId
     * @param string $lang
     * @return string
     * @throws \Exception
     */
    public function getPlaceNameByIdByLang(string $placeId, string $lang): string
    {
        $details = $this->getDetailsByPlaceId($placeId, $lang);
        if (empty($details)) {
            return '';
        }

        return $details['address_components'][0]['long_name'] ?? '';
    }

    /**
     * @param string $name
     * @return array
     */
    public function getPlaceByName(string $name): array
    {
        $query = http_build_query([
            'key' => getenv('GOOGLE_MAP_KEY'),
            'input' => $name
        ]);

        if ($data = cache()->get("placeBy-{$name}")) {
            return $data;
        }

        file_put_contents('log_maps_api.txt', "Autocomplete: {$name}".PHP_EOL, FILE_APPEND);

        $data = json_decode(file_get_contents(self::GOOGLE_MAPS_API_URL . "autocomplete/json?{$query}"), true) ?? [];

        cache()->put("placeBy-{$name}", $data, now()->addDay());

        return $data;
    }

    /**
     * @param string $placeId
     * @param string $lang
     * @return array
     * @throws \Exception
     */
    public function getDetailsByPlaceId(string $placeId, string $lang = 'en'): array
    {
        $result = $this->getFromCache($placeId, $lang);
        if (!empty($result)) {
            return $result;
        }

        $query = http_build_query([
            'key' => getenv('GOOGLE_MAP_KEY'),
            'placeid' => $placeId,
            'language' => $lang
        ]);

        file_put_contents('log_maps_api.txt', "Details: {$placeId}".PHP_EOL, FILE_APPEND);

        $res = json_decode(file_get_contents(self::GOOGLE_MAPS_API_URL . "details/json?{$query}&fields=address_components"), true) ?? [];

        if ($res['error_message'] ?? null) {
            throw new \Exception($res['error_message']);
        }

        if (($res['status'] ?? null) !== 'OK' || empty($res['result'])) {
            return [];
        }

        $this->saveToCache($placeId, $lang, $res['result']);

        return $res['result'];
    }

    /**
     * @param string $placeId
     * @param string $lang
     * @return array
     * @throws \Exception
     */
    private function getFromCache(string $placeId, string $lang): array
    {
        return cache($this->getCacheKey($placeId, $lang)) ?? [];
    }

    /**
     * @param string $placeId
     * @param string $lang
     * @param array $data
     * @throws \Exception
     */
    private function saveToCache(string $placeId, string $lang, array $data): void
    {
        $expiresAt = now()->addDay();
        cache()->put($this->getCacheKey($placeId, $lang), $data, $expiresAt);
    }

    /**
     * @param string $placeId
     * @param string $lang
     * @return string
     */
    private function getCacheKey(string $placeId, string $lang): string
    {
        return self::CACHE_KEY . $placeId . ':' . $lang;
    }
}
