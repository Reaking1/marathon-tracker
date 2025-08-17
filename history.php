<?php
// history.php
// This page loads and displays past marathon progress calculations

// File where history is stored
$historyFile = "history.txt";

// Initialize empty history
$historyData = [];

// Check if file exists and has content
if (file_exists($historyFile)) {
    $jsonContent = file_get_contents($historyFile);
    if (!empty($jsonContent)) {
        $historyData = json_decode($jsonContent, true);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Runner History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f4f4f4;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 2px 5px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #333;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .no-data {
            text-align: center;
            margin-top: 40px;
            font-size: 18px;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h2>Runner History</h2>

    <?php if (!empty($historyData)) : ?>
        <table>
            <tr>
                <th>Date</th>
                <th>Distance Covered (km)</th>
                <th>Elapsed Time (hrs)</th>
                <th>Target Time (hrs)</th>
                <th>Current Speed (km/h)</th>
                <th>Required Speed (km/h)</th>
            </tr>
            <?php foreach ($historyData as $entry): ?>
                <tr>
                    <td><?= htmlspecialchars($entry['date']) ?></td>
                    <td><?= htmlspecialchars($entry['covered']) ?></td>
                    <td><?= htmlspecialchars($entry['elapsed']) ?></td>
                    <td><?= htmlspecialchars($entry['target']) ?></td>
                    <td><?= htmlspecialchars($entry['currentSpeed']) ?></td>
                    <td><?= htmlspecialchars($entry['requiredSpeed']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p class="no-data">No history data found.</p>
    <?php endif; ?>

    <a href="index.php" class="back-link">← Back to Calculator</a>
</body>
</html>
