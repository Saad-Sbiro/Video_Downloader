<?php
set_time_limit(0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $url = escapeshellarg($_POST["url"]);
    $quality = $_POST["quality"];
    $platform = $_POST["platform"];
    $outputDir = "downloads";
    $timestamp = time();

    if (!is_dir($outputDir)) {
        mkdir($outputDir, 0777, true);
    }

    $ytDlp = "./yt-dlp";
    $userAgent = escapeshellarg("Mozilla/5.0");
    $cookies = "--cookies cookies.txt";

    // ✅ تحسين استخراج عنوان الفيديو مع user-agent و cookies
    $titleCommand = "$ytDlp $cookies --user-agent $userAgent --no-warnings --no-playlist --get-title $url";
    $rawTitle = shell_exec($titleCommand);
    $videoTitle = trim($rawTitle);

    // ✅ حماية إضافية في حال فشل استخراج العنوان
    if (empty($videoTitle) || preg_match('/^\d+$/', $videoTitle)) {
        $videoTitle = "video";
    }

    $videoTitle = sanitizeFilename($videoTitle);
    $ext = ($quality === "bestaudio") ? "mp3" : "mp4";
    $fileNameOnly = $videoTitle . "_" . $timestamp . "." . $ext;
    $outputFilename = "$outputDir/$fileNameOnly";
    $outputTemplate = escapeshellarg($outputFilename);

    if ($platform === "youtube") {
        if ($quality === "bestaudio") {
            $cmd = "$ytDlp $cookies -f bestaudio --extract-audio --audio-format mp3 --audio-quality 0 -o $outputTemplate --user-agent $userAgent $url";
        } else {
            $format = escapeshellarg($quality);
            $cmd = "$ytDlp $cookies -f $format --merge-output-format mp4 -o $outputTemplate --user-agent $userAgent $url";
        }
    } elseif ($platform === "facebook" || $platform === "instagram") {
        if ($quality === "bestaudio") {
            $cmd = "$ytDlp $cookies -f bestaudio --extract-audio --audio-format mp3 --audio-quality 0 -o $outputTemplate --user-agent $userAgent $url";
        } else {
            $cmd = "$ytDlp $cookies -f bestvideo+bestaudio --merge-output-format mp4 -o $outputTemplate --user-agent $userAgent $url";
        }
    } else {
        $cmd = "$ytDlp $cookies -f best --merge-output-format mp4 -o $outputTemplate --user-agent $userAgent $url";
    }

    shell_exec($cmd);

    if (file_exists($outputFilename)) {
        header("Location: result.php?status=success&file=" . urlencode($fileNameOnly));
        exit();
    } else {
        header("Location: result.php?status=error");
        exit();
    }
}

function sanitizeFilename($filename) {
    $filename = preg_replace("/[^a-zA-Z0-9\p{Arabic}\-\. ]/u", "", $filename);
    return trim($filename);
}


if (!isset($_GET['file'])) {
    die("❌ No file specified.");
}

$filename = basename($_GET['file']);
$filepath = __DIR__ . "/downloads/" . $filename;

if (!file_exists($filepath)) {
    die("❌ File not found.");
}

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filepath));
readfile($filepath);
exit;
?>
