<?php
// Initialize data structures for tracking transaction data
$transactionThreshold = 100000; // Define the pre-defined threshold
$transactionCounts = []; // Associative array to track transaction counts per syndicate
$alertedSyndicates = []; // Keep track of syndicates already alerted

// Simulated data generator
function generateRandomTransaction() {
    $syndicateID = rand(1, 2);
    $amount = rand(50, 150);
    return [
        'syndicateID' => $syndicateID,
        'amount' => $amount,
    ];
}

// Continuously process incoming transactions
while (true) {
    $transaction = generateRandomTransaction();
    $syndicateID = $transaction['syndicateID'];
    $transactionAmount = $transaction['amount'];

    // Calculate average transaction rate for the syndicate over the last hour (in this simulation, we're using a simple count)
    if (!isset($transactionCounts[$syndicateID])) {
        $transactionCounts[$syndicateID] = 0;
    }
    $transactionCounts[$syndicateID]++;

    // Check for a single transaction threshold breach
    if ($transactionAmount > $transactionThreshold && !in_array($syndicateID, $alertedSyndicates)) {
        echo "ALERT: Single Transaction Threshold Exceeded for Syndicate $syndicateID (Amount: $transactionAmount)</br>";
        $alertedSyndicates[] = $syndicateID; // Mark syndicate as alerted to avoid repeated alerts
    }

    // Check for a sudden spike in transaction volume
    $timeWindowInSeconds = 3600; // 1 hour
    $averageRate = $transactionCounts[$syndicateID] / $timeWindowInSeconds;
    if ($averageRate * 10 <= $transactionCounts[$syndicateID] && !in_array($syndicateID, $alertedSyndicates)) {
        echo "ALERT: Sudden Spike in Transaction Volume for Syndicate $syndicateID (Average Rate: $averageRate)</br>";
        $alertedSyndicates[] = $syndicateID;
    }

    // Simulate a delay to represent real-time processing
    usleep(100000); // Sleep for 100ms
}

// The script will run indefinitely; you can stop it manually.
?>
