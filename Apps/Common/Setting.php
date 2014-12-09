<?php

/*
 * This file is part of the H1Cart package.
 * (w) http://www.h1cart.com
 * (c) Allen Niu <h@h1soft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Apps\Common;

/**
 * 系统配置
 *
 * @author Allen Niu <h@h1soft.net>
 */
class Setting extends \H1Soft\H\Singleton {

    private $db;
    private $setting = array();

    public function init() {
        $this->db = \H1Soft\H\Db\Db::getConnection();
        if(!$this->db){
            throw new Exception("数据库连接失败");            
        }
    }

    /**
     * 
     * @param type $group_name
     * @return \Module\Component\Setting
     */
    public function load($group_name) {
        $settings = $this->db->where('group', $group_name)->get('setting');
        foreach ($settings as $value) {
            $this->setting[$value['group']][$value['key']] = $value['value'];
        }
        return $this;
    }

    public function group($key) {
        if (isset($this->setting[$key])) {
            return $this->setting[$key];
        } else {
            $this->load($key);
            return isset($this->setting[$key]) ? $this->setting[$key] : array();
        }
    }

    public function get($key) {
        $skey = explode('.', $key);
        if (count($skey) == 2) {
            if (!isset($this->setting[$skey[0]])) {
                $this->load($skey[0]);
            }
            
            if (isset($this->setting[$skey[0]][$skey[1]])) {
                return $this->setting[$skey[0]][$skey[1]];
            }
        } else {
            return $this->group($key);
        }
        return NULL;
    }

    public function save($group, $config) {
        if (!is_array($config)) {
            return false;
        }
        $settings_rs = $this->db->where('group', $group)->get('setting');
        foreach ($settings_rs as $value) {
            $settings[$value['key']] = $value['value'];
        }
        foreach ($config as $key => $value) {
            $serialized = 0;
            if(!is_string($value)){
                $value = serialize($value);
                $serialized = 1;
            }
            if (isset($settings) && key_exists($key, $settings)) {
                $this->db->update('setting', array('value' => $value), "`group`='$group' AND `key`='$key'");
            } else {
                $this->db->insert('setting', array(
                    'value' => $value,
                    'group' => $group,
                    'key' => $key,
                    'serialized'=>$serialized
                ));
            }
        }
    }

}
