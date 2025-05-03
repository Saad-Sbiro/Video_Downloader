  <?php
$file = isset($_GET['file']) ? $_GET['file'] : null;
$status = isset($_GET['status']) ? $_GET['status'] : 'error';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Download Status</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="image.png" type="image/png" />
  <style>
    :root {
      --primary: #00ff88;
      --bg: #0f0f0f;
      --text-light: #ddd;
      --accent-blue: #00c6ff;
      --accent-blue-dark: #0072ff;
      --accent-red: #ff4e50;
      --accent-yellow: #f9d423;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      overflow: hidden;
      background: var(--bg);
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 40px 20px;
      text-align: center;
    }

    h1 {
      font-size: 3em;
      margin-bottom: 15px;
      color: var(--primary);
      text-shadow: 0 0 10px rgba(0, 255, 136, 0.6);
      animation: pulse 2s infinite ease-in-out;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.03); }
    }

    p {
      font-size: 1.2em;
      color: var(--text-light);
      margin-bottom: 30px;
    }

    .button-group {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }

    .btn {
      padding: 14px 30px;
      font-size: 17px;
      border: none;
      border-radius: 50px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(0, 255, 150, 0.2);
      min-width: 160px;
    }

    .btn-download {
      background: linear-gradient(135deg, var(--accent-blue), var(--accent-blue-dark));
      color: white;
    }

    .btn-download:hover {
      transform: translateY(-3px) scale(1.05);
      background: linear-gradient(135deg, var(--accent-blue-dark), var(--accent-blue));
    }

    .btn-back {
      background: linear-gradient(135deg, var(--accent-red), var(--accent-yellow));
      color: white;
    }

    .btn-back:hover {
      transform: translateY(-3px) scale(1.05);
      background: linear-gradient(135deg, var(--accent-yellow), var(--accent-red));
    }

    @media (max-width: 600px) {
      h1 {
        font-size: 2em;
      }

      p {
        font-size: 1em;
      }

      .btn {
        width: 100%;
        font-size: 16px;
      }
    }
  </style>
</head>
<body>

<?php if ($status === "success" && $file): ?>
  <h1>✅ Download Ready!</h1>
  <p><strong><?= htmlspecialchars($file) ?></strong></p>

  <div class="button-group">
    <a href="download.php?file=<?= urlencode($file) ?>" class="btn btn-download">⬇ Download Now</a>

    <form action="index.html" method="get">
      <button class="btn btn-back" type="submit">⬅ Back</button>
    </form>
  </div>
<?php else: ?>
    <h1>❌ Download Failed</h1>
    <p>Please check your link or resolution and try again.</p>

    <form action="index.html" method="get">
      <button class="btn btn-back" type="submit">⬅ Back</button>
    </form>
  <?php endif; ?>
</body>
</html>
