<?php
try {
    $drivers = PDO::getAvailableDrivers();
    if (empty($drivers)) {
        echo "No PDO drivers are enabled at all!";
    } else {
        echo "Enabled drivers: " . implode(", ", $drivers);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>