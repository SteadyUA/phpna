<?php

namespace SteadyUa\NsAnalyzer;

class Analyzer
{
    private $knownNsList = [];

    /**
     * @var DirScanner
     */
    private $dirScanner;

    public function run(): int
    {
        if (!$this->init()) {
            return 1;
        }

        $exitCode = 0;
        foreach ($this->dirScanner as $fileName => $nsList) {
            $unknownList = $this->findUnknown($nsList);
            if ($unknownList) {
                echo 'File: ', $fileName, PHP_EOL;
                foreach ($unknownList as $name) {
                    echo '  ', $name, PHP_EOL;
                }
                echo PHP_EOL;
                $exitCode = 1;
            }
        }

        return $exitCode;
    }

    private function init(): bool
    {
        $dirPath = getcwd();
        $composerFile = $dirPath . '/composer.json';
        if (!file_exists($composerFile)) {
            echo 'composer.json not found.', PHP_EOL;
            return false;
        }
        $packageInfo = json_decode(file_get_contents($composerFile), true);
        if (!isset($packageInfo['autoload']['psr-4'])) {
            echo 'No autoload psr-4', PHP_EOL;
            return false;
        }
        if (!isset($packageInfo['require'])) {
            echo 'No require section.', PHP_EOL;
            return false;
        }
        $lockFile = $dirPath . '/composer.lock';
        if (!file_exists($lockFile)) {
            echo 'No composer.lock file. Run: composer install', PHP_EOL;
            return false;
        }
        $packageNsSet = $packageInfo['autoload']['psr-4'];
        $dependencySet = $packageInfo['require'];
        $lockInfo = json_decode(file_get_contents($lockFile), true);
        $dependencyNsSet = [];
        foreach ($lockInfo['packages'] as $info) {
            if (isset($dependencySet[$info['name']])) {
                $dependencyNsSet += $info['autoload']['psr-4'] ?? [];
            }
        }
        $this->dirScanner = new DirScanner();
        foreach ($packageNsSet as $src) {
            $this->dirScanner->add($src);
        }
        $this->knownNsList = array_keys($packageNsSet + $dependencyNsSet);

        return true;
    }

    private function findUnknown(array $nameList): array
    {
        $unknown = [];
        foreach ($nameList as $name) {
            $isKnown = false;
            foreach ($this->knownNsList as $knownNs) {
                if (strpos($name, $knownNs) === 0) {
                    $isKnown = true;
                    break;
                }
            }
            if (!$isKnown) {
                $unknown[] = $name;
            }
        }

        return $unknown;
    }
}
