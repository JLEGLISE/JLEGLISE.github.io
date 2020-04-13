<?php

class GoogleSheet 
{
    private $URL = "";
    private $data = array();

    public function getURL() {
        return $this->URL;
    }

    public function getData() { return $this->data; }

    public function __construct(string $inputUrl)
    {
        if ($inputUrl == '')
        {
            throw new Exception("Input Url cannot be an empty string.", 1);
        }
        
        $this->URL = $inputUrl;

        $rawData = file_get_contents($this->URL);
        $this->_rawLog($rawData);

        if (!$rawData)
        {
            throw new Exception("Error reading file.", 1);
        }
        $lines = explode(PHP_EOL, $rawData);
        
        foreach ($lines as $i => $line) 
        {
            $cells = str_getcsv($line, "\t");
            if ($i == 0) 
            {
                $this->_log('Skipping first line: '.$cells[0]);
                continue;
            }
            if (trim($cells[0]) === '') 
            {
                $this->_log('Skipping Empty cell at line '.($i + 1).': {'.$cells[0].'}');
                continue;
            }
            $this->_log('Added data from line '.($i + 1).': {'.$cells[0].'}');
            $this->data[] = $cells;
        }
    }
    
    public function printData()
    {
        echo '<pre>';
        print_r($this->data);
        echo '</pre>';
    }

    private function _log(string $message)
    {
        echo "<script>; console.log('".trim($message)."');</script>";
    }

    private function _rawLog(string $message)
    {
        echo "<script>;let a = '";
        print_r($message);
        echo "';</script>";
    }

}

?>