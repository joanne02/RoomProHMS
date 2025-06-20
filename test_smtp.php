<?php
$fp = fsockopen("smtp.mailtrap.io", 587, $errno, $errstr, 10);
if (!$fp) {
    echo "Error: $errstr ($errno)";
} else {
    echo "Connected successfully!";
    fclose($fp);
}
