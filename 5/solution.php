<?php

class LogEntry {
    public string $ip;
    public string $path;

    public function __construct(string $ip, string $path) {
        $this->ip = $ip;
        $this->path = $path;
    }

    public function getKey(): string {
        return $this->ip . '|' . $this->path;
    }
}

class LogParser {
    private string $filePath;

    public function __construct(string $filePath) {
        $this->filePath = $filePath;
    }

    public function parse(): array {
        $entries = [];

        if (!file_exists($this->filePath)) {
            throw new Exception("Log file not found: {$this->filePath}");
        }

        $handle = fopen($this->filePath, 'r');
        if (!$handle) {
            throw new Exception("Failed to open log file.");
        }

        while (($line = fgets($handle)) !== false) {
            // Match IP and request path (e.g., "GET /index.html")
            if (preg_match('/^(\d+\.\d+\.\d+\.\d+).+?"\w+\s(\/[^ ]*)/', $line, $matches)) {
                $ip = $matches[1];
                $path = $matches[2];
                $entries[] = new LogEntry($ip, $path);
            }
        }

        fclose($handle);
        return $entries;
    }
}

class LogAggregator {
    private array $entries;

    public function __construct(array $entries) {
        $this->entries = $entries;
    }

    public function aggregate(): array {
        $counts = [];

        foreach ($this->entries as $entry) {
            $key = $entry->getKey();
            if (!isset($counts[$key])) {
                $counts[$key] = 0;
            }
            $counts[$key]++;
        }

        return $counts;
    }
}

class LogReporter {
    public static function report(array $aggregated): void {
        echo str_pad("Count", 8) . str_pad("IP Address", 18) . "Path\n";
        echo str_repeat("-", 40) . "\n";

        ksort($aggregated); // Sort alphabetically

        foreach ($aggregated as $key => $count) {
            [$ip, $path] = explode('|', $key);
            echo str_pad($count, 8) . str_pad($ip, 18) . $path . "\n";
        }
    }
}

// ------------------ MAIN ------------------

try {
    $parser = new LogParser("sample.log");
    $entries = $parser->parse();

    $aggregator = new LogAggregator($entries);
    $counts = $aggregator->aggregate();

    LogReporter::report($counts);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
