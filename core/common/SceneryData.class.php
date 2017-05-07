<?php

/**
 * phpVMS - Virtual Airline Administration Software
 * Copyright (c) 2017 F. Göldenitz
 *
 * @author F. Göldenitz
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */


class SceneryData extends CodonData {

    public static function findScenery($params, $count = '', $start = '', $order_by = '') {
    
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'scenery ';
        $sql .= DB::build_where($params);
        
        if (strlen($order_by) > 0) {
            $sql .= ' ORDER BY ' . $order_by;
        }
        
        if (strlen($count) != 0) {
            $sql .= ' LIMIT ' . $count;
        }
        
        if (strlen($start) != 0) {
            $sql .= ' OFFSET ' . $start;
        }
        
        $ret = DB::get_results($sql);
        return $ret;
        
    }
    
    public static function getSceneryData($icao) {
        //echo "<p>get scenery " . $icao . "</p>";
        $icao = strtoupper(DB::escape($icao));

        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'scenery
				WHERE `icao`=\'' . $icao . '\'';

        $sceneryData = DB::get_results($sql);
        
        //print_r($sceneryData);
        return $sceneryData;
    }
    
    public static function addScenery($data) {
        $data['icao'] = strtoupper(DB::escape($data['icao']));
        
        if ($data['payware'] == '')
            $payware = 0;
        else
            $payware = 1;
            
        $sql = "INSERT INTO " . TABLE_PREFIX . "scenery
            (`icao`, `descr`, `link`, `sim`, `payware`)
            VALUES('{$data['icao']}', '{$data['description']}', '{$data['link']}', '{$data['simulator']}', '{$payware}')";
        //print "<p>" . $sql . "</p>";
        $res = DB::query($sql);
        if (DB::errno() != 0) return false;
        return true;
            
    }
    
        
        
        
    public static function editScenery($data) {
        $data['icao'] = strtoupper(DB::escape($data['icao']));
        
        if ($data['payware'] == '')
            $payware = 0;
        else
            $payware = 1;

        $sql = "UPDATE " . TABLE_PREFIX . "scenery
            SET `icao`='{$data['icao']}', `descr`='{$data['description']}', `link`='{$data['link']}',
            `sim`='{$data['simulator']}', `payware`='{$payware}'
            WHERE `icao`='{$data['oldicao']}'";
        //echo "<p>" . $sql . "</p>";
        $res = DB::query($sql);

        if (DB::errno() != 0) return false;

        /*CodonCache::delete('get_airport_' . $data['icao']);
        CodonCache::delete('all_airports_json');
        CodonCache::delete('all_airports');*/
        return true;
    }
    
}
