<?php

class Group
{
    private $bgColor;
    private $textColor;
    private $index;
    private $groupName;

    private static $cssSelectorBackground = '#timeline-embed > .tl-timenav > .tl-timegroup:nth-child';

    public function __construct(string $bgColor, string $textColor, int $index, string $groupName)
    {
        $this->bgColor = trim($bgColor);
        $this->textColor = trim($textColor);
        $this->index = $index;
        $this->groupName = $groupName;
    }

    public function getCSS(int $groupCount)
    {
        $selector = Group::$cssSelectorBackground.'('.$groupCount.'n+'.($this->index + 4).')';

        $css = '/* '.$this->groupName.' */'.PHP_EOL;
        $css .= $selector.'{background-color: '.$this->bgColor.';}'.PHP_EOL;
        $css .= $selector.' .tl-timegroup-message {color: '.$this->textColor.';}'.PHP_EOL;

        return $css;
    }
}

?>