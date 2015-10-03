<?php

class NodesController extends AppController {

	public $helpers = array('Html', 'Form');
// 	public $helpers = array('Html', 'Form', 'Main');
	
	public $components = array('Paginator');
	
	public function 
	index() {

		
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
		
		$fname = "../Lib/data/Research_2.mm";
// 		$fname = "Research_2.mm";
		
		$f = fopen($fname, "r");
		
		
		if ($f == null) {
			
			debug("file => null");
			
			return;
			
		}//$f == null
		
		fclose($f);
		
		debug("file => closed");
		
		/*******************************
			load xml file
		*******************************/
		$xml=simplexml_load_file($fname) or die("Error: Cannot create object");
		
		debug($xml);
		
	}//show_mm
	
}//class ArticlesController extends AppController
