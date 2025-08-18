<?php
// functions.php

// 1. Calculate current average speed (km/h)
function calculateCurrentSpeed($distanceCovered, $elapsedTimeHours) {
    if ($elapsedTimeHours <= 0) return 0;
    return $distanceCovered / $elapsedTimeHours;
}

// 2. Calculate required speed to meet target (km/h)
function calculateRequiredSpeed($distanceRemaining, $timeRemainingHours) {
    if ($timeRemainingHours <= 0) return 0;
    return $distanceRemaining / $timeRemainingHours;
}

// 3. Save race data into a file
function saveRaceData($filename, $data) {
    $json = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filename, $json);
}

// 4. Load race data from a file
function loadRaceData($filename) {
    if (!file_exists($filename)) {
        return [];
    }
    $json = file_get_contents($filename);
    return json_decode($json, true);
}

// 5. Store new race record in multidimensional array
function addRaceRecord(&$history, $raceData) {
    $history[] = $raceData;
}

function saveToHistory($raceData) {
    $file = "history.txt"; // you could also use .csv if you want Excel-friendly
    $line = implode(",", $raceData) . "\n";
    file_put_contents($file, $line, FILE_APPEND);
}

function loadHistory() {
    $file = 'history.txt';
    if (!file_exists($file)) return [];

    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $history = [];

    foreach ($lines as $line) {
        $parts = explode(",", $line);

        // Make sure we have enough columns
        if (count($parts) >= 5) {
            $history[] = [
                "covered"       => $parts[0],
                "elapsed"       => $parts[1],
                "target"        => $parts[2],
                "currentSpeed"  => $parts[3],
                "requiredSpeed" => $parts[4],
            ];
        }
    }

    return $history;
}


?>
