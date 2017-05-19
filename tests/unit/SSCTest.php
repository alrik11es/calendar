<?php

class SSCTest extends \PHPUnit\Framework\TestCase{
    
    /**
     * Default test. A 6 months calendar with the entire structure, including:
     * Quarters, weeks...
     */
    public function testDefault()
    {
        $cal = new \SSC\Calendar();
        $structure = $cal->getCalendarStructure();
        
        $this->assertArrayHasKey(date('Y'), $structure);
        $quarter = (int) ceil(date('n') / 3);
        $this->assertArrayHasKey($quarter, $structure[date('Y')]['elements']);
        $this->assertArrayHasKey(date('n'), $structure[date('Y')]['elements'][$quarter]['elements']);
    }
}