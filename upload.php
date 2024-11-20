<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;

$s3 = new S3Client([
    'region'  => 'your-region',
    'version' => 'latest',
    'credentials' => [
        'key'    => 'your-access-key',
        'secret' => 'your-secret-key',
    ],
]);

$bucket = 'new-uploadbucket';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $key = basename($file['name']);

    try {
        $result = $s3->putObject([
            'Bucket' => $bucket,
            'Key'    => $key,
            'SourceFile' => $file['tmp_name'],
            'ACL'    => 'public-read', // Optional, for public access
        ]);
        echo "File uploaded successfully. URL: " . $result['ObjectURL'];
    } catch (Exception $e) {
        echo "Error uploading file: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
