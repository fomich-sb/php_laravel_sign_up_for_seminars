<?php
namespace App\Models;

use App\Models\BaseGameModel;
use Illuminate\Support\Facades\Cache;

class Setting extends BaseGameModel
{
    protected  $table='settings';
    public $timestamps = false;
    protected $guarded = [];

    public $params = 
    [
        "authoring_code_text" => ['type'=>'string'],
        "project_register_status-1" => ['type'=>'string'],
        "project_register_status0" => ['type'=>'string'],
        "project_register_status1" => ['type'=>'string'],
    ];

    public function get($name)
    {
        $cKey = 'settings';
        $data = Cache::get($cKey);
        if($data === null) 
            $data = $this->updateCache();
        if(isset($data[$name]) && isset($this->params[$name])){
            if($this->params[$name]['type']=='string')
                return $data[$name]->value_string;
            if($this->params[$name]['type']=='text')
                return $data[$name]->value_text;
            if($this->params[$name]['type']=='int')
                return $data[$name]->value_int;

        }
        return null;
    }

    public function set($name, $value)
    {
        if(!isset($this->params[$name]))
            return;
            
        $setting = App(Setting::class)->firstOrCreate(['code'=>$name]);

        if($this->params[$name]['type']=='string')
            $setting->value_string = $value;
        if($this->params[$name]['type']=='text')
            $setting->value_text = $value;
        if($this->params[$name]['type']=='int')
            $setting->value_int = intval($value);

        $setting->save();
        return $setting;
    }

    public function updateCache()
    {
        $cKey = 'settings';
        $data = App(Setting::class)->all()->keyBy('code');
        Cache::put($cKey, $data, 3600);
        return $data;
    }
    public function clearCache()
    {
        $cKey = 'settings';
        Cache::delete($cKey);
    }
    
    public function save(array $options = []) {
        $res = parent::save($options);
        $this->clearCache();
        return $res;
    }
}