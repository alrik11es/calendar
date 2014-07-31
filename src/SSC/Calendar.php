<?php
namespace SSC;

class Calendar{
    
    /** @var DateTime */
    public $start_date;
    /** @var DateInterval */
    public $interval;
    /** @var formatters\FormatterInterface */
    private $formatter;
    
    public function __construct()
    {
        $this->setFormatter(new \SSC\formatters\ObjectFormatter());
        $this->start_date = new \DateTime();
        $this->interval = new \DateInterval('P6M');
    }
    
    public function setFormatter(formatters\FormatterInterface $formatter)
    {
        $this->formatter = $formatter;    
    }
    
    public function getCalendar()
    {
        echo $this->start_date->format(\DateTime::ATOM);
    }

}
