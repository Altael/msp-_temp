<?php
if (($handle = fopen("users.csv", "r")) !== false) {
    $csv = fopen("users-out.csv", "w");

    while (($row = fgetcsv($handle, 10000, ";")) !== false) {
        $country = 'Unknown';
        if ($row[8] !== 'place') {
            $place = $row[8];
            $url = "https://maps.googleapis.com/maps/api/place/details/json?key=AIzaSyBgL_RMccnJFQkZWOE1LFuEXcehZqaknWw&place_id={$place}";

            $response = json_decode(file_get_contents($url), true);
            $address = $response['result']['address_components'];

            foreach ($address as $item) {
                if (in_array('country', $item['types'])) {
                    $country = $item['long_name'];
                }
            }

            if ($country === 'Ukraine') {
                $row[9] = $country;
                fputcsv($csv, $row, ';');
            }
        }
    }
    fclose($handle);
    fclose($csv);
}
