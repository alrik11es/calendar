<?php
namespace SSC;

class Calendar{
    
    const DAY = 'day';

    /** @var CalendarConfig */
    public $config;
    public $day_callback = null;
    
    public function __construct()
    {
        $default_config = new CalendarConfig();
        $default_config->setFormatter(new \SSC\formatters\ArrayFormatter());
        $default_config->setStartDate(new \DateTime());
        $default_config->setInterval(new \DateInterval('P6M'));
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
    
    public function setDataInElement($date, $element)
    {
        $result = null;
        $element = $element.'_callback';
        if(isset($this->$element)){
            $this->$element($date);
        }
        return $result;
    }
    
    public function getCalendarStructure()
    {
        $end_date = new \DateTime();
        $end_date->add($this->config->getInterval());
        
        $period = new \DatePeriod(
             $this->config->getStartDate(),
             new \DateInterval('P1D'),
             $end_date
        );
        
        $cal = array();
        foreach($period as $date){
            $cal[$date->format('Y')][$date->format('n')][$date->format('j')] = $this->setDataInElement($date, self::DAY);
        }
        
        $cal = $this->config->getFormatter()->setFormat($cal);

        return $cal;
    }
    
}
