<?php
namespace SSC;

class Calendar{
    
    /** @var CalendarConfig */
    public $config;
    public $day_callback = null;
    public $month_callback = null;
    public $week_callback = null;
    public $quarter_callback = null;
    public $year_callback = null;

    public function __construct()
    {
        $default_config = new CalendarConfig();
        $default_config->setFormatter(new \SSC\formatters\ArrayFormatter());
        $start_date = new \DateTime();
        $start_date->sub(new \DateInterval('P'.($start_date->format('j')-1).'D'));
        $default_config->setStartDate($start_date);
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

        if(isset($this->$element)){
            $result = $this->$element($date);
        }

        return $result;
    }
    
    public function getCalendarStructure()
    {
        $end_date = clone $this->config->getStartDate();
        $end_date->add($this->config->getInterval());

        $period = new \DatePeriod(
             $this->config->getStartDate(),
             new \DateInterval('P1D'),
             $end_date
        );
        
        $cal = array();

        foreach($period as $date){
            $year = $date->format('Y');
            $month = $date->format('n');
            $day = $date->format('j');
            $quarter = (int) ceil($month / 3);
            $week = (int) $date->format('W');
            $week_day = (int) $date->format('w');

            if($month == 1 && $week > 50){
                $week = 0;
            }

            if(!array_key_exists($year, $cal)){
                $cal[$year] = array(
                    'type' => 'year',
                    'value' => $year,
                    'data' => $this->setDataInElement($date, 'year_callback'),
                    'elements' => array()
                );
            }

            if(!array_key_exists($quarter, $cal[$year]['elements'])){
                $cal[$year]['elements'][$quarter] = array(
                    'type' => 'quarter',
                    'value' => $quarter,
                    'data' => $this->setDataInElement($date, 'quarter_callback'),
                    'elements' => array()
                );
            }

            if(!array_key_exists($month, $cal[$year]['elements'][$quarter]['elements'])){
                $cal[$year]['elements'][$quarter]['elements'][$month] = array(
                    'type' => 'month',
                    'value' => $month,
                    'data' => $this->setDataInElement($date, 'month_callback'),
                    'elements' => array()
                );
            }

            if(!array_key_exists($week, $cal[$year]['elements'][$quarter]['elements'][$month]['elements'])){
                $cal[$year]['elements'][$quarter]['elements'][$month]['elements'][$week] = array(
                    'type' => 'week',
                    'value' => $week,
                    'data' => $this->setDataInElement($date, 'week_callback'),
                    'elements' => array()
                );
            }

            if(!array_key_exists($day, $cal[$year]['elements'][$quarter]['elements'][$month]['elements'][$week]['elements'])){
                $cal[$year]['elements'][$quarter]['elements'][$month]['elements'][$week]['elements'][$day] = array(
                    'type' => 'day',
                    'value' => $day,
                    'data' => $this->setDataInElement($date, 'day_callback'),
                    'weekday' => $week_day,
                );
            }
        }
        
        $cal = $this->config->getFormatter()->setFormat($cal);

        return $cal;
    }


    public function __call($method, $args)
    {
        if(is_callable(array($this, $method))) {
            return call_user_func_array($this->$method, $args);
        }
        // else throw exception
    }

}
