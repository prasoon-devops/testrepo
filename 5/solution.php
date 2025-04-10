<?php

class LogAnalyzer
{
    private string $logFile;

    public function __construct(string $logFile)
    {
        if (!file_exists($logFile)) {
            throw new Exception("Log file not found: $logFile");
        }
        $this->logFile = $logFile;
    }

    public function topIPs(int $limit = 5): void
    {
        echo "Top {$limit} IPs:\n";
        $lines = file($this->logFile);
        $ips = [];

        foreach ($lines as $line) {
            if (preg_match('/^(\S+)/', $line, $matches)) {
                $ip = $matches[1];
                $ips[$ip] = ($ips[$ip] ?? 0) + 1;
            }
        }

        arsort($ips);
        foreach (array_slice($ips, 0, $limit, true) as $ip => $count) {
            echo "$count $ip\n";
        }
    }

    public function urlsWith404(): void
    {
        echo "\nURLs with 404 Errors:\n";
        $lines = file($this->logFile);
        $urls = [];

        foreach ($lines as $line) {
            if (preg_match('/"[^"]*" 404 \d+/', $line) &&
                preg_match('/"(\w+) ([^ ]+)/', $line, $matches)) {
                $url = $matches[2];
                $urls[$url] = true;
            }
        }

        foreach (array_keys($urls) as $url) {
            echo "$url\n";
        }
    }

    public function cleanedLog(): void
    {
        echo "\nCleaned Log:\n";
        $validStatusCodes = ['200', '301', '302', '400', '403', '404', '500', '502', '503'];
        $lines = file($this->logFile);

        foreach ($lines as $line) {
            $line = str_replace("\t", ' ', $line);       // Replace tabs with space
            $line = preg_replace('/\s+/', ' ', $line);    // Collapse multiple spaces
            $line = trim($line);

            if (empty($line)) continue;

            if (preg_match('/"[^"]*" (\d{3}) /', $line, $matches)) {
                if (in_array($matches[1], $validStatusCodes)) {
                    echo "$line\n";
                }
            }
        }
    }
}

// Example usage:
try {
    $analyzer = new LogAnalyzer('access.log');
    $analyzer->topIPs();
    $analyzer->urlsWith404();
    $analyzer->cleanedLog();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}