<?php

namespace trazvan;

class ToDo
{
    public static function readJSON()
    {
        return file_get_contents('2do.json');
    }

    private static function writeJSON($str)
    {
        file_put_contents('2do.json', $str);
        echo '<script>document.location.href=document.location.href</script>';
        exit;
    }

    public static function display($arr)
    {
        $opts = '';
        foreach ($arr as $k=>$v) {
            $checked = '';
            if ($v == 'checked') {
                $checked = 'class="checked"';
            }
            $opts .= '<li data-name="'.$k.'" '.$checked.'>'.$k.'</li>';
        }
        $str = '<ul id="myUL">'.$opts.'</ul>';
        return $str;
    }

    public static function prepareString($arr)
    {
        return htmlspecialchars(json_encode($arr));
    }

    public static function check($json, $val)
    {
        $arr = json_decode($json, true);
        foreach ($arr as $k=>$v) {
            if ($k == $val) {
                $arr[$k] = 'checked';
            }
        }
        $str = json_encode($arr);
        self::writeJSON($str);
    }

    public static function del($json, $val)
    {
        $res = [];
        $arr = json_decode($json, true);
        foreach ($arr as $k=>$v) {
            if ($k != $val) {
                $res[$k] = $v;
            }
        }
        $str = json_encode($res);
        self::writeJSON($str);
    }

    public static function add($json, $val)
    {
        $arr = json_decode($json, true);
        $arr[$val]="";
        $str = json_encode($arr);
        self::writeJSON($str);
    }
}
