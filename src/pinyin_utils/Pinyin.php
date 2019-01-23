<?php

namespace tekintian\pinyin_utils;

/**
 * 汉字转拼音，支持 utf-8 与gb2312编码， 
 * 
 * all:全拼音|first:首字母|one:仅第一字符首字母
 *
 * 使用方法：
 * $py= new tekintian\pinyin_utils\Pinyin($dict);
 * echo $py->convert('睿中*国aa5%，。砍砍');
 * // ruizhong_guoaa5_kankan
 * echo $py->getOne('睿中*国aa5%，。砍砍');
 * // r
 * 
 * 支持自定义字典转换
 * 自定义字典的拼音必须以  | 分隔，详细参见pinyin_dict_tiny.php的格式
 * @Author: Tekin
 * @Date:   2019-01-21 19:16:42
 * @Last Modified 2019-01-23
 * @Last Modified time: 2019-01-23 00:02:05
 */

class Pinyin
{
	//拼音字典
	protected $dict;
	/**
	 * [__construct description]
	 * @param string $dict [description]
	 */
	public function __construct($dict='')
	{
		if (empty($dict)) {
			//如果没有注入字典，则使用内置的精简版字典
			include_once __DIR__ . "/pinyin_dict_tiny.php";
			$this->dict=$dict;
		}else{
			$this->dict=$dict;
		}
	}

	/**
	 * 单个汉字转拼音
	 * @param  [type] $chr [description]
	 * @param  string $tab [description]
	 * @return [type]      [description]
	 */
	public function getOne($chr) {
		//传递多个汉字也只取第一个汉字的拼音
		if (ord(substr($chr,0,1)) < 160){
			$py = $chr;
		}else{
			 $chr =substr($chr,0,3);
		}

		//查找$chr在字典中第一次出现的位置
		$pos = strpos($this->dict, $chr);
		//截取$chr第一次出现位置前的内容
		$_lstr = substr($this->dict, 0, $pos);
		// strrchr — 查找指定字符在字符串中的最后一次出现,并返回剩下的字符串
		$_rstr = strrchr($_lstr, "|");
		// $pos = strpos($_rstr, ":");
		// $py = substr($_rstr, 1, $pos - 1);

		preg_match('/([a-zA-Z]+)/',$_rstr,$matches);

		return $matches[1];
	}

	/**将字串转为拼音
	  *@param int $need_first_letter 是否要返回 字符串转化后的手写字母以及全拼组合成的字符串,两者用逗号分割开来
	  *	eg:东湖花园  返回   dhhy,donghuhuayuan
	 */
	public function convert($_string, $ret_format = 'all', $placeholder = '_', $allow_chars = '/[a-zA-Z\d ]/'){

	    if ( strlen(utf8_decode($_string)) == strlen($_string) ) {   
	        // $string is not UTF-8
	       $_string = iconv("GB2312", "UTF-8", $_string);
	    } 

		$cset = 3; //UTF-8编码中文占3个字节， GB2312中文占两个字节
		$py = "";
		$first_letter = '';//取汉字转为拼音后，每个单词的首字母组合成的字符串
		$p = 0;
		$len = strlen($_string);

		for ($i = 0; $i < $len; $i++) {
				$ch = substr($_string, $p, 1);
				if (ord($ch) < 160) { //160(10)=11xxxxxx(2)高位,表示两个字节的汉字
					if (preg_match($allow_chars, $ch)) { // 用正则控制输入的参数
		                $py .= $ch; // 0-9 a-z A-Z 空格
						$first_letter .= $ch;
		            } else { // 其他字符用填充符代替
		                $py .= $placeholder;
		            }
					$p++;
				} else {
					$ch = substr($_string, $p, $cset);
					$py .= $this->getOne($ch, $this->dict);
					$first_letter .= substr($this->getOne($ch, $this->dict), 0, 1);

					$p += $cset;
				}
				if ($p >= $len) break;
			}


		switch ($ret_format) {
			case 'one':
				//只取第一个汉字的首字母
				if (ord(substr($_string,0,1)) < 160){
					$py = $ch;
				}else{
					 $py = substr($this->getOne(substr($_string,0,3), $this->dict), 0, 1);
				}
				break;
			case 'first':
				//只取第一个汉字的首字母
			    $py = $first_letter;
				break;
			default:
				//默认 返回全部拼音
				$py = $py;
				break;
		}
	   return $py;
	}
}