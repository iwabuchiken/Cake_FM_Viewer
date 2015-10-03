<?php

	require_once 'CONS.php';
	
	class Utils {
		
		/**********************************
		* @param<br>
		* $key	=> e.g. "form"
		**********************************/
		public static function 
		isIn_Array_Tokens($tokens_base, $token, $key) {
			
			for ($i = 0; $i < count($tokens_base); $i++) {
				
				$t = $tokens_base[$i];
				
				if ($token['Token'][$key] == $t['Token'][$key]) {
					
					return true;
					
				}
			}
			
			return false;
			
		}
		
		public static function 
		get_HostName() {
			
			$pieces = parse_url(Router::url('/', true));
			
			return $pieces['host'];
			
		}//public function get_HostName()
		
		public static function
		get_CurrentTime2($labelType) {
			//REF http://stackoverflow.com/questions/470617/get-current-date-and-time-in-php
			date_default_timezone_set('Asia/Tokyo');
		
			switch($labelType) {
					
				case CONS::$timeLabelTypes["rails"]:
		
					return date('Y-m-d H:i:s', time());
		
				case CONS::$timeLabelTypes["basic"]:
		
					return date('Y/m/d H:i:s', time());
		
				case CONS::$timeLabelTypes["serial"]:
		
					return date('Ymd_His', time());
						
				default:
		
					return date('Y/m/d H:i:s', time());
		
			}//switch($labelType)
		
			// 		return date('m/d/Y H:i:s', time());
		
		}//function get_CurrentTime2($labelType)

		public static function 
		write_Log($dpath, $text, $file, $line) {
		
			$max_LineNum = CONS::$logFile_maxLineNum;
		
			$path_LogFile = join(
					DS,
					array($dpath, "log.txt"));
		
			/****************************************
				* Dir exists?
			****************************************/
			if (!file_exists($dpath)) {
					
				mkdir($dpath, $mode=0777, $recursive=true);
					
			}
		
			/****************************************
				* File exists?
			****************************************/
			if (!file_exists($path_LogFile)) {
					
				// 			mkdir($path_LogFile, $mode=0777);
				//REF touch http://php.net/touch
				$res = touch($path_LogFile);
					
				if ($res == false) {
		
					return;
		
				}
					
			}
		
			/****************************************
				* File => longer than the max num?
			****************************************/
			//REF read content http://www.php.net/manual/en/function.file.php
			$lines = file($path_LogFile);
		
			$file_Length = count($lines);
		
			$log_File = null;
		
			if ($file_Length > $max_LineNum) {
		
				$dname = dirname($path_LogFile);
					
				$new_name = join(
						DS,
						array(
								$dname,
								"log"."_".Utils::get_CurrentTime2(
										CONS::$timeLabelTypes['serial'])
								.".txt")
				);
		
				$res = rename($path_LogFile, $new_name);
					
			} else {
					
			}
		
			/******************************
			
				modify: file name
			
			******************************/
			$tmp = strpos(strtolower($file), "c");
			
			if ($tmp == 0) {
				
				$file = str_replace(ROOT, "", $file);
				
			}
			
			/****************************************
				* File: open
			****************************************/
			$log_File = fopen($path_LogFile, "a");
		
			/****************************************
				* Write
			****************************************/
			// 		//REF replace http://oshiete.goo.ne.jp/qa/3163848.html
			// 		$file = str_replace(ROOT.DS, "", $file);
		
			$time = Utils::get_CurrentTime();

			/**********************************
			* modify: dir path
			**********************************/
			//REF http://stackoverflow.com/questions/2192170/how-to-remove-part-of-a-string answered Feb 3 '10 at 13:33
			$file_new = str_replace(ROOT, "", $file);
			
			/**********************************
			* write
			**********************************/
			// 		$full_Text = "[$time : $file : $line] %% $text"."\n";
			$full_Text = "[$time : $file_new : $line] $text"."\n";
// 			$full_Text = "[$time : $file : $line] $text"."\n";
		
			$res = fwrite($log_File, $full_Text);
			
			/****************************************
				* File: Close
			****************************************/
			fclose($log_File);
				
		}//function write_Log($dpath, $text, $file, $line)
		
		public static function 
		get_CurrentTime() {
			//REF http://stackoverflow.com/questions/470617/get-current-date-and-time-in-php
			date_default_timezone_set('Asia/Tokyo');
		
// 			return date('m/d/Y H:i:s.u', time());
			return date('m/d/Y H:i:s', time());
		
		}
		
		public static function 
		get_dPath_Log() {
				
			return join(DS, array(ROOT, "lib", "log"));
			// 			return join(DS, array(ROOT, "lib", "log", "log.txt"));
				
		}
		
		public static function 
		get_fPath_DB_Sqlite() {
				
			$msg = "WEBROOT_DIR => ".WEBROOT_DIR
			."/"
					."WWW_ROOT => ".WWW_ROOT;
				
// 			write_Log(
// 			CONS::get_dPath_Log(),
// 			// 				$this->get_dPath_Log(),
// 			$msg,
// 			__FILE__,
// 			__LINE__);
				
				
			return join(DS,
					array(ROOT, APP_DIR, WEBROOT_DIR, CONS::$dbName_Local));
			// 					array(ROOT, APP_DIR, WEBROOT_DIR, $this->dbName_Local));
				
		}

		public static function
		conv_Float_to_TimeLabel ($float_time) {
				
			// 			$integer = (int) $float_time;
			// 			$integer = floor($float_time) / 1;
			$integer = floor($float_time);
			// 			$integer = (int)intval($float_time, 10);
			// 			$integer = (int)intval($float_time);
			// 			$integer = intval($float_time);
			// 			$integer = (intval)floor($float_time);
			// 			$integer = floor($float_time);
				
			$decimal = $float_time - $integer;
				
			$sec_num = $integer;
			// 			$sec_num = parseInt($float_time, 10); // don't forget the $second param
			$hours   = floor($sec_num / 3600);
			$minutes = floor(($sec_num - ($hours * 3600)) / 60);
			$seconds = $sec_num - ($hours * 3600) - ($minutes * 60);
		
			if ($hours   < 10) {$hours_str   = "0$hours";}
			else {$hours_str = $hours;}
		
			if ($minutes < 10) {$minutes_str = "0$minutes";}
			else {$minutes_str = $minutes;}
				
			if ($seconds < 10) {$seconds_str = "0".number_format(($seconds + $decimal), 3, '.', '');}
			else {$seconds_str = number_format(($seconds + $decimal), 3, '.', '');}
			// 				else {$seconds_str = ($seconds + $decimal);}
		
			// 			$time    = "$hours:$minutes:$seconds.".number_format($decimal, 3, '.', '');
			//REF http://www.php.net/manual/en/function.number-format.php
			// 			$time    = "$hours_str:$minutes_str";
				
			if ($hours == "00") {
					
				$time    = "$minutes_str:$seconds_str";
		
			} else {
					
				$time    = "$hours_str:$minutes_str:$seconds_str";
					
			}
			;
		
			// 			$time    = "$hours_str:$minutes_str:$seconds_str";
			// 			$time    = "$hours:$minutes:"
			// 						.number_format(($seconds + $decimal), 3, '.', '');
			// 			$time    = "$integer.$decimal";
				
			return $time;
				
		}//conv_Float_to_TimeLabel ($float_time)

		public static function 
		startsWith
		($haystack, $needle) {
			$length = strlen($needle);
			return (substr($haystack, 0, $length) === $needle);
		}
		
		public static function 
		endsWith
		($haystack, $needle) {
			$length = strlen($needle);
			if ($length == 0) {
				return true;
			}
		
			return (substr($haystack, -$length) === $needle);
		}

		/**********************************
		* csv_to_array
		* 
		* Steps for handling multibyte chars in a csv file
		* 	1. setlocale()	=> that's it
		* 		=> syntax is ---> setlocale(LC_ALL, 'ja_JP.UTF-8');
		* 		=> notice: encoding string needed after the locale place string
		* 			---> i.e. "UTF-8" after "ja_JP", preceeded by a dot "."
		**********************************/
		//REF http://php.net/manual/ja/function.str-getcsv.php
		public static function
		csv_to_array
		($filename='', $delimiter=',') {
			
// 			//test
// 			Utils::write_Log(
// 					Utils::get_dPath_Log(),
// 					//REF http://www.phpbook.jp/func/string/index7.html
// 					"mb_internal_encoding => ".mb_internal_encoding(),
// 					__FILE__, __LINE__);
					
			
			//test
// 			setlocale(LC_ALL, 'ja-JP');
			setlocale(LC_ALL, 'ja_JP.UTF-8');
			
			/**********************************
			* validate
			**********************************/
			if(!file_exists($filename) || !is_readable($filename))
				return FALSE;
		
			// 		$header = NULL;
			$data = array();
		
			if (($handle = fopen($filename, 'r')) !== FALSE) {
					
				while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
		
					// 				if(!$header)
						// 					$header = $row;
						// 				else
							// 					$data[] = array_combine($header, $row);
						array_push($data, $row);
		
				}
					
				fclose($handle);
					
			}
		
			return $data;
		
		}//csv_to_array

		public static function
		_get_Selector_Category() {
		
			$this->loadModel('Category');
		
			$option = array('order' => array('Category.name' => 'asc'));
		
			$genres = $this->Category->find('all', $option);
		
			$select_Categories = array();
		
			foreach ($genres as $genre) {
		
				$genre_Name = $genre['Category']['name'];
				$genre_Id = $genre['Category']['id'];
		
				$select_Categories[$genre_Id] = $genre_Name;
		
			}
		
			return $select_Categories;
		
		}//_get_Selector_Category
		
		public static function
		_get_Selector_Category_From_GenreID($id) {
		
			//REF http://stackoverflow.com/questions/2802677/what-are-the-possible-reasons-for-appimport-not-working answered May 10 '10 at 13:18
			$model = ClassRegistry::init('Category');
			
// 			$option = array('order' => array('Category.name' => 'asc'));
				
// 			$this->loadModel('Category');
		
			if ($id != null) {
					
				$option = array(
							
						'order' => array('Category.name' => 'asc'),
						'conditions'	=> array('Category.genre_id' => $id)
							
				);
					
			} else {
					
				$option = array('order' => array('Category.name' => 'asc'));
					
			}
		
		
			$categories = $model->find('all', $option);
// 			$categories = $this->Category->find('all', $option);
		
			$select_Categories = array();
		
			foreach ($categories as $category) {
		
				$category_Name = $category['Category']['name'];
				$category_Id = $category['Category']['id'];
		
				$select_Categories[$category_Id] = $category_Name;
		
			}
		
			return $select_Categories;
		
		}//_get_Selector_Category
		
		public static function
		_get_Selector_Genre() {
		
// 			$this->loadModel('Genre');
// 			App::import("Genre");
		
// 			$model = new Genre();
	
			//REF http://stackoverflow.com/questions/2802677/what-are-the-possible-reasons-for-appimport-not-working answered May 10 '10 at 13:18
			$model = ClassRegistry::init('Genre');
						
			$option = array('order' => array('Genre.name' => 'asc'));
			
			$genres = $model->find('all', $option);
			
		
// 			$genres = $this->Genre->find('all', $option);
			// 		$genres = $this->Genre->find('all');
		
			$select_Genres = array();
		
			foreach ($genres as $genre) {
		
				$genre_Name = $genre['Genre']['name'];
				$genre_Id = $genre['Genre']['id'];
		
				$select_Genres[$genre_Id] = $genre_Name;
		
			}
		
			return $select_Genres;
		
		}//_get_Selector_Genre

		public static function
		isKanji_All
		($str) {
			
			foreach ($str as $chr) {
			
				if (!preg_match("/^[一-龠]+$/u",$chr)) {
					
					return false;
					
				};
			
			}
			
			return true;
			
		}//isKanji_All
		
		/**********************************
		* @return
		* 	1	=> Kanji<br>
		* 	2	=> Hiragana<br>
		* 	3	=> Katakana<br>
		* 	4	=> Number<br>
		**********************************/
		public static function
		get_Type
		($str) {
			
			$flag = true;
			
			/**********************************
			* kanji
			**********************************/
			//REF http://stackoverflow.com/questions/2556289/php-split-multibyte-string-word-into-separate-characters answered Mar 31 '10 at 21:56
			foreach (preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY) as $chr) {
// 			foreach ($str as $chr) {
			
// 				debug($chr);
				
				if (!preg_match("/^[一-龠]+$/u",$chr)) {
					
					$flag = false;
					
// 					debug("not match, kanji");
					
					break;
					
				} else {
					
// 					debug("mactch, kanji");
					
				}
			
			}
			
			if ($flag == true) {
				
// 				debug("all match, kanji");
				
				return 1;
				
			}
			
			/**********************************
			* hiragana
			**********************************/
			$flag = true;
			
			foreach (preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY) as $chr) {
// 			foreach ($str as $chr) {
			
// 				debug($chr);
				
				if (!preg_match("/^[ぁ-んー]+$/u",$chr)) {
					
// 					debug("not match, hira");
					
					$flag = false;
					
					break;
					
				} else {
					
// 					debug("match, hira");
					
				}
			
			}
			
			if ($flag == true) {
				
// 				debug("all match, hira");
				
				return 2;
				
			}
			
			/**********************************
			* katakana
			**********************************/
			$flag = true;
			
			foreach (preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY) as $chr) {
// 			foreach ($str as $chr) {
			
// 				debug($chr);
				
				if (!preg_match("/^[ァ-ヶー]+$/u",$chr)) {
					
// 					debug("not match, hira");
					
					$flag = false;
					
					break;
					
				} else {
					
// 					debug("match, hira");
					
				}
			
			}
			
			if ($flag == true) {
				
// 				debug("all match, hira");
				
				return 3;
				
			}
			
			/**********************************
			* number
			**********************************/
			$flag = true;
			
			foreach (preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY) as $chr) {
// 			foreach ($str as $chr) {
			
// 				debug($chr);
				
				if (!preg_match("/^[0-9０-９]+$/u",$chr)) {
					
// 					debug("not match, hira");
					
					$flag = false;
					
					break;
					
				} else {
					
// 					debug("match, hira");
					
				}
			
			}
			
			if ($flag == true) {
				
// 				debug("all match, hira");
				
				return 4;
				
			}
			
			return 0;
			
// 			return true;
			
		}//isKanji_All

		/**********************************
		* from: test_Texts.php: test_ArraySlice($sen, $numOf_SubSentences, $split_Char)
		**********************************/
		public static function
		breakdown_Sentence
		($sen, $numOf_SubSentences, $split_Char) {

			/**********************************
			* prep: data
			**********************************/
			$ary = mb_split($split_Char, $sen);
		
			$numOf_Tokens = count($ary);
		
			/**********************************
			 * slice
			**********************************/
			$numOf_Lots = $numOf_SubSentences;
		
			$numOf_Tokens_perLot = intval(ceil($numOf_Tokens / $numOf_Lots));
		
			$ary_SlicedArrays = array($numOf_Lots);
		
			for ($i = 0; $i < $numOf_Lots; $i++) {
		
				$ary_SlicedArrays[$i] = array_slice(
						$ary,
						$numOf_Tokens_perLot * $i,
						$numOf_Tokens_perLot);
		
			}
		
			/**********************************
			* return
			**********************************/
			return $ary_SlicedArrays;
			
		}//breakdown_Sentence

		/**********************************
		* REF http://www.kinghost.com.br/php/ref.simplexml.php 09-Dec-2011 08:31
		* 
		* parameters of the original => &$base, $add
		* changed to				=> $base, $add
		**********************************/
		public static function
		mergeXML($base, $add) {
// 		mergeXML(&$base, $add) {
			$new = $base->addChild($add->getName());
			foreach ($add->attributes() as $a => $b) {
				$new[$a] = $b;
			}
			foreach ($add->children() as $child) {
				
				Utils::mergeXML($new, $child);
// 				$this->mergeXML($new, $child);
			}
			
			/**********************************
			* return => this code is not in the REF code
			**********************************/
			return $base;
			
		}
		
		public static function
// 		mergeXML_2(&$base, $add) {
		mergeXML_2($base, $add) {
			
			$new = $base->addChild($add->getName());

			$new->surface = $add->surface;
			$new->feature = $add->feature;
			
// 			/**********************************
// 			* return => this code is not in the REF code
// 			**********************************/
			return $base;
			
		}//mergeXML_2

		/**********************************
		 * @return
		*
		* 	=> array(words)
		*
		*	Copied from => HistorysController._view_Mecab($history)
		**********************************/
		public static function
		get_Mecab_WordsArray($text) {
		
			/**********************************
				* prep: sentences
			**********************************/
			$sen = $text;
// 			$sen = $this->sanitize($history['History']['content']);
		
			/**********************************
				* experi
			**********************************/
			$max = 800;
		
			if (mb_strlen($sen) > $max) {
					
				$words_ary = Utils::get_Mecab_WordsArray__MultiLots($sen, $max);
// 				$words_ary = $this->_view_Mecab__MultiLots($sen, $max);
					
			} else {
		
				$url = "http://yapi.ta2o.net/apis/mecapi.cgi?sentence=$sen";
		
				//REF http://stackoverflow.com/questions/12542469/how-to-read-xml-file-from-url-using-php answered Sep 22 '12 at 9:17
				$xml = simplexml_load_file($url);
		
				$words_ary = array($xml->word);
				// 			$words = $xml->word;
					
			}
		
			return $words_ary;
		
		}//get_Mecab_WordsArray
		
		public static function
		get_Mecab_WordsArray__MultiLots($sen, $max) {
		
// 			debug("mb_strlen(\$sen) > $max");
				
// 			debug("needs => ".intval(ceil(mb_strlen($sen) / $max))." lots");
		
		
			/**********************************
				* split: original sentence
			**********************************/
			$sen_Array = mb_split("。", $sen);
		
// 			debug("sen_Array => ".count($sen_Array));
		
			$numOf_SentenceArray = count($sen_Array);
		
			/**********************************
				* prep: sentences derived from the original
			**********************************/
			$numOf_Lots = intval(ceil(mb_strlen($sen) / $max));
		
// 			debug("numOf_Lots => $numOf_Lots");
		
			$numOf_Senteces_perLot = intval(ceil($numOf_SentenceArray / $numOf_Lots));
		
// 			debug("numOf_Senteces_perLot => $numOf_Senteces_perLot");
		
			/**********************************
				* split: original sentence => again
			**********************************/
			$split_Char = "。";
		
			$ary_SlicedArrays = Utils::breakdown_Sentence($sen, $numOf_Lots, $split_Char);
		
			$numOf_SlicedArrays = count($ary_SlicedArrays);
		
// 			debug("ary_SlicedArrays => ".$numOf_SlicedArrays);
			// 		debug("ary_SlicedArrays => ".count($ary_SlicedArrays));
		
			// get xmls
			$xmls = array($numOf_SlicedArrays);
		
			for ($i = 0; $i < $numOf_SlicedArrays; $i++) {
					
				$text = implode($split_Char, $ary_SlicedArrays[$i]);
					
				$url = "http://yapi.ta2o.net/apis/mecapi.cgi?sentence=$text";
					
				$xmls[$i] = simplexml_load_file($url);
					
			}
		
			/**********************************
				* shorten sentence
			**********************************/
			$sen = mb_substr($sen, 0, $max);
		
			$url = "http://yapi.ta2o.net/apis/mecapi.cgi?sentence=$sen";
		
			//REF http://stackoverflow.com/questions/12542469/how-to-read-xml-file-from-url-using-php answered Sep 22 '12 at 9:17
			$xml = simplexml_load_file($url);
		
			if ($xmls == null) {
		
				return array($xml->word);
					
			} else {
		
				$num = count($xmls);
					
				$words_ary = array();
				// 			$words_ary = array($num);
					
				for ($i = 0; $i < $num; $i++) {
		
					array_push($words_ary, $xmls[$i]);
		
				}
					
				return $words_ary;
					
			}
		
		}//get_Mecab_WordsArray__MultiLots

		public static function
		get_Words($text) {
		
			$sen = Utils::_sanitize($text);
// 			$sen = $this->_sanitize($text);
		
// 			debug("\$sen is...");
// 			debug($sen);
			
			$max = 800;
			// 		$max = 1500;	//=> error
			// 		$max = 2000;	//=> error
			
			if (mb_strlen($sen) > $max) {
					
				$words_ary = Utils::get_Mecab_WordsArray__MultiLots($sen, $max);
// 				$words_ary = $this->_view_Mecab__MultiLots($sen, $max);
				// 			$words = $this->_view_Mecab__MultiLots($sen, $max);
					
			} else {
			
				$url = "http://yapi.ta2o.net/apis/mecapi.cgi?sentence=$sen";
			
				//REF http://stackoverflow.com/questions/12542469/how-to-read-xml-file-from-url-using-php answered Sep 22 '12 at 9:17
				$xml = simplexml_load_file($url);
			
				$words_ary = array($xml->word);
				// 			$words = $xml->word;
					
			}
			
			return $words_ary;
				
		}//_view_Mecab

		public static function
		_sanitize
		($str, $tag="font") {
		
			$tag = "font";
			$p = "/<$tag.+?>(.+)<\/$tag>/";
		
			$rep = '${1}';
		
			return preg_replace($p, $rep, $str);
		
		}

		public static function
		get_BS_Subject($token_Sen, &$id) {
			
			$ary_Ha = array();
			
			for ($i = 0; $i < count($token_Sen); $i++) {
					
				$token_Combo = array();
					
// 				debug("\$token_Sen[".$i."] is...");
// 				debug($token_Sen[$i]);
				
				if ($token_Sen[$i]['Token']['form'] == 'は'
						&& $token_Sen[$i]['Token']['hin'] == '助詞'
// 						&& $token_Sen[$i]['Token']['history_id'] == '82'
						// 					&& $tokens[$i]['Token']['insentence_id'] == $i
				) {
			
					debug("yes => ");
					array_push($token_Combo, $token_Sen[$i]);
					array_push($token_Combo, $i);
			
					array_push($ary_Ha, $token_Combo);
					// 				array_push($text_Ha_ary, $token_Sen[$i]);
			
				}
				
			}

			/**********************************
			* validate
			**********************************/
			if (count($ary_Ha) < 1) {
				
				debug("\$ary_Ha => no entry");
				
				return null;
				
			}
			
			/**********************************
			* build: word
			**********************************/
			
			$bs_Subject = Utils::get_Word_Ha($token_Sen, $ary_Ha[0]);
			
			$id = $ary_Ha[0][1];
			
			return $bs_Subject;
			
// 			debug("count(\$ary_Ha) is ...");
// 			debug(count($ary_Ha));
// 			debug($ary_Ha[0]);
// 			debug($token_Combo);
			
		}//get_BS_Subject

		public static function
		get_BS_Verb($token_Sen, $start_Id) {
			
			$ary_Verb = array();
			
			for ($i = $start_Id; $i < count($token_Sen); $i++) {
// 			for ($i = 0; $i < count($token_Sen); $i++) {
					
				$token_Combo = array();
				
				if (
// 						$token_Sen[$i]['Token']['form'] == 'は'
// 						&& $token_Sen[$i]['Token']['hin'] == '助詞'
						$token_Sen[$i]['Token']['hin'] == '動詞'
// 						&& $token_Sen[$i]['Token']['history_id'] == '82'
						// 					&& $tokens[$i]['Token']['insentence_id'] == $i
				) {
			
					debug("yes => ");
					array_push($token_Combo, $token_Sen[$i]);
					array_push($token_Combo, $i);
			
					array_push($ary_Verb, $token_Combo);
					// 				array_push($text_Ha_ary, $token_Sen[$i]);
			
				}
				
			}

			/**********************************
			* validate
			**********************************/
			if (count($ary_Verb) < 1) {
				
				debug("\$ary_Verb => no entry");
				
				return null;
				
			}
			
			/**********************************
			* build: word
			**********************************/
			$bs_Verb = Utils::get_Word_Verb($token_Sen, $ary_Verb[0]);
			
			return $bs_Verb;
			
		}//get_BS_Verb

		
		public static function
		get_Word_Ha($tokens, $combo) {
		
			$insentence_Id = $combo[1];
		
			$word_Final = $combo[0]['Token']['form'];
		
			// 		debug("\initial \$word_Final is...");
			// 		debug($word_Final);
		
			$token_Index_Offset = -1;
		
			$target_Index = $insentence_Id + $token_Index_Offset;
		
			while ($target_Index >= 0) {
					
				$token_Prev = $tokens[$target_Index];
					
				if ($token_Prev['Token']['hin'] != '名詞') {
		
					break;
		
				}
					
				// 			debug($token_Prev['Token']['form']);
					
				$word_Final = $token_Prev['Token']['form'].$word_Final;
					
				// 			debug($word_Final);
					
				$target_Index --;
					
			}
		
			return ($word_Final == $combo[0]['Token']['form']) ? null : $word_Final;
			// 		return ($token_Index_Offset == -1) ? null : $word_Final;
			// 		if ($insentence_Id > 0) {
				
			// 			$token_Prev = $tokens[$insentence_Id - 1];
				
			// 			debug($token_Prev['Token']['form']);
				
			// 			$word_Final = $token_Prev['Token']['form'].$word_Final;
				
			// 			debug($word_Final);
				
			// 		}
		
		}
		
		public static function
		get_Word_Verb($tokens, $combo) {
		
			$insentence_Id = $combo[1];
		
			$word_Final = $combo[0]['Token']['form'];
		
			// 		debug("\initial \$word_Final is...");
			// 		debug($word_Final);
		
			$token_Index_Offset = 1;
// 			$token_Index_Offset = -1;
		
			$target_Index = $insentence_Id + $token_Index_Offset;
		
			while ($target_Index < count($tokens)) {
					
				$token_Next = $tokens[$target_Index];
					
				if ($token_Next['Token']['form'] == '。'
					|| $token_Next['Token']['form'] == '、') {

					$word_Final .= $token_Next['Token']['form'];
					
					break;
		
				} else {
					
					$word_Final .= $token_Next['Token']['form'];
					
				}
					
				// 			debug($token_Prev['Token']['form']);
					
// 				$word_Final = $token_Next['Token']['form'].$word_Final;
					
				// 			debug($word_Final);
					
				$target_Index ++;
					
			}
		
			return ($word_Final == $combo[0]['Token']['form']) ? null : $word_Final;
			// 		return ($token_Index_Offset == -1) ? null : $word_Final;
			// 		if ($insentence_Id > 0) {
				
			// 			$token_Prev = $tokens[$insentence_Id - 1];
				
			// 			debug($token_Prev['Token']['form']);
				
			// 			$word_Final = $token_Prev['Token']['form'].$word_Final;
				
			// 			debug($word_Final);
				
			// 		}
		
		}

		/*******************************
			@param
			$hist_id	=> History id
		*******************************/
		public static function
		exists_History($hist_id) {
			
			/*******************************
				load
			*******************************/
// 			$option = array('conditions' => array('id' => $hist_id));
			$option = array('conditions' => array('History.id' => $hist_id));
			
			$model = ClassRegistry::init('History');
			
// 			$hist = $model->find('first', $option);

			try {
				
				$hist = $model->find('first', $option);
				
			} catch (Exception $e) {
				
				debug($e);
				
			}
			
			if ($hist != null) {
				
				return true;
				
			} else {
				
				return false;
				
			}
			
		}//exists_History($hist_id)
		
		public static function
		get_Category_From_Id($cat_Id) {

			/*******************************
				get: category
			*******************************/
// 			$this->loadModel('Category');
			$model = ClassRegistry::init('Category');
			
			$option = array('conditions' => array('Category.id' => $cat_Id));
			
			return $model->find('first', $option);
// 			return $this->Category->find('first', $option);
				
		}

		public static function
		get_Category_From_Name($cat_Name) {

			/*******************************
				get: category
			*******************************/
// 			$this->loadModel('Category');
			$model = ClassRegistry::init('Category');
			
			$option = array('conditions' => array('Category.name' => $cat_Name));
			
			return $model->find('first', $option);
// 			return $this->Category->find('first', $option);
				
		}

		public static function
		get_Genre_From_Genre_Code($genre_code) {

			/*******************************
				get: category
			*******************************/
// 			$this->loadModel('Category');
			$model = ClassRegistry::init('Genre');
			
			$option = array('conditions' => array('Genre.code' => $genre_code));
			
			return $model->find('first', $option);
// 			return $this->Category->find('first', $option);
				
		}

		public static function
		sanitize_Tags($article_line, $tag_array) {
			
			for ($i = 0; $i < count($tag_array); $i++) {
				
				$tag = $tag_array[$i];
				
				$pattern = "/<$tag.*?>/";
// 				$pattern = "/<$tag.+>/";
// 				$pattern = "<$tag.+>";
				$replacement = "";
				
				$article_line = preg_replace($pattern, $replacement, $article_line);
// 				preg_replace($pattern, $replacement, $article_line);
				
				$pattern = "/<\/$tag>/";
// 				$pattern = "/<$tag.+>/";
// 				$pattern = "<$tag.+>";
				$replacement = "";
				
				$article_line = preg_replace($pattern, $replacement, $article_line);
// 				preg_replace($pattern, $replacement, $article_line);
				
			}
			
			return $article_line;
			
		}//sanitize_Tags

		public static function
		unset_Vars($target, $var_Array) {
			
			$count = 0;
			
			foreach ($var_Array as $v) {
				
				unset($target[$v]);
// 				unset($v);
				
				$count ++;
				
			}
			
			return $target;
// 			return $count;
			
		}//unset_Vars

		public static function
		find_Tokens_from_CatId($cat_id) {
			
			/*******************************
				model
			*******************************/
			$model = ClassRegistry::init('Token');
			
			/*******************************
			 get: tokens
			*******************************/
			$option = array('conditions' =>
			
// 					array("AND" =>
							array("Token.category_id" => $cat_id),
// 							array('Token.hin' => "名詞")
// 					),
			);//array('conditions'
			
			$tokens = $model->find('all', $option);

			return $tokens;
			
		}//find_Tokens_from_CatId_and_Hin

		public static function
		find_Genre_from_Code($code) {
			
			/*******************************
				model
			*******************************/
			$model = ClassRegistry::init('Genre');
			
			/*******************************
			 get: tokens
			*******************************/
			$option = array('conditions' =>
			
// 					array("AND" =>
							array("Genre.code" => $code),
// 							array('Token.hin' => "名詞")
// 					),
			);//array('conditions'
			
			$genre = $model->find('first', $option);

			return $genre;
			
		}//find_Genre_from_Code($code)

		/*******************************
			@return
			$histo, $total
		*******************************/
		
		public static function
		get_Histo($tokens_1) {
			
			/*******************************
			 build: list
			*******************************/
			$s = "";
			
			$nouns = array();
			
			for ($i = 0; $i < count($tokens_1); $i++) {
					
				$t = $tokens_1[$i];
					
				if ($t['Token']['hin'] == "名詞") {
			
					$s .= $t['Token']['form'];
			
					continue;
			
				} else {
			
					if ($s == "") {
			
						continue;
			
					} else {
			
						// 					if ($s != null) {	//=> w
						// 					if ($s != null && $s != "") {	//=> w
						if ($s != null && $s != "" && $s != -1) {	//=> w
							// 					if ($s != null && $s != "" && $s != -1 && $s != 0) {	//=> debug displayed
							// 					if ($s != null && $s != "" && $s != -1 && $s != 0) {
							// 					if ($s != "０" && $s != "0") {
							// 					if ($s != "０") {
			
							// 						debug($s);
			
							array_push($nouns, $s);;
			
						} else {
			
//							debug($s);
			
						}
							
						// 					array_push($nouns, $s);
							
						$s = "";
							
						continue;
			
					}
			
				}//if ($t['Tokens']['hin'] == "名詞")
					
			}//for ($i = 0; $i < count($tokens_1); $i++)
			
			$nouns_unique = array_unique($nouns);
			
// 			debug("count(\$nouns_unique)");
// 			debug(count($nouns_unique));
			
				// 		// omit '0'
				// 		$len = count($nouns_unique);
			
			// // 		debug($nouns_unique[10]);
			
			// // 		debug(array_slice($nouns_unique, 600, 10));
			// // 		debug($len);
			
			// 		for ($i = 0; $i < $len; $i++) {
			// // 		for ($i = 0; $i < count($nouns_unique); $i++) {
				
			// 			debug($nouns_unique[$i]."(".$i.")");
				
			// // 			$noun = $nouns_unique[$i];
			// // 			$n = $nouns_unique[$i];
				
			// // 			if ($n == "0") {
			// // // 			if ($n == '0') {
			
			// // 				debug("yes");
			// // // 				debug("='0'");
			
			// // 			}
			// 		}
			
			
			// // 		$nouns_unique = array_diff($nouns_unique, array('0'));
			
			
//			debug("count(\$nouns_unique)");
//			debug(count($nouns_unique));
			
			$len_unique = count($nouns_unique);
			
			$nouns_unique = array_values($nouns_unique);
			
// 			// 		// omit '0'
// 			// 		unset($nouns_unique[0]);
			
// 			// 		debug("unset => \$nouns_unique[0]");
			
// 			// 		debug(array_slice($nouns_unique, 0, 20));
			
// 			for ($i = 0; $i < $len_unique; $i++) {
// 				// 		for ($i = 0; $i < count($nouns_unique); $i++) {
			
// 				$n = $nouns_unique[$i];
					
// 				if ($n == '0') {
			
// //					debug("='0'");
			
// 				} else if ($n == "0") {
			
// //					debug("=\"0\"");
			
// 				} else if ($n == "０") {
			
// //					debug("=\"０\"");
			
// 				}
					
					
// 				// 			debug($nouns_unique[$i]."(".$i.")");
			
// 				// 			$noun = $nouns_unique[$i];
// 				// 			$n = $nouns_unique[$i];
			
// 				// 			if ($n == "0") {
// 				// // 			if ($n == '0') {
			
// 				// 				debug("yes");
// 				// // 				debug("='0'");
			
// 				// 			}
// 			}
			
// 			// 		$nouns_unique = array_diff($nouns_unique, array("０"));
			
// 			// 		$len_unique = count($nouns_unique);
			
// 			// 		$nouns_unique = array_values($nouns_unique);
			
			/*******************************
			 histogram
			*******************************/
			$histo = array($len_unique);
			
			for ($i = 0; $i < $len_unique; $i++) {
					
				$histo[$nouns_unique[$i]] = 0;
					
			}
			
			$len_total = count($nouns);
			
			for ($i = 0; $i < $len_total; $i++) {
					
				$histo[$nouns[$i]] ++;
					
			}
			
			// 		debug(array_slice($histo, 0, 10));
			
			/*******************************
			 sort
			*******************************/
			asort($histo);
			
			$histo = array_reverse($histo);
			
			// omit '0'
			$omit = array(0);
// 			$omit = array(0, 'こと', '人', 'ロボット', '理由', '場合', '中止', 'ため', 'の');
			
			$histo = Utils::unset_Vars($histo, $omit);
// 			// 		$histo = Utils::unset_Vars($histo, array(0, 'こと', '人', 'ロボット'));
// 			// 		$histo = Utils::unset_Vars($histo, array(0, 'こと'));	//=> w
// 			// 		$histo = Utils::unset_Vars($histo, array(0));	//=> w
// 			// 		Utils::unset_Vars($histo, array(0));
// 			// 		Utils::unset_Vars(array($histo[0], $histo['こと']));
// 			// 		unset($histo[0]);
			
// 			// 		debug($histo);
			
			/*******************************
			 set: values
			*******************************/
			$total = 0;
			
			// 		debug(array_slice($histo, 10,10));
			
			// 		$total += $histo[0] + $histo[1];
			
			// 		debug($total);
			
			// 		debug($histo[0]);
			// 		debug($histo[1]);
			
			$count = 0;
			
			foreach ($histo as $h) {
					
				$total += $h;
					
				// 			debug($h."/".$total);
					
				// 			$count ++;
					
				// 			if ($count > 10) {
			
				// 				break;;
			
				// 			}
					
			}
			
			// 		debug($total);
			
			// 		for ($i = 0; $i < count($histo); $i++) {
				
			// 			$total += $histo[$i];
				
			// 		}
			
// 			$this->set("total", $total);
// 			// 		$this->set("total", count($nouns));
// 			// 		$this->set("total", count($tokens));
			
// 			$this->set("histo", $histo);

			return array($histo, $total);
			
// 			return array();
			
		}//get_Histo

		public static function
		get_Admin_Value
		($key, $val_1) {
		
// 			$this->loadModel('Admin');
	
			//REF http://stackoverflow.com/questions/2802677/what-are-the-possible-reasons-for-appimport-not-working answered May 10 '10 at 13:18
			$model = ClassRegistry::init('Admin');
		
			$option = array(
						
					'conditions'	=> array(
							'Admin.name LIKE'	=> $key
					)
			);
		
			// 		$admin = $this->Admin->find('first');
			$admin = $model->find('first', $option);
// 			$admin = $this->Admin->find('first', $option);
		
			// 		debug($admin);
		
			if ($admin == null) {
			
				return null;
			
			} else {
			
				return @$admin['Admin'][$val_1];
				
			}//if ($admin == null)
			
			
			
// 			return @$admin['Admin'][$val_1];
		
		}//get_Admin_Value


		public static function
		get_Matching_Scores($keys_Target, $keys_Ref) {
			
			$score_1 = 0;
			
			for ($i = 0; $i < $len; $i++) {
			
				for ($j = 0; $j < $len; $j ++) {
					// 			foreach ($keys_Ref as $data) {
					// 			foreach ($data_1[0] as $data) {
			
					$data = $keys_Ref[$j];
						
					if ($keys_Target[$i] == $data) {
			
						$score_1 ++;
			
						// 					debug("match => ".$keys_Target[$i]." / ".$data);
			
					}
				}
			
			}

			return $score_1;
			
		}//get_Matching_Scores

		public static function
		create_Tokens($cat_Id) {
			
			/*******************************
			 get: history list
			*******************************/
			$model = ClassRegistry::init('History');
			
			$option = array('conditions'
					=> array(
							'History.category_id'
							=> $cat_Id));
			
			$histories = $model->find('all', $option);
			
			/*******************************
			 validate: any history
			*******************************/
			if (count($histories) < 1) {
			
				debug("no history for category id: ".$cat_Id);
				
// 				$this->Session->setFlash(__('no history for category id: '.$cat_Id));
			
// 				$this->render("/Historys/tests/create_Tokens");
			
				return null;
			
			} else {
			
				debug("count(\$histories)");
				debug(count($histories)."(".$histories[0]['History']['genre_id'].")");
			
			}
			
			/**********************************
			 * validate:
			**********************************/
			$count = 0;
			
			foreach ($histories as $history) {
				
				$res = Utils::_save_Tokens__TokensExist($history);
	// 			$res = $this->_save_Tokens__TokensExist($history);
				
				// 		debug("tokens exist => ".$res);
				
				if ($res == true) {
						
// 					$msg_Flash = "Tokens exist for this history: id = "
// 							.$history['History']['id'];
				
// 					$this->Session->setFlash(__($msg_Flash));
						
					// 			debug("message => set");
					
					$count ++;
						
				} else {
					
					debug("tokens => don't exist for the history: "
							.$history['History']['id']);
					
					/**********************************
					 * words array
					**********************************/
					$words_ary = Utils::get_Words($history['History']['content']);
						
					// 			debug("\$words_ary length...");
					// 			debug(count($words_ary));
					
// 					/**********************************
// 					 * save tokens
// 					**********************************/
					$msg_Flash = Utils::save_Tokens__V2($words_ary, $history);
// 					$msg_Flash = $this->save_Tokens__V2($words_ary, $history);

				}
				
			}//foreach ($histories as $history)

			debug("histories ".count($histories)." / "."tokens found ". $count);
			
			return null;
			
		}//create_Tokens

		public static function
		_save_Tokens__TokensExist($history) {
		
// 			$this->loadModel('Token');

			$model = ClassRegistry::init('Token');
		
			$options = array(
					'conditions' =>
					array("Token.history_id" => $history['History']['id'])
			);
		
			$tokens = $model->find('all', $options);
// 			$tokens = $this->Token->find('all', $options);
		
			// 		debug("\$tokens ...");
			// 		debug(count($tokens));
		
			/**********************************
				* return
			**********************************/
			if ($tokens == null) {
					
				return false;
					
			} else if (count($tokens) > 0) {
					
				return true;
					
			} else {
					
				return true;
					
			}
		
		}//_save_Tokens__TokensExist

		/*******************************
		 @return
		1. Flash message string
		*******************************/
		public static function
		save_Tokens__V2
		($words_ary, $history) {
		
			/**********************************
				* vars
			**********************************/
			$msg_Flash = "";
		
			$tokens = array();
		
			/**********************************
				* processing
			**********************************/
			$count = 0;
			
			for ($i = 0; $i < count($words_ary); $i++) {
					
				/**********************************
					* get: words list
				**********************************/
				$words = $words_ary[$i];
					
				// 			$words= $this->get_Mecab_WordList($history['History']['content']);
		
				/**********************************
					* conv: words to tokens
				**********************************/
				$tokens = Utils::conv_MecabWords_to_Tokens__V2($words, $tokens);
// 				$tokens = $this->conv_MecabWords_to_Tokens__V2($words, $tokens);
				// 			$tokens = $this->conv_MecabWords_to_Tokens($words);
		
				/**********************************
					* save: tokens
				**********************************/
				$res = Utils::save_token_list($tokens, $history);
				// 			$res = $this->save_token_list($tokens, $history['History']['id']);
		
				if ($res == true) {
				
					$count ++;
				
				} else {
				
					
				}//if ($res == true)
				
			}//for ($i = 0; $i < count($words_ary); $i++)

			debug("words_ary => ".count($words_ary)." / "."words saved => ".$count);
			
			/*******************************
			 return
			*******************************/
			return $msg_Flash;
			// 		return $history['History']['id'];
		
		}//save_Tokens

		public static function
		conv_MecabWords_to_Tokens__V2
		($words, $token_list) {
		
			// 		$token_list = array();
		
			$counter = 0;
		
			foreach ($words as $w) {
		
				$token = new Token();
		
				/**********************************
					* form
				**********************************/
				$token->form = $w->surface;
				// 			$token->form = $w->surface;
		
				/**********************************
					* features
				**********************************/
				// 			$token->hin = $w->feature;
					
				$tmp = explode(',', (string)$w->feature);
				// 			$tmp = explode(',', $w->feature);
		
				// 			if ($counter < 20) {
		
				// 				debug((string)$w->surface);
				// 				debug((string)$w->feature);
				// // 				debug($w->surface);
		
				// // 				break;
				// 			}
					
					
					
				// 			//log
				// 			$msg = "count(\$tmp) => " + count($tmp);
				// 			Utils::write_Log($this->path_Log, $msg, __FILE__, __LINE__);
					
				// 			debug($tmp);
		
				// 			if ($counter < 20) {
					
				// 				debug($tmp);
				// 				// 				debug($w->surface);
					
				// 				// 				break;
				// 			}
		
				if ($tmp == null || count($tmp) == 7 ) {
					// 			if ($tmp == null || count($tmp) < 9) {
		
					$token->hin		= $tmp[0];
		
					$token->hin_1	= $tmp[1];
					$token->hin_2	= $tmp[2];
					$token->hin_3	= $tmp[3];
		
					$token->katsu_kei	= $tmp[4];
					$token->katsu_kata	= $tmp[5];
					$token->genkei	= $tmp[6];
					$token->yomi	= "*";
		
					$token->hatsu	= "*";
		
					// 				debug($w->feature);
		
					// 				continue;
		
				} else if (count($tmp) == 9) {
		
					$token->hin		= $tmp[0];
		
					$token->hin_1	= $tmp[1];
					$token->hin_2	= $tmp[2];
					$token->hin_3	= $tmp[3];
		
					$token->katsu_kei	= $tmp[4];
					$token->katsu_kata	= $tmp[5];
					$token->genkei	= $tmp[6];
					$token->yomi	= $tmp[7];
		
					$token->hatsu	= $tmp[8];
		
				} else {
		
					continue;
		
				}
					
				/**********************************
					* hin
				**********************************/
					
					
					
				array_push($token_list, $token);
		
				//test
				$counter += 1;
					
				// 			if ($counter < 10) {
		
				// 				debug($token);
		
				// // 				break;
				// 			}
					
			}//foreach ($words as $w)
		
			return $token_list;
		
		}//conv_MecabWords_to_Tokens

		public static function
		save_token_list
		($tokens, $history) {
			// 	($tokens, $history_id) {
		
			$history_id = $history['History']['id'];
		
			$category_id = $history['Category']['id'];
		
			$genre_id = $history['Category']['genre_id'];
		
			$counter = 0;
		
// 			$this->loadModel('Token');

			$model = ClassRegistry::init('Token');
		
			foreach ($tokens as $token) {
		
				$model->create();
// 				$this->Token->create();
		
				// 			$cat_id = $this->_save_Data_Keywords_from_CSV__Get_CatID_From_OrigID(
				// 								$kw_pair[3], $categories);
					
				// 			// valiate
				// 			if ($cat_id == false) {
		
				// 				continue;
		
				// 			}
					
				// build param
				$param = array('Token' =>
		
						array(
									
								'created_at'	=> Utils::get_CurrentTime(),
								'updated_at'	=> Utils::get_CurrentTime(),
									
								'form'			=> $token->form,
									
								'hin'			=> $token->hin,
								'hin_1'			=> $token->hin_1,
								'hin_2'			=> $token->hin_2,
								'hin_3'			=> $token->hin_3,
									
								'katsu_kei'		=> $token->katsu_kei,
								'katsu_kata'	=> $token->katsu_kata,
								'genkei'		=> $token->genkei,
								'yomi'			=> $token->yomi,
								'hatsu'			=> $token->hatsu,
									
								'history_id'	=> $history_id,
									
								'category_id'	=> $category_id,
								'genre_id'		=> $genre_id,
									
						)
		
				);
					
				if ($model->save($param)) {
// 				if ($this->Token->save($param)) {
		
					$counter += 1;
		
				}
		
				// 			//test
				// 			if ($counter > 20) {
		
				// 				break;
		
				// 			}
					
			}//foreach ($cat_pairs as $cat_pair)
		
			return $counter;
		
		}//save_token_list
		
		public static function
		decode_HTML($text, $set) {
			
			foreach ($set as $key => $val) {
				
				$p = "/$key/";
				
				$rep = $val;
				
				$text = preg_replace($p, $rep, $text);
				
			}
			
			return $text;
			
// 			$p = '/&lt/';
			
// 			$rep = '<';
			
// 			return preg_replace($p, $rep, $text);
			
		}

		///////////////////////////////
		//
		// if can't get h1 tags => return null
		//
		 ///////////////////////////////
		public static function
		get_Article_Line($url) {

// 			debug("get_Article_Line");
			
			$html = file_get_html($url);
			
// 			debug("html => obtained");
			
			$h1s = $html->find('h1');
			
			/****************************
			 * validate
			 *****************************/
			if (count($h1s) < 1) {
				
				return null;
				
			}
			
// 			debug(count($h1s));
// 			debug(count($h1->plaintext));
// 			debug(count($h1->text));

// 			debug($h1s[0]);	//=> out of mem
			
			$texts = array();
			
			foreach ($h1s as $h1) {
			
// 				debug($h1->plaintext);

				array_push($texts, $h1->plaintext);
				
// 				if ($h1->class == "ynDetailText") {
			
					// 				return $h1->plaintext;
// 					array_push($texts, $h1->plaintext);
			
// 				}
			
			}//foreach ($h1s as $h1)
			
			///////////////////////////////
			//
			// return
			//
			 ///////////////////////////////
			return $texts[0];
			
		}//get_Article_Line($url)

		public static function 
		get_rubi() {

			/*******************************
				biuld: keywords list
			*******************************/
			$model = ClassRegistry::init('Keyword');
			
			$option = array('order' => array('Keyword.id' => 'asc'));
			
			$keywords = $model->find('all', $option);

			/*******************************
				set rubi
			*******************************/
			$app_id = "dj0zaiZpPVdCMFl5WHA4NURGaSZzPWNvbnN1bWVyc2VjcmV0Jng9OTY-";
			
			foreach ($keywords as $index => $k) {
		
				$rubi = $k['Keyword']['rubi'];
				
				/*******************************
					dom
				*******************************/
				$sen = $k['Keyword']['word'];
				$url = "http://jlp.yahooapis.jp/FuriganaService/V1/furigana?"
						."appid=$app_id"
						."&grade=1"
						."&sentence=$sen";
				
				//REF C:\WORKS\WS\Eclipse_Luna\VM_Cake\app\Controller\VideosController.php
				$html = file_get_contents($url);
				$xmlDoc = new DOMDocument();
				$xmlDoc->loadXML($html);
					
				$words = $xmlDoc->documentElement->getElementsByTagName("Word");
				
				$w = $words->item(0);	//=> Word
	
				$furi = $w->getElementsByTagName("Furigana");	//=> NodeList
				$sur = $w->getElementsByTagName("Surface");	//=> NodeList
				
				$furi_elem = $furi->item(0);
				$sur_elem = $sur->item(0);
				
				if ($furi_elem != null) {
				
					$msg = $sur_elem->nodeValue."/"
							.$furi_elem->nodeValue
							."/".mb_convert_kana($sur_elem->nodeValue, "c");
					
					$keywords[$index]['Keyword']['rubi'] = $furi_elem->nodeValue;
				
				} else {
				
					$msg = mb_convert_kana($sur_elem->nodeValue, "c")."/"."null";
					
					$keywords[$index]['Keyword']['rubi'] = 
								mb_convert_kana($sur_elem->nodeValue, "c");
					
				}//if ($furi_elem != null)
				
			}//foreach ($keywords as $k)

			debug("rubi => obtained");
			
			/*******************************
				return
			*******************************/
			return $keywords;
			
		}

		public static function 
		update_Keyword($keyword) {
			
// 			if (!$id) {
// 				throw new NotFoundException(__('id => null'));
					
// 				return;
					
// 			}
		
			/****************************************
			 * Keyword
			****************************************/
// 			$keyword = $this->Keyword->findById($id);
		
// 			if (!$keyword) {
					
// 				throw new NotFoundException(__("Keyword not found: id => ".$id));
					
// 				return;
					
// 			}
		
// 			if (count($this->params->data) != 0) {
		
// 				$this->Keyword->id = $id;
		
// 				$this->params->data['Keyword']['updated_at'] =
				$keyword['Keyword']['updated_at'] =
					Utils::get_CurrentTime2(CONS::$timeLabelTypes["rails"]);

// 				debug($keyword);
				
				$model = ClassRegistry::init('Keyword');
				
				if ($model->save($keyword)) {
// 				if ($this->Keyword->save($keyword)) {
// 				if ($this->Keyword->save($this->request->data)) {

					return true;
		
				} else {//if ($this->Text->save($this->request->data))
					
					return false;
					
				}//if ($this->Text->save($this->request->data))
		
		}//public function edit($id = null)
		
		public static function conv_Word_2_Rubi($word) {
			
			/*******************************
			 set rubi
			*******************************/
			$app_id = "dj0zaiZpPVdCMFl5WHA4NURGaSZzPWNvbnN1bWVyc2VjcmV0Jng9OTY-";
			
			/*******************************
			 dom
			*******************************/
			$sen = $word;
			$url = "http://jlp.yahooapis.jp/FuriganaService/V1/furigana?"
					."appid=$app_id"
					."&grade=1"
						."&sentence=$sen";
			
// 			debug($url);
			
			//REF C:\WORKS\WS\Eclipse_Luna\VM_Cake\app\Controller\VideosController.php
			$html = file_get_contents($url);
			$xmlDoc = new DOMDocument();
			$xmlDoc->loadXML($html);
				
			$words = $xmlDoc->documentElement->getElementsByTagName("Word");

// 			debug($words->length);	//=> 2 ("不破医院")
// 			debug($words);	//=> DOMNodeList
			
			$w = $words->item(0);	//=> Word

// 			$w2 = $words->item(1);
			
// 			debug($w2);		//=> DOMElement
			
// 			$furi2 = $w2->getElementsByTagName("Furigana");
			
// 			debug($furi2);	//=> DOMNodeList
			
// 			debug($furi2->item(0));
// 			debug($furi2->item(0)->nodeValue);
			
// 			debug($w);
			
			$furi = $w->getElementsByTagName("Furigana");	//=> NodeList
			$sur = $w->getElementsByTagName("Surface");	//=> NodeList

// 			debug("furi => ".$furi->item(0)->length);	//=> Undefined property
// 			debug("furi => ".$furi->item(1));
// 			debug("furi => ".$furi->item->length);
// 			debug("furi => ".count($furi));
			
			$furi_elem = $furi->item(0);
			$sur_elem = $sur->item(0);
				
			if ($furi_elem != null) {
			
				return $furi_elem->nodeValue;
			
			} else {

				return mb_convert_kana($sur_elem->nodeValue, "c");
				
// 				$msg = mb_convert_kana($sur_elem->nodeValue, "c")."/"."null";
					
// 				$keywords[$index]['Keyword']['rubi'] =
// 				mb_convert_kana($sur_elem->nodeValue, "c");
					
			}//if ($furi_elem != null)
					
		}
	
		public static function conv_Word_2_Rubi_V2($word) {
			
			/*******************************
			 set rubi
			*******************************/
			$app_id = "dj0zaiZpPVdCMFl5WHA4NURGaSZzPWNvbnN1bWVyc2VjcmV0Jng9OTY-";
			
			/*******************************
			 dom
			*******************************/
			$sen = $word;
			$url = "http://jlp.yahooapis.jp/FuriganaService/V1/furigana?"
					."appid=$app_id"
					."&grade=1"
						."&sentence=$sen";
			
			//REF C:\WORKS\WS\Eclipse_Luna\VM_Cake\app\Controller\VideosController.php
			$html = file_get_contents($url);
			$xmlDoc = new DOMDocument();
			$xmlDoc->loadXML($html);
				
			$words = $xmlDoc->documentElement->getElementsByTagName("Word");

			$len_words = $words->length;

			$result_str = "";
			
			for ($i = 0; $i < $len_words; $i++) {
				
				$w = $words->item($i);

				$furi = $w->getElementsByTagName("Furigana");	//=> NodeList
				$sur = $w->getElementsByTagName("Surface");	//=> NodeList

				$furi_elem = $furi->item(0);
				$sur_elem = $sur->item(0);
				
				/*******************************
					build string
				*******************************/
				if ($furi_elem != null) {
						
					$result_str .= $furi_elem->nodeValue;
						
				} else {
				
					$result_str .= mb_convert_kana($sur_elem->nodeValue, "c");
				
					// 				$msg = mb_convert_kana($sur_elem->nodeValue, "c")."/"."null";
						
					// 				$keywords[$index]['Keyword']['rubi'] =
					// 				mb_convert_kana($sur_elem->nodeValue, "c");
						
				}//if ($furi_elem != null)
				
			}
			
			return $result_str;
			
// // 			debug($words->length);	//=> 2 ("不破医院")
// // 			debug($words);	//=> DOMNodeList
			
// 			$w = $words->item(0);	//=> Word

// // 			$w2 = $words->item(1);
			
// // 			debug($w2);		//=> DOMElement
			
// // 			$furi2 = $w2->getElementsByTagName("Furigana");
			
// // 			debug($furi2);	//=> DOMNodeList
			
// // 			debug($furi2->item(0));
// // 			debug($furi2->item(0)->nodeValue);
			
// // 			debug($w);
			
// 			$furi = $w->getElementsByTagName("Furigana");	//=> NodeList
// 			$sur = $w->getElementsByTagName("Surface");	//=> NodeList

// // 			debug("furi => ".$furi->item(0)->length);	//=> Undefined property
// // 			debug("furi => ".$furi->item(1));
// // 			debug("furi => ".$furi->item->length);
// // 			debug("furi => ".count($furi));
			
// 			$furi_elem = $furi->item(0);
// 			$sur_elem = $sur->item(0);
				
// 			if ($furi_elem != null) {
			
// 				return $furi_elem->nodeValue;
			
// 			} else {

// 				return mb_convert_kana($sur_elem->nodeValue, "c");
				
// // 				$msg = mb_convert_kana($sur_elem->nodeValue, "c")."/"."null";
					
// // 				$keywords[$index]['Keyword']['rubi'] =
// // 				mb_convert_kana($sur_elem->nodeValue, "c");
					
// 			}//if ($furi_elem != null)
					
		}
	
		public static function 
		save_SensHistory($sen) {
			/*******************************
				model
			*******************************/
			$model = ClassRegistry::init('SensHistory');

			$time = Utils::get_CurrentTime2(CONS::$timeLabelTypes["rails"]);
			
			$model->create();
			
			// build param
			$param = array('SensHistory' =>
			
					array(
								
							'created_at'	=> $time,
							'updated_at'	=> $time,
								
							'db_id'			=> $sen['Sen']['id'],
							'text'			=> $sen['Sen']['text'],
							
							'version'		=> Utils::conv_TimeLabel_Rails2Serial($sen['Sen']['updated_at']),
// 							'version'		=> Utils::get_CurrentTime2(CONS::$timeLabelTypes["serial"]),
// 							'version'		=> $sen['Sen']['version'],
							'memo'			=> $sen['Sen']['memo']
					)
			
			);
				
// 			$model->created_at = $time;
// // 			$model['SensHistory']['created_at'] = $time;
			
// 			$model->updated_at = $time;
			
// 			$model->db_id = $sen['Sen']['id'];
			
// 			$model->version = $sen['Sen']['version'];
			
// 			$model->memo = $sen['Sen']['memo'];
			
// 			debug($model);
			
// 			$model['SensHistory']['updated_at'] = $time;
			
// 			$model['SensHistory']['db_id'] = $sen['Sen']['id'];
			
// 			$model['SensHistory']['version'] = $sen['Sen']['version'];
			
// 			$model['SensHistory']['memo'] = $sen['Sen']['memo'];

			/*******************************
				save
			*******************************/
			if ($model->save($param)) {
// 			if ($model->save()) {
			
				return true;
			
			} else {
			
				return false;
				
			}//if ($model->save())
			
			
// 			$model->save();
			
		}//save_SensHistory

		/*******************************
			"yyyy-MM-dd H:i:s" => "yyyyMMdd_His"
		*******************************/
		public static function
		conv_TimeLabel_Rails2Serial($str) {

			$tokens_1 = explode(" ", $str);
			
			$dates = explode("-", $tokens_1[0]);
			
			$times = explode(":", $tokens_1[1]);
			
			return $dates[0].$dates[1].$dates[2]
					."_"
					.$times[0].$times[1].$times[2];
			
		}


		public static function
		get_Latest_File__By_FileName($fpath) {

			/*******************************
				dir list
			*******************************/
			//REF array_values http://stackoverflow.com/questions/7536961/reset-php-array-index Jeremy Banks♦
			//REF scan dir http://php.net/manual/en/function.scandir.php#107215
			$scanned_directory = array_values(array_diff(scandir($fpath), array('..', '.')));
// 			$scanned_directory = array_diff(scandir($fpath), array('..', '.'));
			
// 			debug($scanned_directory);

			/*******************************
				validate: any entry
			*******************************/
			if (count($scanned_directory) < 1) {
				
				//debug
				$msg = "dir list => no entry";
				
				Utils::write_Log(
								Utils::get_dPath_Log(),
								$msg,
								__FILE__, __LINE__);
						
				
				return null;
				
			}
			
			/*******************************
				get: the latest
			*******************************/
			/*******************************
				1 entry, only
			*******************************/
			if (count($scanned_directory) == 1) {
				
				return $scanned_directory[0];
				
			}
			
			/*******************************
				2 or more
			*******************************/
			$tmp_fname = $scanned_directory[0];
			
			$len = count($scanned_directory);
			
			for ($i = 1; $i < $len; $i++) {
				
				if (strcmp($tmp_fname, $scanned_directory[$i]) < 0) {
					
					$tmp_fname = $scanned_directory[$i];
					
				}
				
			}
			
// 			debug("latest => ".$tmp_fname);
			
			/*******************************
				return
			*******************************/
			return $tmp_fname;
			
		}//get_Latest_File__By_FileName($fpath)

		/*******************************
			@return
			array()	[0] => array of tweets<br>
			array()	[1] => number of tweets<br>
			
			null	=> 1. DB file doesn't exist<br>
					=> 2. new PDO ~~> returned null<br>
		*******************************/
		public static function
		paginate_Tweets($id_start, $items_PerPage, $opt) {
// 		paginate_Tweets($id_start, $items_PerPage) {
// 		paginate_Tweets($items_PerPage, $current_Page) {
			/*******************************
				pdo
			*******************************/
			/*******************************
			 PDO file
			*******************************/
			$fpath = "";
			
			if ($_SERVER['SERVER_NAME'] == CONS::$name_Server_Local) {
			
				$fpath .= "C:\\WORKS\\WS\\Eclipse_Luna\\Cake_TA2\\app\\Lib\\data";
			
			} else {
			
				$fpath .= "/home/users/2/chips.jp-benfranklin/web/android_app_data/TA2/db";
					
			}//if ($_SERVER['SERVER_NAME'] == CONS::$name_Server_Local)
			
			/*******************************
				validate: db file exists
			*******************************/
			$res = file_exists($fpath);

			if ($res == false) {
				
				return null;
				
			}
			
			/*******************************
			 get: the latest db file
			*******************************/
			$fname = Utils::get_Latest_File__By_FileName($fpath);
			
			$fpath .= DIRECTORY_SEPARATOR.$fname;
			
			/*******************************
			 pdo: setup
			*******************************/
			//REF http://www.if-not-true-then-false.com/2012/php-pdo-sqlite3-example/
			$file_db = new PDO("sqlite:$fpath");
			
			if ($file_db === null) {
					
				debug("pdo => null");
					
				return ;
					
			}
			
			// Set errormode to exceptions
			$file_db->setAttribute(PDO::ATTR_ERRMODE,
					PDO::ERRMODE_EXCEPTION);
			
			//ref http://stackoverflow.com/questions/669092/sqlite-getting-number-of-rows-in-a-database answered Mar 21 '09 at 10:37
			$tweets = $file_db->query('SELECT Count(*) FROM ta2');
// 			$tweets = $file_db->query('SELECT * FROM ta2 ORDER BY _id DESC');
			
// 			$cnt_Tweets = sqlite_num_rows($tweets);	//=> "Call to undefined function sqlite_num_rows()"

			//ref http://stackoverflow.com/questions/883365/row-count-with-pdo answered May 19 '09 at 15:16
			$cnt_Tweets = $tweets->fetchColumn();	//=> w
// 			$cnt_Tweets = count($tweets);
			
			debug("cnt_Tweets => ".$cnt_Tweets);
			
			/*******************************
				setup: options
			*******************************/
			if (isset($opt['filter'])
				&& isset($opt['filter']['text'])) {
			
				$filter_Text = $opt['filter']['text'];
			
			} else {
			
				$filter_Text = null;
				
			}//if (isset($opt['filter']))
			
			/*******************************
				build: query
			*******************************/
// 			$q = "SELECT * FROM ta2 ORDER BY _id DESC "
// 					."LIMIT $id_start"
// 					.", "
// 					.$items_PerPage;

			if ($filter_Text != null) {
				
				$q = "SELECT * FROM ta2"
						." WHERE text like \"%$filter_Text%\" "
						." ORDER BY _id DESC "
// 						." ORDER BY _id DESC ";
// 						."WHERE text like \"%$filter_Text%\" "
						."LIMIT $id_start"
						.", "
						.$items_PerPage;
				
				$q_cnt = 
						"SELECT Count(*) FROM ta2"
						." WHERE text like \"%$filter_Text%\" "
						." ORDER BY _id DESC ";
// // 						."WHERE text like \"%$filter_Text%\" "
// 						." ORDER BY _id DESC "
// 						."LIMIT $id_start"
// 						.", "
// 						.$items_PerPage;
				
// 				$q .= ", WHERE text like \"$filter_Text\"";
// 				$q .= " WHERE text like \"$filter_Text\"";
				
			} else {//$filter_Text != null

				$q = "SELECT * FROM ta2 ORDER BY _id DESC "
// 						."LIMIT $id_start";
						."LIMIT $id_start"
						.", "
				.$items_PerPage;
				
				$q_cnt = "SELECT Count(*) FROM ta2";
				
			}//$filter_Text != null
			
// 			debug("q => $q");
// 			debug("\$q_cnt => $q_cnt");
			
			/*******************************
				tweets
			*******************************/
			$result = $file_db->query($q);
// 			// 						"SELECT * FROM ta2 ORDER BY _id DESC LIMIT 100, $items_PerPage");
// 					"SELECT * FROM ta2 ORDER BY _id DESC "
// 					."LIMIT $id_start"
// 					.", "
// 					.$items_PerPage);

// 			debug("\$result->fetchColumn() => ".$result->fetchColumn());
			
			$res_cnt = $file_db->query($q_cnt);

			//debug
			if ($res_cnt === true) {
			
				debug("res_cnt => true");
			
			} else {
			
// 				debug("res_cnt => false");
				
			}//if ($res_cnt === true)
			
			
			
			
			
			//debug
			$tmp_i = $res_cnt->fetchColumn();
// 			$tmp_i = $result->fetchColumn();
			
// 			debug("res_cnt => $tmp_i");
// 			debug("result => $tmp_i");
			
			/*******************************
				columns
			*******************************/
			//ref http://stackoverflow.com/questions/5428262/php-pdo-get-the-columns-name-of-a-table answered Mar 27 '13 at 23:15
// 			$rs = $file_db->query('SELECT * FROM ta2 LIMIT 1');
// 			$rs = $file_db->query('SELECT * FROM ta2 LIMIT 10');
// 			$rs = $file_db->query('SELECT * FROM ta2 LIMIT 0');
			
// 			$col = $rs->getColumnMeta(0);	//=> w with '$rs = $file_db->query('SELECT * FROM ta2 LIMIT 1');'
// 			$col = $rs->getColumnMeta(0);	//=> "General error: 25 bind or column index out of range"
			
// 			debug($col);
				// 			array(
				// 					'native_type' => 'integer',
				// 					'sqlite:decl_type' => 'INTEGER',
				// 					'table' => 'ta2',
				// 					'flags' => array(),
				// 					'name' => '_id',
				// 					'len' => (int) -1,
				// 					'precision' => (int) 0,
				// 					'pdo_type' => (int) 2
				// 			)
			
// 			debug($rs->columnCount());
// 			$rs = $db->query('SELECT * FROM ta2 LIMIT 0');
// 			$rs = $db->query('SELECT * FROM ta2 LIMIT 1');
			$rs = $file_db->query('SELECT * FROM ta2 LIMIT 1');
			for ($i = 0; $i < $rs->columnCount(); $i++) {
				$col = $rs->getColumnMeta($i);
				$columns[] = $col['name'];
			}

// 			debug($columns);
			
// 			// number of pages
// 			$numOf_Pages = $cnt_Tweets / $items_PerPage;
			
// 			debug("pages => ".$numOf_Pages);
// 			debug("pages => ".ceil($numOf_Pages));
			
			
// 			$id_start
			
			/*******************************
				pdo => reset
			*******************************/
			$file_db = null;

			/*******************************
				return
			*******************************/
			return array($result, $tmp_i);
// 			return array($result, $cnt_Tweets);
// 			return $result;
			
		}//paginate_Tweets($items_PerPage, $current_Page)

		/*******************************
			@return
			(("id" => 1, "text" => "ABC"), ("id" => 2, "text" => "DEF"))<br>
		*******************************/
		public static function
		find_All_Tweets_from_SQLiteDB() {

			/*******************************
			 pdo
			*******************************/
			/*******************************
			 PDO file
			*******************************/
			$fpath = "";
				
			if ($_SERVER['SERVER_NAME'] == CONS::$name_Server_Local) {
					
				$fpath .= "C:\\WORKS\\WS\\Eclipse_Luna\\Cake_TA2\\app\\Lib\\data";
					
			} else {
					
				$fpath .= "/home/users/2/chips.jp-benfranklin/web/android_app_data/TA2/db";
					
			}//if ($_SERVER['SERVER_NAME'] == CONS::$name_Server_Local)
				
			debug($fpath);
			
			/*******************************
			 validate: db file exists
			*******************************/
			$res = file_exists($fpath);
			
			if ($res == false) {
			
				return null;
			
			}
				
			/*******************************
			 get: the latest db file
			*******************************/
			$fname = Utils::get_Latest_File__By_FileName($fpath);
				
			$fpath .= DIRECTORY_SEPARATOR.$fname;
				
			debug($fpath);
			
			/*******************************
			 pdo: setup
			*******************************/
			//REF http://www.if-not-true-then-false.com/2012/php-pdo-sqlite3-example/
			$file_db = new PDO("sqlite:$fpath");
				
			if ($file_db === null) {
					
				debug("pdo => null");
					
				return null;
// 				return ;
					
			}
				
			// Set errormode to exceptions
			$file_db->setAttribute(PDO::ATTR_ERRMODE,
					PDO::ERRMODE_EXCEPTION);
				
			//ref http://stackoverflow.com/questions/669092/sqlite-getting-number-of-rows-in-a-database answered Mar 21 '09 at 10:37
			$tweets = $file_db->query('SELECT * FROM ta2 ORDER BY _id DESC');
// 			$tweets = $file_db->query('SELECT Count(*) FROM ta2');

			debug(count($tweets));
			
			/*******************************
				close: db
			*******************************/
			$file_db = null;
			
			/*******************************
			 build: list
			*******************************/
			$twts = array();
			
			foreach ($tweets as $row) {
					
				$tweet = array();
					
// 				$tweet['_id'] = $row['_id'];
				$tweet['created_at'] = $row['created_at'];
				$tweet['modified_at'] = $row['modified_at'];
				
				$tweet['text'] = $row['text'];
					
				$tweet['uploaded_at'] = $row['uploaded_at'];
				$tweet['twted_at'] = $row['twted_at'];
				$tweet['twt_id'] = $row['twt_id'];
				
				$tweet['twt_created_at'] = $row['twt_created_at'];
				
				$tweet['orig_id'] = $row['_id'];
				
				array_push($twts, $tweet);
					
			}//foreach ($result as $row)
					
			
			/*******************************
				return
			*******************************/
			return $twts;
// 			return $tweets;
			
		}//find_All_Tweets()

		public static function
		get_FM_Tree($filename) {

			/*******************************
			 load xml file
			*******************************/
			$fname = $filename;
			
			$xml=simplexml_load_file($fname) or die("Error: Cannot create object");
			
			/*******************************
			 1st order
			*******************************/
			$o1s = $xml->children();
			
			$tmp_attrs = $o1s->attributes();
			
			/*******************************
			 get: attributes => o1s
			*******************************/
			$attrs_o1s = array();
			
			$tmp = array();
			
			foreach ($tmp_attrs as $k => $v) {
			
				$tmp[$k] = (string)$v;
					
			}//foreach ($tmp_attrs as $k => $v)
			
			// serial number
			$tmp['sn'] = "g1-0";
			
			array_push($attrs_o1s, $tmp);
			
			/*******************************
			 attributes: main
			*******************************/
			$attr_main = array();
			
			$attr_main["g1"] = $attrs_o1s;
			
			/*******************************
			 order: 2nd
			*******************************/
			$o2s = $o1s->children();
			
			// validate
			if ($o2s == null) {
				
				return $attr_main
				;
			}//$o2s === null
			
			$len_o2s = count($o2s);
			
			/*******************************
				validate: any entry
			*******************************/
			if ($len_o2s < 1) {
				
				return $attr_main;
				
			}//$len_o2s < 1
			
			/*******************************
				get: attributes => o2s
			*******************************/
			$attrs_o2s = array();
			
			$count = 0;
			
			foreach ($o2s as $child) {
			
				$tmp_attrs = $child->attributes();
					
				$tmp = array();
					
				foreach ($tmp_attrs as $k => $v) {
						
					$tmp[$k] = (string)$v;
					// 				$tmp[$k] = $v;	//=> ''
			
				}//foreach ($tmp_attrs as $a)
					
				$tmp['sn'] = "g1-0*g2-$count";
					// 			$tmp['sn'] = "g2-$count";
					
				$count ++;
					
				array_push($attrs_o2s, $tmp);
					
			}//foreach ($o2s as $child)
			
			// push to the main attributes
			$attr_main["g2"] = $attrs_o2s;

			/*******************************
				return
			*******************************/
			return $attr_main;
			
		}//get_FM_Tree
		
		public static function
		get_FM_Tree__V2($filename) {

			/*******************************
			 load xml file
			*******************************/
			$fname = $filename;
			
			$xml=simplexml_load_file($fname) or die("Error: Cannot create object");
			
			/*******************************
			 1st order
			*******************************/
			$o1s = $xml->children();
			
			$tmp_attrs = $o1s->attributes();
			
			/*******************************
			 get: attributes => o1s
			*******************************/
			$attrs_o1s = array();
			
			$tmp = array();
			
			foreach ($tmp_attrs as $k => $v) {
			
				$tmp[$k] = (string)$v;
					
			}//foreach ($tmp_attrs as $k => $v)
			
			// serial number
			$tmp['sn'] = "g1-0";
			
			array_push($attrs_o1s, $tmp);
			
			/*******************************
			 attributes: main
			*******************************/
			$attr_main = array();
			
			$attr_main["g1"] = $attrs_o1s;
			
			/**************************************************************
			 order: 2nd
			**************************************************************/
			$o2s = $o1s->children();
			
			// validate
			if ($o2s == null) {
				
				return $attr_main
				;
			}//$o2s === null
			
			$len_o2s = count($o2s);
			
			/*******************************
				validate: any entry
			*******************************/
			if ($len_o2s < 1) {
				
				return $attr_main;
				
			}//$len_o2s < 1
			
			/*******************************
				get: attributes => o2s
			*******************************/
			$attrs_o2s = array();
			
			$count = 0;
			
			foreach ($o2s as $child) {
			
				$tmp_attrs = $child->attributes();
					
				$tmp = array();
					
				foreach ($tmp_attrs as $k => $v) {
						
					$tmp[$k] = (string)$v;
					// 				$tmp[$k] = $v;	//=> ''
			
				}//foreach ($tmp_attrs as $a)
					
				$tmp['sn'] = "g1-0*g2-$count";
					// 			$tmp['sn'] = "g2-$count";
					
				$count ++;
					
				array_push($attrs_o2s, $tmp);
					
			}//foreach ($o2s as $child)
			
			// push to the main attributes
			$attr_main["g2"] = $attrs_o2s;

			/**************************************************************
				order: 3rd
			**************************************************************/
			$o2s_ary = array();
			
			foreach ($o2s as $child) {
			
				array_push($o2s_ary, $child);
				
			}//foreach ($o2s as $child)
			
// 			debug($o2s_ary);
			
			/*******************************
				basic info
			*******************************/
			for ($i = 0; $i < $len_o2s; $i++) {
			
				$tmp_node = $o2s_ary[$i];
				
				$tmp_children = $tmp_node->children();	// g3s
				
				debug("g2-$i");
				
				// num of children each g3 has
				debug("children => ".count($tmp_children));
				
				$count = 0;		// reset count
				
				foreach ($tmp_children as $child) {
				
					// attributes of a g3
					$tmp_attrs_child = $child->attributes();
					
					debug("g2-$i / g3-$count");
					
					$count ++;
					
				}//foreach ($tmp_children as $child)
				
				
				
// 				$tmp_attrs = $tmp_node->attributes();
				
// 				debug($tmp_attrs);
				
			}//for ($i = 0; $i < $len_o2s; $i++)
			
			
			/*******************************
				return
			*******************************/
			return $attr_main;
			
		}//get_FM_Tree__V2
		
	}//class Utils
	
	