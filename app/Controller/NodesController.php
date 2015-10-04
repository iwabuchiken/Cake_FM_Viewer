<?php

class NodesController extends AppController {

	public $helpers = array('Html', 'Form');
// 	public $helpers = array('Html', 'Form', 'Main');
	
	public $components = array('Paginator');
	
	public function 
	index() {

		$nodes = $this->Node->find('all');
		
		debug("Nodes: count => ".count($nodes));

		/*******************************
			load xml
		*******************************/
		$filename = "http://benfranklin.chips.jp/FM/Research_2/Research_2.mm";
		
		/*******************************
			get: g1s
		*******************************/
		$g1s_set = Utils::get_FM_Tree_G1S($filename);
// 		$fm_Tree = Utils::get_FM_Tree_G1S($filename);
// 		$fm_Tree = Utils::get_FM_Tree__V2($filename);
// 		$fm_Tree = Utils::get_FM_Tree($filename);
		
		debug($g1s_set['attributes']);
// 		debug($g1s_set);
// 		debug($fm_Tree);

// 		debug($g1s_set['children']);
// 		debug($g1s_set['children'][0]);
// 		debug(count($g1s_set['children'][0]));	//=> 4
		
		/*******************************
		 get: g2s
		*******************************/
		$g2s_set = array();
		
		$g1s_set = Utils::get_FM_Tree_G1S($filename);
		
		debug("g1s: children => ".count($g1s_set['children']));	//=> 3
		
		$node_numb = 0;
		
		//debug
// 		$g1s_set['attributes']['sn'] = "g1-0*g2-0";
		
		array_push(
				$g2s_set, 
				Utils::get_FM_Tree_GetChildren(
							$g1s_set['children'][$node_numb], 
// 							$g1s_set['children'][0], 
							$g1s_set['attributes'],
							$node_numb
		));
		
		debug($g2s_set[$node_numb]['attributes']);

// 		debug($g2s_set[0]['attributes']);
// 		debug($g2s_set['attributes']);
// 		debug($g2s_set);

		/*******************************
			children: 1
		*******************************/
		$node_numb = 1;
		
		//debug
		// 		$g1s_set['attributes']['sn'] = "g1-0*g2-0";
		
		array_push(
				$g2s_set,
				Utils::get_FM_Tree_GetChildren(
						$g1s_set['children'][$node_numb],
						// 							$g1s_set['children'][0],
						$g1s_set['attributes'],
						$node_numb
		));
		
		debug($g2s_set[$node_numb]['attributes']);
// 		$this->show_mm__V2();
// 		$this->show_mm();
		
	}//index()

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
	
}//class ArticlesController extends AppController
