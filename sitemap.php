<?php
// Abdellah Baidou
// GitHub : baidou5
// baidou.abd@gmail.com

// Database connection parameters
$host = 'localhost';
$db = 'your_database_name';
$user = 'your_username';
$pass = 'your_password';

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the query to fetch URLs
    $stmt = $pdo->query("SELECT slug FROM posts"); // Change 'slug' to your URL field
    $urls = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $urls[] = 'https://www.example.com/' . $row['slug']; // Update base URL
    }

    // Set the content type to XML
    header('Content-Type: application/xml; charset=utf-8');

    // Start the XML output
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap-image/1.1">';

    // Loop through each URL and create an XML entry
    foreach ($urls as $url) {
        echo '<url>';
        echo '<loc>' . htmlspecialchars($url, ENT_XML1, 'UTF-8') . '</loc>';
        echo '<lastmod>' . date('Y-m-d') . '</lastmod>'; // Customize if needed
        echo '<changefreq>monthly</changefreq>'; // Change frequency
        echo '<priority>0.8</priority>'; // Priority
        echo '</url>';
    }

    echo '</urlset>';
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
