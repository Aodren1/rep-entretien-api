<?php

//cf man curl php -> https://www.php.net/manual/fr/book.curl.php

class OpenWeather {

    private $ApiKey;

    public function __construct(string $ApiKey)
    {
        $this-> ApiKey = $ApiKey;
    }

    public function getForcast(string $city): ?array
    {
        $curl = curl_init("https://api.openweathermap.org/data/2.5/forecast/daily?q={$city},frk&APPID={$this->ApiKey}&units=metric&lang=fr");
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CAINFO => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'cert.cer',
            CURLOPT_TIMEOUT => 1
        ]);
        $data = curl_exec($curl);
        if ($data === false || curl_getinfo($curl, CURLINFO_HTTP_CODE) !== 200) {
            return NULL;
        }
        $data = json_decode($data, true);
        foreach($data['list'] as $day) {
            $results[]=[
                'temp' => $day['main']['temp'],
                'description' => $day['weather'][0]['description'],
                'date' => new DateTime('@'.$day['dt'])
            ];
        }
        return $results;
    }
}