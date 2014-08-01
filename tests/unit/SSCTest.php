<?php

class SSCTest extends PHPUnit_Framework_TestCase{
    
    /**
     * Default test. A 6 months calendar with the entire structure, including:
     * Quarters, weeks...
     */
    public function testDefault()
    {
        $cal = new \SSC\Calendar();
        $structure = $cal->getCalendarStructure();
        
        $this->assertArrayHasKey(date('Y'), $structure);
        $this->assertArrayHasKey(date('n'), $structure[date('Y')]);
        $this->assertArrayHasKey(date('j'), $structure[date('Y')][date('n')]);
    }
}