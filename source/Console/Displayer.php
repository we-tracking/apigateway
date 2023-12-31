<?php

namespace Source\Console;

use Source\Console\Features\ProgressBar;

class Displayer
{

    private array $colors;

    /**
     * overwrite line in scale
     * @var int 
     */
    private int $owLine;

    /**
     * overwrite column in scale
     * @var int 
     */
    private int $owColumn;

    /**
     * @var bool
     */
    private $overwrite = false;


    public function __construct(protected Console $console)
    {
        $this->colors = resource("Colors.php");
    }

    public function output(string $output, string $color = "white", string $background = "black", bool $lineBreaker = true): void
    {
        $color = $this->getForeGroundColor($color);
        $backGround = $this->getBackGroundColor($background);
        $break = $lineBreaker ? PHP_EOL : "";

        if ($this->overwrite) {
            $this->overwrite($this->owLine ?? 0, $this->owColumn ?? 0);
        }

        $this->console->output(
            sprintf("\e[%s;%sm%s\e[0m%s", $color, $backGround, $output, $break)
        );
    }

    public function overwrite(int $line = 0, int $column = 0)
    {
        $this->console->overwrite($line, $column);
    }

    public function setOverwrite(bool $overwrite): self
    {
        $this->overwrite = $overwrite;
        return $this;
    }

    public function setOverwriteScale(int $line, int $column): self
    {
        $this->owLine = $line;
        $this->owColumn = $column;
        return $this;
    }

    private function getBackGroundColor(string $color): string
    {
        return $this->colors["backGround"][$color] ?? "40"; // default black
    }

    private function getForeGroundColor(string $color): string
    {
        return $this->colors["foreGround"][$color] ?? "0;37"; // default white
    }

    public function console(): Console
    {
        return $this->console;
    }

    /**
     * Retorna uma instancia de progressBar
     *
     * @return ProgressBar
     */
    public function progressBar(): ProgressBar
    {
        return resolve(ProgressBar::class);
    }

    public function waitForInteraction(int $timeout = 5)
    {
        $fd = fopen('php://stdin', 'r');
        $read = array($fd);
        if (stream_select($read, $write, $except, $timeout)) {
            return trim(fgets($fd));
        } else {
            return false;
        }
    }

    public function error(string $message): void
    {
        $this->output($message, "white", "red");
    }

    public function warning(string $message): void
    {
        $this->output($message, "black", "yellow");
    }

    public function quote(string $message)
    {
        $this->output($message, "grey");
    }

    public function success(string $message)
    {
        $this->output($message, "green");
    }
}
