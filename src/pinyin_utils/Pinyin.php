<?php

namespace pinyin_utils;

/**
 * PHP 汉字转拼音 [包含20902个基本汉字+5059生僻字]
 * Pinyin::convert('云南昆明'); //编码为拼音首字母 
 * Pinyin::convert('云南网', 'all'); //编码为全拼音 
 * [all:全拼音|first:首字母|one:仅第一字符首字母]
 * @Author: tekintian
 * @Date:   2019-01-20 20:26:46
 * @Last Modified 2019-01-21
 */

class Pinyin {  
	  /**
	 * 中文转拼音 (utf8版,gbk转utf8也可用)
	 * @param string $str         utf8字符串
	 * @param string $ret_format  返回格式 [all:全拼音|first:首字母|one:仅第一字符首字母]
	 * @param string $placeholder 无法识别的字符占位符
	 * @param string $allow_chars 允许的非中文字符
	 * @return string  拼音字符串
	 */
	public static function convert($str, $ret_format = 'all', $placeholder = '_', $allow_chars = '/[a-zA-Z\d ]/') {
	    static $pinyins = null;
	
	    if (null === $pinyins) {
	    	//载入拼音字典
	    	require __DIR__ . '/pinyin_dict.php';
	        
	        $rows = explode('|', $dict);
	
	        $pinyins = array();
	        foreach($rows as $v) {
	            list($py, $vals) = explode(':', $v);
	            $chars = explode(',', $vals);
	
	            foreach ($chars as $char) {
	                $pinyins[$char] = $py;
	            }
	        }
	    }
	
	    $str = trim($str);
	    $len = mb_strlen($str, 'UTF-8');
	    $rs = '';
	    for ($i = 0; $i < $len; $i++) {
	        $chr = mb_substr($str, $i, 1, 'UTF-8');
	        $asc = ord($chr);
	        if ($asc < 0x80) { // 0-127
	            if (preg_match($allow_chars, $chr)) { // 用参数控制正则
	                $rs .= $chr; // 0-9 a-z A-Z 空格
	            } else { // 其他字符用填充符代替
	                $rs .= $placeholder;
	            }
	        } else { // 128-255
	            if (isset($pinyins[$chr])) {
	                $rs .= 'first' === $ret_format ? $pinyins[$chr][0] : ($pinyins[$chr] . ' ');
	            } else {
	                $rs .= $placeholder;
	            }
	        }
	
	        if ('one' === $ret_format && '' !== $rs) {
	            return $rs[0];
	        }
	    }
	
	    return rtrim($rs, ' ');
	}

} 