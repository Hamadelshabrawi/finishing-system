<?php
$file = '/home/yourusername/public_html/path/to/file.txt';
if (file_exists($file)) {
    echo "File exists!";
} else {
    echo "File not found!";
}
?>