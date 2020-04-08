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

        if (!$rawData)
        {
            throw new Exception("Error reading file.", 1);
        }
        $lines = explode(PHP_EOL, $rawData);
        
        foreach ($lines as $i => $line) 
        {
            if ($i == 0) continue;
            $cells = str_getcsv($line);
            if (trim($cells[0]) === '') continue;
            
            $this->data[] = $cells;
        }
    }
    
    public function printData()
    {
        echo '<pre>';
        print_r($this->data);
        echo '</pre>';
    }

}

?>