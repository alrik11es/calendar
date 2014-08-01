<?php
namespace SSC;

class Calendar{

    /** @var CalendarConfig */
    public $config;
    
    public function __construct()
    {
        $default_config = new CalendarConfig();
        $default_config->setFormatter(new \SSC\formatters\ObjectFormatter());
        $default_config->start_date = new \DateTime();
        $default_config->interval = new \DateInterval('P6M');
        $default_config->generator = new generators\YearGenerator();
        $this->config = $default_config;
    }
    
    public function setConfig(CalendarConfig $conf)
    {
        $this->config = $conf;    
    }

    public function getConfig()
    {
        return $this->config;
    }
    
    public function getCalendarStructure()
    {
        $this->config->generator->setConfig($this->config);
        return $this->config->generator->generate();
    }
    
}
