<?php

class FormCommon
{

    const EDIT_THEME_BASIC = 1;
    const EDIT_THEME_FULL = 2;
    const EDIT_THEME_DESC = 3;

    private static $isLoad = false;

    /**
     * 编辑器
     * @param int $textareaid
     * @param int $toolbar    有basic full 和desc三种
     * @param int $color 编辑器颜色
     * @param string $alowuploadexts 允许上传类型
     * @param string $height 编辑器高度
     * @param string $disabled_page 是否禁用分页和子标题
     */
    public static function editor($textareaid = 'content', $toolbar = self::EDIT_THEME_BASIC, $up = true)
    {
        $str = '';
        if (!self::$isLoad)
        {
            $str .= '<script charset="utf-8" src="' . APP_ROOT . '/public/kindeditor/kindeditor-min.js"></script>';
            $str .= '<script charset="utf-8" src="' . APP_ROOT . '/public/kindeditor/lang/zh_CN.js"></script>';
            self::$isLoad = true;
        }
        $items = array();
        switch ($toolbar)
        {
            case self::EDIT_THEME_BASIC:
                break;
            case self::EDIT_THEME_DESC:
                $items = array(
                    'fullscreen',
                    'justifyleft',
                    'justifycenter',
                    'justifyright',
                    'justifyfull',
                    'insertorderedlist',
                    'clearhtml',
                    'removeformat',
                    'link',
                    'unlink',
                    'image',
                    'baidumap',
                );
                if (!$up)
                {
                    unset($items[10]);
                }
                break;
            case self::EDIT_THEME_FULL:
                $items = false;
                break;
        }
        $str .= '<script>';
        $str .= 'var editor;';
        $str .= 'KindEditor.ready(function(K) {';
        $str .= 'editor = K.create(\'#' . $textareaid . '\', {';
        $str .= 'themeType : \'simple\'';
        //$str .= '});';
        //$str .= 'K.create("' . $textareaid . '",{';
        //$str .= ',width:"700px;"';
        if (is_array($items))
        {
            $str .= ',items:["' . implode('","|","', $items) . '"]';
        }
        $str .= '});';
        $str .= '});';

        $str .= '</script>';
        return $str;
    }

    /**
     * 日期时间控件
     *
     * @param $name 控件name，id
     * @param $value 选中值
     * @param $isdatetime 是否显示时间
     * @param $loadjs 是否重复加载js，防止页面程序加载不规则导致的控件无法显示
     * @param $showweek 是否显示周，使用，true | false
     */
    public static function date($name, $value = '', $isdatetime = 0, $loadjs = 0)
    {
        if ($value == '0000-00-00 00:00:00')
        {
            $value = '';
        }
        $pattern = "/\[(.*)\]/";
        $id = preg_match($pattern, $name, $m) ? $m[1] : $name;
        if ($isdatetime)
        {
            $size = 21;
            $format = '%Y-%m-%d %H:%M:%S';
            $showsTime = 12;
        }
        else
        {
            $size = 10;
            $format = '%Y-%m-%d';
            $showsTime = 'false';
        }
        $str = '';
        if ($loadjs || !defined('CALENDAR_INIT'))
        {
            define('CALENDAR_INIT', 1);
            $str .= '<script src="' . APP_ROOT . '/public/date/js/jscal2.js"></script>
   				 <script src="' . APP_ROOT . '/public/date/js/lang/cn.js"></script>
   				 <link rel="stylesheet" type="text/css" href="' . APP_ROOT . '/public/date/css/jscal2.css" />
    				<link rel="stylesheet" type="text/css" href="' . APP_ROOT . '/public/date/css/border-radius.css" />
    				<link rel="stylesheet" type="text/css" href="' . APP_ROOT . '/public/date/css/steel/steel.css" />';
        }
        $str .= '<input type="text" name="' . $name . '" id="' . $id . '" value="' . $value . '" size="' . $size . '" class="date" readonly>&nbsp;';
        $str .= '<script type="text/javascript">
			Calendar.setup({
			weekNumbers: true,
		    inputField : "' . $id . '",
		    trigger    : "' . $id . '",
		    dateFormat: "' . $format . '",
		    showTime: ' . $showsTime . ',
		    minuteStep: 1,
		    onSelect   : function() {this.hide();}
			});
        </script>';
        return $str;
    }

    /**
     * 颜色控件
     *
     * @param $name 控件name
     * @param $value 选中值
     */
    public static function color($name, $value = '000000')
    {

        if (!defined('COLOR_INIT'))
        {
            define('COLOR_INIT', 1);
            $str = '<script src="' . B_PUBLIC . '/js/jscolor/jscolor.js"></script>';
        }
        $str .= '<input class="color" style="width:48px;height:16px;overfrom:hidden" name="' . $name . '" value="' . $value . '" />';

        return $str;
    }

}
