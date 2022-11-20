<?php

/**
 * RequestResult.php
 * User: kzoltan
 * Date: 2022-11-14
 * Time: 15:00
 */

namespace app\models;

use DateTime;

/**
 * Description of RequestResult
 *
 * @author kzoltan
 */
class RequestResult {
    
    public $data = null;
    public array $values = [];
    
    public string $message = '', 
        $query = '',
        $runtime_formatted = '';
    
    public float $start_time = 0, 
        $stop_time = 0;
    
    public int $affected_rows = 0,
        $insert_id = 0,
        $runtime = 0;
    
    public bool $success = false;
    
    public function start()
    {
        $this->start_time = microtime(true);
    }
    
    public function stop()
    {
        $this->stop_time = microtime(true);
        
        $this->runtime = round($this->stop_time - $this->start_time, 3) * 1000;
        
        $start_date = new DateTime($this->get_start_datetime());
        $stop_date = new DateTime($this->get_stop_datetime());
        $since_start = $start_date->diff($stop_date);
        $this->runtime_formatted = $since_start->format('%H:%I:%S');
    }
    
    public function get_start_datetime()
    {
        $now = DateTime::createFromFormat('U.u', $this->start_time);
        $retval = $now->format("Y-m-d H:i:s.u");
        
        return $retval;
    }
    
    public function get_stop_datetime() {
        
        $now = DateTime::createFromFormat('U.u', $this->stop_time);
        $retval = $now->format("Y-m-d H:i:s.u");
        
        return $retval;
    }
    
    public function __construct()
    {
        $this->success = false;
        $this->message = '';
        
        //$this->data = [];
        $this->values = [];
        
        $this->runtime = 0;
    }
    
    public function __serialize()
    {
        $obj = $this;
        $obj->success = ( $obj->success ) ? 'true' : 'false';
        
        return $obj;
    }
    
    public function __unserialize(array $data)
    {
        //
    }
    
    public function __toString()
    {
        return '';
    }
}
