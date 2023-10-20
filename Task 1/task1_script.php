<?php
$host = "localhost";
$username = "root";
$password = "hovata3201";
$database = "auptimate_test";

// Establish a connection to the MySQL database
$mysqli = new mysqli($host, $username, $password, $database);

// Verify any connectivity issues
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// SQL query to total transaction amounts and the number of distinct syndicates for each investor
$query = "
    SELECT investor_id, COUNT(DISTINCT syndicate_id) AS UniqueSyndicates, SUM(amount) AS TotalInvestment
    FROM transactions
    GROUP BY investor_id
    ORDER BY UniqueSyndicates DESC, TotalInvestment DESC
    LIMIT 5
";

$result = $mysqli->query($query);

if ($result) {
    echo " The Top 5 Investors in Terms of Unique Syndicates:</br>";
    $index = 1;
    
    while ($row = $result->fetch_assoc()) {
        $investorID = $row['investor_id'];
        $uniqueSyndicates = $row['UniqueSyndicates'];
        $totalInvestment = $row['TotalInvestment'];
        
        echo "$index. Investor ID: $investorID, Unique Syndicates: $uniqueSyndicates, Total Investment: $totalInvestment</br>";
        $index++;
    }
    
    // Close the result set
    $result->close();
} else {
    echo "Error: " . $mysqli->error;
}

// Close the connection to the database.
$mysqli->close();
?>
