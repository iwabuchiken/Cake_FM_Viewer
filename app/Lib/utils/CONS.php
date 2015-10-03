<?php

class CONS {

	/*******************************
		server
	*******************************/
	public static $name_Server_Remote = "benfranklin.chips.jp";
	
	public static $name_Server_Local = "localhost";
	
	/**********************************
	* commons
	**********************************/
	public static $proj_Name = "Cake_NR5";
	
	public static $numOf_Modulus = 40;
	
	/******************************
	
		Paths and names
	
	******************************/
	public static $dname_Utils		= "utils";
	public static $dname_Log			= "log";
	public static $dname_Doc			= "docs";
	// 		const dbName_Local = "development.sqlite3";
	// 		private final $dbName_Local = "development.sqlite3";
	public static $dbName_Local = "development.sqlite3";

	public static $local_HostName = "localhost";

	public static $timeLabelTypes = array(

			"rails" => "railsType",	// "yyyy-MM-dd H:i:s"
			"basic" => "basicType",	// "yyyy/MM/dd H:i:s"
			"serial" => "serialType"	// "yyyyMMdd_His"
	);

	/****************************************
		* csv files
	****************************************/
	public static $logFile_maxLineNum = 3000;

	/****************************************
		* Session keys
	****************************************/

	/**********************************
	* DB
	**********************************/
	public static $genre_code_dflt = "soci";
	
	/**********************************
	* Articles
	**********************************/
	public static $category_Others_Label = "Others";
	
	public static $category_Others_Num = -5;
	
	/**********************************
	* admin
	**********************************/
	public static $admin_Open_Mode = "open_mode";
	
	public static $admin_Colorize = "colorize";
	
	public static $admin_FilterVendors = "filter_vendor";
	
	public static $admin_NumOfPages = "admin_NumOfPages";
	
	public static $admin_ScoreTopX = "admin_ScoreTopX";
	
	public static $admin_Val_1 = "val1";
	
	public static $admin_Val_2 = "val2";
	
	/**********************************
	* Tokens
	**********************************/
	public static $str_Filter_Hins = "filter_hins";
	public static $str_Filter_Hins_all = "filter_hins_all";
	
	public static $str_Filter_Hins_1 = "filter_hins_1";
	public static $str_Filter_Hins_1_all = "filter_hins_1_all";
	
	public static $str_Filter_Hins_2 = "filter_hins_2";
	public static $str_Filter_Hins_2_all = "filter_hins_2_all";
	
	public static $str_Filter_Hins_3 = "filter_hins_3";
	public static $str_Filter_Hins_3_all = "filter_hins_3_all";
	
	public static $str_Filter_Hist_Id = "filter_hist_id";
	public static $str_Filter_Hist_Id_all = "filter_hist_id_all";
	
	public static $str_Filter_Cat_Id = "filter_cat_id";
	public static $str_Filter_Cat_Id_all = "filter_cat_id_all";
	public static $str_Filter_Cat_Id_all_Val = "-1";

	public static $str_TopX_Default = 50;
	
	/*******************************
		NVP
	*******************************/
	public static $hin_Names = array(
		
			"接続詞",
			"助動詞",
			"名詞",		// 0-2
			
			"形容詞",
			"接頭詞",
// 			"接頭詞",
			"連体詞",		// 3-5
			
			"感動詞",
			"動詞",
			"助詞",		// 6-8
			
			"副詞",
			"記号",		// 9-10
			
	);
	
	public static $map_HinSymbols = array(
		
			"接続詞"	=> "C",		// Connective
			"助動詞"	=> "A",		// Auxiliary
			"名詞"	=> "N",
			
			"形容詞"	=> "J",		// adJective
			"接頭詞"	=> "F",		// preFix
// 			"接頭詞"	=> "FP",		// PreFix
			"連体詞"	=> "T",		// renTai-shi
			
			"感動詞"	=> "E",		// Exclamation
			"動詞"	=> "V",
			"助詞"	=> "P",		// Particle
			
			"副詞"	=> "D",		// aDverb
			"記号"	=> "S",		// Symbol
					
			
	);
	
	public static $hin1_Names = array(
		
			"格助詞",		"並立助詞",	"終助詞",		// 0-2
			
			"係助詞",		"副助詞",		"接続助詞",	// 3-5
			
			"連体化",		"副詞化",		"その他"		// 6-8
			
	);
	
	public static $map_Hin1_Symbols = array(
		
			//REF http://en.wikipedia.org/wiki/Japanese_particles
			"格助詞"		=> "C",		// Case markers
			"連体化"		=> "A",		// Attributive
			"係助詞"		=> "B",		// Binding
			"接続助詞"	=> "J",		// conJunctive
			
			"その他"		=> "X",
// 			"並立助詞"	=> "P",		// Parallel
// 			"終助詞"		=> "E",		// Ending
			
			
	);
	
	
	public static $hin1_Noun_Names = array(
		
			"一般",		"代名詞",	"固有名詞",		// 0-2
			
			"サ変接続",		"数",		"非自立",	// 3-5
			
			"副詞可能",		"ナイ形容詞語幹",		"形容動詞語幹",	// 6-8
			
			"接尾",								// 9
			
			"その他",								// 
	);
	
	public static $map_Hin1_Noun_Symbols = array(
		
			//REF http://en.wikipedia.org/wiki/Japanese_particles
			"一般"		=> "G",		// General			// 0
			"代名詞"		=> "P",		// Pronoun			// 1
			"固有名詞"	=> "R",		// pRoper noun		// 2
			
			"サ変接続"	=> "S",		// Sa-hen
			"数"			=> "N",		// Number
			"非自立"		=> "D",		// Dependent		// 3-5
			
			"副詞可能" 	=> "V",		// adVerb possible
			"ナイ形容詞語幹"	=> "J",	// NAI-adJective
			"形容動詞語幹"	=> "A",		// Adverbe			// 6-8
			
			"接尾"		=> "F",		// prefix			// 9
			
			"その他"		=> "X",							// 6
			
	);

	/*******************************
		history
	*******************************/
	public static $str_Filter_History = "filter_history";
	public static $str_Filter_History_all = "*";
	
	public static $str_Filter_RadioButtons_Name_History = "RBs_AND_OR_History";
	public static $str_Filter_RadioButtons_History_AND = "AND";
	public static $str_Filter_RadioButtons_History_OR = "OR";
	
	public static $str_Filter_RadioButtons_Name_TableName = "RBs_AND_OR_TableName";
	public static $str_Filter_RadioButtons_TableName_AND = "AND_TableName";
	public static $str_Filter_RadioButtons_TableName_OR = "OR_TableName";
	
	public static $str_Filter_TableName = "filter_table_name";
	public static $str_Filter_TableName_all = "*";
	
	public static $his_Updates_Delimiter = ",";
	
	
}//class CONS
