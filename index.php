<?php
// index.php
include_once "functions.php";
// ✅ Load history at the start
$history = loadHistory(); // ensures table is populated even before submitting

// Initialize result
$result = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $totalDistance = 50; // Marathon distance
    $covered = floatval($_POST["covered"]);
    $elapsed = floatval($_POST["elapsed"]);
    $targetTime = floatval($_POST["target"]);

    // Calculations
    $currentSpeed = calculateCurrentSpeed($covered, $elapsed);
    $requiredSpeed = calculateRequiredSpeed($totalDistance, $covered, $elapsed, $targetTime);

    // Save run data
    $raceData = [
        "covered" => $covered,
        "elapsed" => $elapsed,
        "target" => $targetTime,
        "currentSpeed" => $currentSpeed,
        "requiredSpeed" => $requiredSpeed,
        "date" => date('Y-m-d H:i:s') // optional: timestamp
    ];

    saveToHistory($raceData);

    // ✅ Reload history so table updates immediately
    $history = loadHistory();

    // Prepare result display
    $result = "
        <h3>Results</h3>
        <p><strong>Distance Covered:</strong> {$covered} km</p>
        <p><strong>Elapsed Time:</strong> {$elapsed} hours</p>
        <p><strong>Target Time:</strong> {$targetTime} hours</p>
        <p><strong>Current Average Speed:</strong> " . number_format($currentSpeed, 2) . " km/h</p>
        <p><strong>Required Speed to Finish:</strong> " . number_format($requiredSpeed, 2) . " km/h</p>
    ";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Marathon Tracker</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <h2>🏃 Marathon Progress Tracker</h2>

    <form method="POST">
        <label>Distance Covered (km):</label><br>
        <input type="number" step="0.1" name="covered" required><br><br>

        <label>Elapsed Time (hours):</label><br>
        <input type="number" step="0.1" name="elapsed" required><br><br>

        <label>Target Time (hours):</label><br>
        <input type="number" step="0.1" name="target" required><br><br>

        <button type="submit">Calculate</button>
    </form>

<?php if (!empty($history)): ?>
    <h3>📜 Past Runs (including latest)</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>Date</th>
            <th>Covered (km)</th>
            <th>Elapsed (h)</th>
            <th>Target (h)</th>
            <th>Current Speed (km/h)</th>
            <th>Required Speed (km/h)</th>
        </tr>
        <?php foreach ($history as $run): ?>
            <tr>
                <td><?= $run["date"] ?? "-" ?></td>
                <td><?= $run["covered"] ?></td>
                <td><?= $run["elapsed"] ?></td>
                <td><?= $run["target"] ?></td>
                <td><?= number_format($run["currentSpeed"], 2) ?></td>
                <td><?= number_format($run["requiredSpeed"], 2) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No previous runs yet.</p>
<?php endif; ?>

 
</body>
</html>
