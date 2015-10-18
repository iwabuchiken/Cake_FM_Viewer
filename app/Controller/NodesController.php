<?php

class NodesController extends AppController {

	public $helpers = array('Html', 'Form');
// 	public $helpers = array('Html', 'Form', 'Main');
	
	public $components = array('Paginator');
	
	public function 
	index() {

		$nodes = $this->Node->find('all');
		
// 		debug("Nodes: count => ".count($nodes));

		/*******************************
			FM tree
		*******************************/
		$gens = $this->_index__Get_FM_Tree__V2();
		
		//debug
		debug("\$gens => ".count($gens));
		
		$node_array = $this->_index__Build_Template_Data($gens);

		// sort
		//REF http://cakephp.1045679.n5.nabble.com/Using-usort-in-Cake-td1327099.html Aug 11, 2009; 9:18pm
		$res_B = usort($node_array, array(&$this, "cmp_SN_Value"));
// 		$res_B = usort($positions, array(&$this, "cmp_SN_Value"));
		
		debug("sort => ".($res_B === true ? "done" : "NOT done"));
		
		//debug
		debug("\$node_array => ".count($node_array));

// 		debug($node_array);
		// 		array(
		// 				(int) 0 => array(
		// 						'text' => 'Research_2',
		// 						'sn' => 'g1-0'
		// 				), ...
		//		)

		/*******************************
			set: vars
		*******************************/
		$this->set("node_array", $node_array);
		
// 		$this->_index__Get_FM_Tree__V2();
// 		$this->_index__Get_FM_Tree();
		
	}//index()

	//REF http://stackoverflow.com/questions/4282413/php-sort-array-of-objects-by-object-fields answered Nov 26 '10 at 3:53
	public function
	cmp_SN_Value($node1, $node2) {
	
		//REF http://www.php.net/manual/en/function.floatval.php
		$val_1 = $node1['sn'];
		$val_2 = $node2['sn'];
// 		$val_1 = $node1['attributes']['sn'];
// 		$val_2 = $node2['attributes']['sn'];
// 		$val_2 = floatval($node2['Position']['point']);
	
		//REF http://stackoverflow.com/questions/481466/php-string-to-float answered Jan 26 '09 at 21:35
		// 		$point_1 = (float) $pos1['Position']['point'];
		// 		$point_2 = (float) $pos2['Position']['point'];
	
		return $val_1 > $val_2;
		// 		return $point_1 < $point_2;
	
	}//cmp_SN_Value($pos1, $pos2)
	
	/*******************************
		@return
		array(<br>
				(int) 0 => array(<br>
						'text' => 'Research_2',<br>
						'sn' => 'g1-0'<br>
				), ...
		)<br>
	*******************************/
	public function
	_index__Build_Template_Data($gens) {

// 		$gen_1 = $gens[0];
		
// 		debug("gen[0] => ".count($gen_1));
		
		$len = count($gens);
		
// 		for ($i = 0; $i < $len; $i++) {
		
// 			debug("gens[$i] => ".count($gens[$i]));
			
// 		}//for ($i = 0; $i < $len; $i++)
		
// 		/*******************************
// 			build tmpl: gen 1
// 		*******************************/
// 		$gens_1 = $gens[0];
		
// 		$len_Gens_1 = count($gens_1);
		
// 		debug("\$gens_1 => ".count($gens_1));
		
// 		$node_array = array();
		
// 		for ($i = 0; $i < $len_Gens_1; $i++) {
		
// 			$tmp = array();
			
// 			$tmp['text'] = $gens_1[$i]['attributes']['TEXT'];
// 			$tmp['sn'] = $gens_1[$i]['attributes']['sn'];
			
// 			array_push($node_array, $tmp);
			
// 		}//for ($i = 0; $i < $len_Gens_1; $i++)
		
// 		debug($node_array);
		
// 		/*******************************
// 			build tmpl: gen 2
// 		*******************************/
// 		$gens_2 = $gens[1];
		
// 		$len_Gens_2 = count($gens_2);
		
// 		debug("\$gens_2 => ".count($gens_2));
		
// 		$node_array = array();
		
// 		for ($i = 0; $i < $len_Gens_2; $i++) {
		
// 			$tmp = array();
			
// 			$tmp['text'] = $gens_2[$i]['attributes']['TEXT'];
// 			$tmp['sn'] = $gens_2[$i]['attributes']['sn'];
			
// 			array_push($node_array, $tmp);
			
// 		}//for ($i = 0; $i < $len_Gens_2; $i++)
		
// 		debug($node_array);
		
		/*******************************
			build tmpl: gen: all
		*******************************/
// 		$len = 3;
		
		$node_array = array();
		
		for ($i = 0; $i < $len; $i++) {
		
			$gen = $gens[$i];
			
			$len_Gens_2 = count($gen);
			
// 			debug("\$gen[$i] => ".count($gen));
			
// 			$node_array = array();
			
			for ($j = 0; $j < $len_Gens_2; $j++) {
			
				$tmp = array();
				
				$tmp['text'] = $gen[$j]['attributes']['TEXT'];
				$tmp['sn'] = $gen[$j]['attributes']['sn'];
				
				array_push($node_array, $tmp);
				
			}//for ($j = 0; $j < $len_Gens_2; $j++)
			;
			
		}//for ($i = 0; $i < $len; $i++)
		
		//debug
// 		debug("\$node_array => ".count($node_array));
		
// 		debug($node_array);
		
		/*******************************
			return
		*******************************/
		return $node_array;
		
// 		debug($gen_1[0]['attributes']);
// 		debug($gen_1['attributes']);
		
	}//_index__Build_Template_Data($gens)
	
	public function
	_index__Get_FM_Tree__V2() {

		/*******************************
			array: generations
		*******************************/
		$gens = array();
		
		/*******************************
		 load xml
		*******************************/
		$filename = "http://benfranklin.chips.jp/FM/Research_2/Research_2.mm";
		
		/*******************************
		 get: g1s
		*******************************/
		$g1s_set = array();

		array_push($g1s_set, Utils::get_FM_Tree_G1S__V2($filename));
		
// 		$this->_index__Disp_NodesInfo($g1s_set);
		
		// gens
		array_push($gens, $g1s_set);
		
		/*******************************
		 get: g2s
		*******************************/
		$g2s_set = array();
		
// 		debug("g1s: children => ".count($g1s_set[0]['children']));	//=> 3
// 		debug("g1s: children => ".count($g1s_set['children']));	//=> 3
		
		$g2s_set = Utils::fm_Get_G2S__V2($g1s_set);
// 		$g2s_set = Utils::fm_Get_G2S($g1s_set);
		
		$len_g2s = count($g2s_set);
		
// 		debug("len: g2s => ".$len_g2s);
		
		array_push($gens, $g2s_set);
		
		/*******************************
			get: g3s
		*******************************/
		$g3s_set = array();
		
		$node_Num = 0;
		
// 		$g3s_set = Utils::fm_Get_G2S__V2($g2s_set);

// 		array_push($gens, $g3s_set);
		
		/*******************************
			get: g3s: using a new function
		*******************************/
		$g3s_set = Utils::fm_Get_NewGeneration_Set($g2s_set);

// 		debug("\$g3s_set => ".count($g3s_set));	//=> 16
		
// 		debug($g3s_set[0]);
		
		array_push($gens, $g3s_set);
		
		/*******************************
			get: g4s: using a new function
		*******************************/
		$g4s_set = Utils::fm_Get_NewGeneration_Set($g3s_set);

// 		debug("\$g4s_set => ".count($g4s_set));
		
		array_push($gens, $g4s_set);
		
		/*******************************
			get: g5s: using a new function
		*******************************/
		$g5s_set = Utils::fm_Get_NewGeneration_Set($g4s_set);

// 		debug("\$g5s_set => ".count($g5s_set));
		
// 		debug("\$g5s_set[0]['attributes']");
// 		debug($g5s_set[0]['attributes']);
		
		array_push($gens, $g5s_set);
		
		/*******************************
			get: g6s: using a new function
		*******************************/
		$g6s_set = Utils::fm_Get_NewGeneration_Set($g5s_set);

		array_push($gens, $g6s_set);
		
// 		debug("\$g6s_set => ".count($g6s_set));
		
// 		debug("\$g6s_set[0]['attributes']");
// 		debug($g6s_set[0]['attributes']);
		
// 		//debug
// 		debug("\$gens => ".count($gens));
		
// 		debug(array_keys($gens));
		
		/*******************************
			return
		*******************************/
		return $gens;
		
	}//_index__Get_FM_Tree
	
	public function
	_index__Get_FM_Tree() {

		/*******************************
		 load xml
		*******************************/
		$filename = "http://benfranklin.chips.jp/FM/Research_2/Research_2.mm";
		
		/*******************************
		 get: g1s
		*******************************/
// 		$g1s_set = Utils::get_FM_Tree_G1S($filename);
		$g1s_set = array();

		array_push($g1s_set, Utils::get_FM_Tree_G1S($filename));
		
		// 		$fm_Tree = Utils::get_FM_Tree_G1S($filename);
		// 		$fm_Tree = Utils::get_FM_Tree__V2($filename);
		// 		$fm_Tree = Utils::get_FM_Tree($filename);

// 		debug(array_keys($g1s_set));
		
		$this->_index__Disp_NodesInfo($g1s_set);
		
// 		debug($g1s_set['attributes']);
// 				debug($g1s_set);
		// 		debug($fm_Tree);
		
		// 		debug($g1s_set['children']);
		// 		debug($g1s_set['children'][0]);
		// 		debug(count($g1s_set['children'][0]));	//=> 4
		
		/*******************************
		 get: g2s
		*******************************/
		$g2s_set = array();
		
		// 		$g1s_set = Utils::get_FM_Tree_G1S($filename);
		
		debug("g1s: children => ".count($g1s_set[0]['children']));	//=> 3
// 		debug("g1s: children => ".count($g1s_set['children']));	//=> 3
		
		$g2s_set = Utils::fm_Get_G2S($g1s_set);
		
		debug("g2s_set => obtained: ".count($g2s_set));

		$len_g2s = count($g2s_set);
		
		debug("len: g2s => ".$len_g2s);
		
		/*******************************
			disp: g2s
		*******************************/
// 		debug("displaying => g2s");
		
		$this->_index__Disp_NodesInfo($g2s_set);

// 		debug("\$g2s_set[0]");
// 		debug($g2s_set[0]);
		debug($g2s_set[0]['attributes']);
// 		debug($g2s_set[0]['children']);
		debug($g2s_set[0]['children'][0]);
// 		debug($g2s_set[0]['children'][0]->children());
// 		debug(get_class($g2s_set[0]['children'][0]));
		
		/*******************************
			get: g3s
		*******************************/
		$g3s_set = array();
		
		$node_Num = 0;
		
// 		array_push($g3s_set, 
// 				Utils::fm_GetTree_Get_Children__FromArray(
// // 				Utils::fm_GetTree_Get_Children(
// 						$g2s_set[$node_Num], 
// // 						$g2s_set[0], 
// 						$g1s_set[0]['attributes'], 
// 						$node_Num));
		
		
	}//_index__Get_FM_Tree
	
	public function
	_index__Disp_NodesInfo($nodes_set) {

		$len_set = count($nodes_set);
		
		for ($i = 0; $i < $len_set; $i++) {
		
			debug($nodes_set[$i]['attributes']);
// 			debug($nodes_set[$node_numb]['attributes']);
			
		}//for ($i = 0; $i < $len_set; $i++)
		
	}//_index__Disp_NodesInfo
	
	public function 
	_index__Options() {

		/*******************************
			filter
		*******************************/
		@$filter = $this->request->query['filter'];
		
		if ($filter == null) {
		
// 			// if no session value
// 			if (conditions) {
			
// 				line1
			
// 			} else {
			
// 				line2
				
// 			}//if (conditions)
			
			
			$this->set("filter_text", null);
			
			
			
// 			debug("filter => null");
		
		} else {
		
			if (isset($this->request->query['filter']['text'])) {
			
				$this->set("filter_text", $this->request->query['filter']['text']);
			
			} else {
			
				$this->set("filter_text", null);
				
			}//if (isset($this->request->query['filter']['text']))
			
// 			debug("filter => $filter");
// 			debug($filter);
			
		}//if ($filter == null)
		
		/*******************************
			return
		*******************************/
		return array("filter" => $filter);
		
	}//_index__Options()
	
	public function view($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid video'));
		}
	
		$keyword = $this->Keyword->findById($id);
		if (!$keyword) {
			throw new NotFoundException(__('Invalid video'));
		}
		
		$this->set('keyword', $keyword);
		
	}
	
	public function add() {
		if ($this->request->is('post')) {
			
			$this->Keyword->create();
			
			$this->request->data['Keyword']['created_at'] =
						Utils::get_CurrentTime2(CONS::$timeLabelTypes["rails"]);
			
			$this->request->data['Keyword']['updated_at'] =
						Utils::get_CurrentTime2(CONS::$timeLabelTypes["rails"]);
			
			// ruby
// 			$this->Keyword->rubi = 
			$this->request->data['Keyword']['rubi'] =
						Utils::conv_Word_2_Rubi($this->request->data['Keyword']['word']);
			
			// save
			if ($this->Keyword->save($this->request->data)) {
				
				$this->Session->setFlash(
						__("Keyword saved => ".$this->request->data['Keyword']['word']));
// 				$this->Session->setFlash(__('Your keyword has been saved.'));
				return $this->redirect(array('action' => 'index'));
				
			}
			$this->Session->setFlash(__('Unable to add your keyword.'));
			
		} else {
			
		}
		
	}//public function add()

	public function 
	add_from_sqlite() {
		
		/*******************************
			action?
		*******************************/
		@$action = $this->request->query['action'];
		
// 		debug($action);

		/*******************************
			validate
		*******************************/
		if ($action == null) {
			
			debug("add param => '?action=go'");
			
			return ;
			
		}//$action == null
		
		debug("action => ".$action);
		
		/*******************************
			build: tweet list
		*******************************/
		$tweets = Utils::find_All_Tweets_from_SQLiteDB();
		
		if ($tweets !== null) {
		
// 			debug(count($tweets));
			
// 			debug($tweets[0]);
		
		} else {
		
			debug("tweets => null");
			
			return ;
			
		}//if ($tweets !== null)
		
		/*******************************
			save data
		*******************************/
// 		debug($_SERVER);
// 		debug(gethostname());

		$hostname = @$_SERVER['HTTP_HOST'];
		
		$tweets = array_values($tweets);
		
// 		if ($hostname != 'localhost') {
			
			$count = count($tweets);
			
// 			$tmp = count($tweets);
			
// 			debug("tweets => ".$tmp);
			
			$count_Success = 0;
			
			$count_Failed = 0;
			
			for ($i = 0; $i < $count; $i++) {
				
	// 			debug($tweets[0]);
			
				$this->Tweet->create();
	// 			$this->TA2->create();
				
				$data = array();
				
	// 			_id				INTEGER PRIMARY KEY AUTOINCREMENT	NOT NULL,
	// 			created_at		VARCHAR(30),
	// 			modified_at		VARCHAR(30),
	// 			text			TEXT,
	// 			uploaded_at		VARCHAR(30),
	// 			twted_at		VARCHAR(30),
	// 			twt_id			INTEGER,
	// 			twt_created_at	VARCHAR(30),
				
	// 			orig_id			INT
					
				$data['Tweet']['created_at'] = $tweets[$i]['created_at'];
				$data['Tweet']['modified_at'] = $tweets[$i]['modified_at'];
				
				$data['Tweet']['text'] = $tweets[$i]['text'];
				$data['Tweet']['uploaded_at'] = $tweets[$i]['uploaded_at'];
				$data['Tweet']['twted_at'] = $tweets[$i]['twted_at'];
				$data['Tweet']['twt_id'] = $tweets[$i]['twt_id'];
				$data['Tweet']['twt_created_at'] = $tweets[$i]['twt_created_at'];
				
				$data['Tweet']['orig_id'] = $tweets[$i]['orig_id'];
				
	// 			$this->Tweet->text = $tweets[0]['text'];
				
	// 			debug($this->Tweet);
				
				if ($this->Tweet->save($data)) {
				
					$count_Success += 1;
				
				} else {
				
					$count_Failed += 1;
					
				}//if ($this->Tweet->save($data))
				
				
				
// 				$this->Tweet->save($data);
	// 			$this->Tweet->save();
	
			}//for ($i = 0; $i < $count; $i++)
			
			
			debug("saved => $count_Success / failed => $count_Failed");
			
// 			$this->TA2->
			
// 		}//$hostname != 'localhost'
		
		
	}//add_from_sqlite()
	
	public function delete($id) {
		/******************************
	
		validate
	
		******************************/
		if (!$id) {
			throw new NotFoundException(__('Invalid keyword id'));
			
			return;
			
		}
	
		$keyword = $this->Keyword->findById($id);
	
		if (!$keyword) {
			throw new NotFoundException(__("Can't find the keyword. id = %d", $id));
			
			return;
			
		}
	
		/******************************
	
		delete
	
		******************************/
		if ($this->Keyword->delete($id)) {
			// 		if ($this->Keyword->save($this->request->data)) {
				
			$this->Session->setFlash(__("Keyword deleted => %s", $keyword['Keyword']['word']));
				
			return $this->redirect(
					array(
							'controller' => 'keywords',
							'action' => 'index'
							
					));
				
		} else {
				
			$this->Session->setFlash(
					__("Keyword can't be deleted => %s", $keyword['Keyword']['title']));
				
			// 			$page_num = _get_Page_from_Id($id - 1);
				
			return $this->redirect(
					array(
							'controller' => 'keywords',
							'action' => 'view',
							$id
					));
				
		}
	
	}//public function delete($id)
	
	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('id => null'));
			
			return;
			
		}
	
		/****************************************
			* Keyword
		****************************************/
		$keyword = $this->Keyword->findById($id);
		
		if (!$keyword) {
			
			throw new NotFoundException(__("Keyword not found: id => ".$id));
			
			return;
			
		}
	
		if (count($this->params->data) != 0) {
				
			$this->Keyword->id = $id;
				
			$this->params->data['Keyword']['updated_at'] =
						Utils::get_CurrentTime2(CONS::$timeLabelTypes["rails"]);
				
			if ($this->Keyword->save($this->request->data)) {
	
				$this->Session->setFlash(__("Keyword has been updated: ".$id));
				
				return $this->redirect(
						array(
								'action' => 'view',
								$id));
	
			}//if ($this->Text->save($this->request->data))
				
			$this->Session->setFlash(__("Unable to update your keyword: ".$id));
				
		} else {
			
			// no param => set keyword variable
			$this->set("keyword", $keyword);
			
		}//if (count($this->params->data) != 0)
	
		if (!$this->request->data) {
			$this->request->data = $keyword;;
		}
	
	}//public function edit($id = null)
	
	public function
	show_mm() {
		
		$fname = "http://benfranklin.chips.jp/FM/Research_2/Research_2.mm";
// 		$fname = "../Lib/data/Research_2.mm";
// 		$fname = "Research_2.mm";
		
// 		$f = fopen($fname, "r");
		
		
// 		if ($f == null) {
			
// 			debug("file => null");
			
// 			return;
			
// 		}//$f == null
		
// 		fclose($f);
		
// 		debug("file => closed");
		
		/*******************************
			load xml file
		*******************************/
		$xml=simplexml_load_file($fname) or die("Error: Cannot create object");
		
		debug("class => ".get_class($xml));
		
		debug(count($xml));
		debug(count($xml->children()));
// 		debug(count($xml->children()->text));
		debug(count($xml->children()->children()));		//=> (int) 3

		$attr = $xml->children()->attributes();
		
		debug($attr);
		// 		object(SimpleXMLElement) {
		// 			@attributes => array(
		// 					'CREATED' => '1353658279906',
		// 					'ID' => 'ID_936318891',
		// 					'MODIFIED' => '1436688595942',
		// 					'TEXT' => 'Research_2'
		// 			)
		// 		}
		
		//ref asXML http://stackoverflow.com/questions/3690942/simplexml-to-string answered Sep 11 '10 at 13:11
		debug($attr->asXML());		//=> ' CREATED="1353658279906"'
		debug(strip_tags($attr->asXML()));		//=> ' CREATED="1353658279906"'
		
		debug((string)$attr);		//=> '1353658279906'
		
		
// 		debug($attr->TEXT);		//=> empty
// 		debug($attr->text);	//=> null
		
		debug("attributes => ".count($attr));
		
		//ref http://php.net/manual/en/simplexmlelement.attributes.php
		foreach ($attr as $key => $val) {
		
			debug("$key => $val");
			
		}//foreach ($attr as $key => $val)

		//ref http://stackoverflow.com/questions/3690942/simplexml-to-string answered Nov 23 '12 at 20:33
		foreach ($attr as $a) {
		
// 			debug($a);		//=> 'CREATED => 1353658279906'

			debug((string)$a);		//=> '1353658279906'
			
		}//foreach ($attr as $key => $val)
		
		//ref http://stackoverflow.com/questions/1652128/accessing-attribute-from-simplexml answered Sep 26 '12 at 10:57
		debug($attr->Token);	//=> null

		/*******************************
			key: POSITION?
		*******************************/
		if (isset($attr['POSITION'])) {
		
			debug("POSITION => set: ".$attr['POSITION']);
		
		} else {
		
			debug("POSITION => NOT set");
			
		}//if (isset($attr['POSITION']))
		
		
		
// 		debug($xml->children()->attributes()->text);	//=> null
// 		debug($xml->children()->attributes());
// 		debug($xml->children());
// 		debug($xml->node[0]);
		
// 		debug($xml);
		
	}//show_mm
	
	public function
	show_mm__V2() {
		
		/*******************************
			load xml file
		*******************************/
		$fname = "http://benfranklin.chips.jp/FM/Research_2/Research_2.mm";
		
		$xml=simplexml_load_file($fname) or die("Error: Cannot create object");

		/*******************************
			1st order
		*******************************/
		$o1s = $xml->children();

		$o1s_attrs = $o1s->attributes();
		
		debug($o1s_attrs);
		
		if (isset($o1s['TEXT'])) {
		
			debug("TEXT => ".$o1s['TEXT']);
		
		} else {
		
			debug("TEXT => NOT set");
			
		}//if (isset($o1s['text']))
		
		if (isset($attrs->text)) {
// 		if (isset($attrs['TEXT'])) {
		
			debug("TEXT => ".$attrs->text);
// 			debug("TEXT => ".$attrs['TEXT']);
		
		} else {
		
			debug("TEXT => NOT set");
			
		}//if (isset($attrs['text']))
		
		/*******************************
			get: attributes => o1s
		*******************************/
		$attrs_o1s = array();

		$tmp = array();
		
		foreach ($o1s_attrs as $k => $v) {
		
			$tmp[$k] = (string)$v;
// 			$attrs_o1s[$k] = (string)$v;
			
// 			$attrs_o1s[$k] = $v;	//=> object(SimpleXMLElement) {
		
// 	}
			
		}//foreach ($o1s_attrs as $k => $v)
		
		// serial number
		$tmp['sn'] = "g1-0";
		
		array_push($attrs_o1s, $tmp);
		
		debug($attrs_o1s);

		/*******************************
			attributes: main
		*******************************/
		$attr_main = array();
		
		$attr_main["g1"] = $attrs_o1s;
		
		/*******************************
		 order: 2nd
		*******************************/
		$o2s = $o1s->children();
		
		$len_o2s = count($o2s);
		
		debug("o2s => ".$len_o2s);
// 		debug("o2s => ".count($o2s));	//=> 3
// 		debug($o2s);

		debug("o2s: nodes => ".count($o2s->node));	//=> 3
		debug("o2s: nodes => ".count($o2s->node[0]));	//=> 4
		
// 		debug($o1s);	//=> w

		/*******************************
		 get: attributes => o2s
		*******************************/
		$attrs_o2s = array();
		
		$count = 0;
		
		foreach ($o2s as $child) {
		
			$tmp_attrs = $child->attributes();
			
			debug($tmp_attrs);
// 			debug($child->attributes());	//=> w

			$tmp = array();
			
			foreach ($tmp_attrs as $k => $v) {
			
				$tmp[$k] = (string)$v;
// 				$tmp[$k] = $v;	//=> ''
				
			}//foreach ($tmp_attrs as $a)
			
			$tmp['sn'] = "g1-0*g2-$count";
// 			$tmp['sn'] = "g2-$count";
			
			$count ++;
			
			array_push($attrs_o2s, $tmp);
			
// 			debug((string)$child);	//=> ''
// 			debug($child);
			
		}//foreach ($o2s as $child)
		
		debug($attrs_o2s);
		
		// push to the main attributes
		$attr_main["g2"] = $attrs_o2s;
		
		
		debug($attr_main);
		
// 		for ($i = 0; $i < $len_o2s; $i++) {
		
// // 			$child = $o2s->children[$i];
			
// // 			$tmp_attrs = $child->attributes();
			
// // 			debug("o2s: child $i");
			
// // 			debug($tmp_attrs);
			
// 		}//for ($i = 0; $i < $len_o2s; $i++)
		
		
// 		debug(count($xml));
// 		debug(count($xml->children()));
// // 		debug(count($xml->children()->text));
// 		debug(count($xml->children()->children()));		//=> (int) 3

// 		$attr = $xml->children()->attributes();
		
// 		debug($attr);
// 		// 		object(SimpleXMLElement) {
// 		// 			@attributes => array(
// 		// 					'CREATED' => '1353658279906',
// 		// 					'ID' => 'ID_936318891',
// 		// 					'MODIFIED' => '1436688595942',
// 		// 					'TEXT' => 'Research_2'
// 		// 			)
// 		// 		}
		
// 		//ref asXML http://stackoverflow.com/questions/3690942/simplexml-to-string answered Sep 11 '10 at 13:11
// 		debug($attr->asXML());		//=> ' CREATED="1353658279906"'
// 		debug(strip_tags($attr->asXML()));		//=> ' CREATED="1353658279906"'
		
// 		debug((string)$attr);		//=> '1353658279906'
		
		
// // 		debug($attr->TEXT);		//=> empty
// // 		debug($attr->text);	//=> null
		
// 		debug("attributes => ".count($attr));
		
// 		//ref http://php.net/manual/en/simplexmlelement.attributes.php
// 		foreach ($attr as $key => $val) {
		
// 			debug("$key => $val");
			
// 		}//foreach ($attr as $key => $val)

// 		//ref http://stackoverflow.com/questions/3690942/simplexml-to-string answered Nov 23 '12 at 20:33
// 		foreach ($attr as $a) {
		
// // 			debug($a);		//=> 'CREATED => 1353658279906'

// 			debug((string)$a);		//=> '1353658279906'
			
// 		}//foreach ($attr as $key => $val)
		
// 		//ref http://stackoverflow.com/questions/1652128/accessing-attribute-from-simplexml answered Sep 26 '12 at 10:57
// 		debug($attr->Token);	//=> null

// 		/*******************************
// 			key: POSITION?
// 		*******************************/
// 		if (isset($attr['POSITION'])) {
		
// 			debug("POSITION => set: ".$attr['POSITION']);
		
// 		} else {
		
// 			debug("POSITION => NOT set");
			
// 		}//if (isset($attr['POSITION']))
		
		
		
// 		debug($xml->children()->attributes()->text);	//=> null
// 		debug($xml->children()->attributes());
// 		debug($xml->children());
// 		debug($xml->node[0]);
		
// 		debug($xml);
		
	}//show_mm__V2

	/*******************************
		ftp FM files
	*******************************/
	public function
	ftp_Upload_FM_Files() {
		
		$ftp_server = "ftp.benfranklin.chips.jp";
		
		$conn_id = ftp_connect($ftp_server);
		
// 		ftp_close($conn_id);
		
		/*******************************
			connect
		*******************************/
		$ftp_user_name = "chips.jp-benfranklin";
		$ftp_user_pass = "9x9jh4";
		
		//ref http://php.net/manual/en/ftp.examples-basic.php
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		
		debug("\$login_result => ".($login_result === true ? "done" : "NOT done"));
// 		debug("\$login_result => ".get_class($login_result));
// 		debug("\$login_result => ".$login_result);
		
		/*******************************
			get: dir list
		*******************************/
		//ref http://stackoverflow.com/questions/6747065/accessing-an-ftp-directory-listing-with-php answered Jul 19 '11 at 12:33
// 		$r = ftp_rawlist($conn_id, "/FM/Research_2");
		$r = ftp_rawlist($conn_id, "/FM");
// 		$r = ftp_rawlist($ftp, "/FM");
// 		$r = ftp_rawlist($ftp, "/pub/time.series/la/");
		
// 		debug($r);
		// 		(int) 0 => 'drwxr-xr-x 192 chips.jp-benfranklin LolipopUser     4096 Oct 12 08:41 .',
		// 		(int) 1 => 'drwx---r-x  32 chips.jp-benfranklin LolipopUser     4096 Oct 13 16:54 ..',
		// 		(int) 2 => 'drwxr-xr-x   7 chips.jp-benfranklin LolipopUser     4096 Oct  3 16:29 .git',
		// 		(int) 3 => '-rw-r--r--   1 chips.jp-benfranklin LolipopUser      134 Oct  3 15:54 .gitignore',
		// 		(int) 4 => 'drwxr-xr-x   2 chips.jp-benfranklin LolipopUser     4096 Oct  3 15:54 AI',
		
		// other metod
		//ref http://php.net/manual/en/function.ftp-nlist.php
		$contents = ftp_nlist($conn_id, "/FM");
		
// 		debug($contents);
		// 		(int) 0 => '/FM/Cabvas',
		// 		(int) 1 => '/FM/Admin',
		// 		(int) 2 => '/FM/IFM9',
		// 		(int) 3 => '/FM/GT2',
		// 		(int) 4 => '/FM/TC2(Java)',

// 		$dpath = "$ftp_server/FM2";
		$dpath = "$ftp_server/FM";
		
		debug("dpath => $dpath");
		
		$ftp_path = "ftp://$ftp_user_name:$ftp_user_pass@$dpath";	//=> w
// 		$ftp_path = "ftp://$ftp_user_name:$ftp_user_pass@$ftp_server/FM";
		
		debug("\$ftp_path => $ftp_path");
		
		//ref http://codereview.stackexchange.com/questions/24578/is-dir-function-for-ftp-ftps-connections asked Mar 31 '13 at 22:42
		//ref http://stackoverflow.com/questions/1554346/how-to-check-using-php-ftp-functionality-if-folder-exists-on-server-or-not answered Oct 12 '09 at 12:42
		$res = is_dir($ftp_path);
// 		$res = is_dir($dpath);
// 		$res = is_dir("ftp://$ftp_user_name:$ftp_user_pass@$dpath");
// 		$res = is_dir("ftp://$ftp_user_name:$ftp_user_pass@$ftp_server/FM2");	//=> 'res => is NOT dir'
// 		$res = is_dir("ftp://$ftp_user_name:$ftp_user_pass@$ftp_server/FM");	//=> 'res => is dir'
// 		$res = is_dir('ftp://user:password@example.com/some/dir/path');

		debug("res => ".($res === true ? "is dir" : "is NOT dir"));
// 		debug("res => ".($res === true ? "is dir" : "is NOT dir")."($dpath)");
		
		/*******************************
			locale
		*******************************/
		//ref http://stackoverflow.com/questions/2505681/timezone-conversion-in-php answered Mar 24 '10 at 6:11
		date_default_timezone_set('Asia/Tokyo');	//=> w
// 		date_default_timezone_set('UTC');

// 		//ref http://php.net/manual/en/function.setlocale.php
		//ref http://stackoverflow.com/questions/3191664/list-of-all-locales-and-their-short-codes answered Feb 25 '13 at 4:21
// 		setlocale(LC_ALL, 'ja-JP');		//=> n/w
// 		setlocale(LC_ALL, 'nl_NL');
		
		/*******************************
			get: last modified
		*******************************/
		$fpath = "/cake_apps/Cake_FM_Viewer/app/Controller/NodesController.php";
// 		$fpath = "/FM/Research_2//Research_2.mm";
		
		//ref http://www.w3schools.com/php/func_ftp_mdtm.asp
		$lastchanged = ftp_mdtm($conn_id, $fpath);
		
		if ($lastchanged != -1)
		{
			//ref http://jp2.php.net/manual/en/function.date.php 
			debug("$fpath was last modified on : \n" 
					. date("Y-m-d H:i:s.",$lastchanged));
// 			debug("$fpath was last modified on : \n" . date("m d Y H:i:s.",$lastchanged));
// 			debug("$fpath was last modified on : \n" . date("F d Y H:i:s.",$lastchanged));
// 			debug("$fpath was last modified on : " . date("F d Y H:i:s.",$lastchanged));
// 			echo "$file was last modified on : " . date("F d Y H:i:s.",$lastchanged);
		}
		else
		{
		echo "Could not get last modified";
		}
		
		/*******************************
			close
		*******************************/
		ftp_close($conn_id);
		
		/*******************************
			message
		*******************************/
		debug("ftp => closed");
		
	}//ftp_Upload_FM_Files
	
}//class ArticlesController extends AppController
