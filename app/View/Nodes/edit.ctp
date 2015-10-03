<!-- File: /app/View/Posts/add.ctp -->

<h1>Edit Keyword</h1>

<?php

	$opt_input_memo = array(
			'type'	=> 'input',
			// 						'type'	=> 'textarea',
			'cols'	=> 5,
			'rows'	=> 1,
			// 						'options'	=> $select_Genres,
	// 						//REF http://satussy.blogspot.jp/2011/07/cakephp-select.html "見つけた方法は"
	// 						'selected'	=> $genre_id,
				
			'label'		=> false,
// 			'name'		=> "memo",
			'div'		=> false,
			'onmouseover' => 'this.select()',
				
			// 						'class'		=> 'select_genre'
	);

	$opt_input_common = array(
			'type'	=> 'input',
			// 						'type'	=> 'textarea',
			'cols'	=> 5,
			'rows'	=> 1,
			// 						'options'	=> $select_Genres,
	// 						//REF http://satussy.blogspot.jp/2011/07/cakephp-select.html "見つけた方法は"
	// 						'selected'	=> $genre_id,
				
			'label'		=> false,
// 			'name'		=> "memo",
			'div'		=> false,
			'onmouseover' => 'this.select()',
				
			// 						'class'		=> 'select_genre'
	);

	echo $this->Form->create('Keyword', array('type' => 'post'));
	echo $this->Form->input('word', $opt_input_common);
	echo $this->Form->input('genre_id');
	echo $this->Form->input('type_id');
	
	echo $this->Form->input('memo', $opt_input_memo);
// 	echo $this->Form->input('memo');
	
	// REF http://stackoverflow.com/questions/19213165/cakephp-hidden-input-field answered Oct 6 '13 at 19:51
	echo $this->Form->input('updated_at', array(
								'type' => 'hidden',
								'value'	=> Utils::get_CurrentTime2(CONS::$timeLabelTypes["basic"])
	));
	
	echo $this->Form->input('id', array(
								'type' => 'hidden',
								'value'	=> $keyword['Keyword']['id']
	));


// echo $this->Form->select(
// 					'Lang id',
// 					$select_Langs,
// 					21,
// 					reset(array_keys($select_Langs)),
// 					array('empty' => false));

// echo $this->Form->input('Lang');
// echo $this->Form->input('lang_id');


echo $this->Form->end('Update keyword');
?>

<br>

<?php echo $this->Html->link(
    'Back to list',
    array('controller' => 'keywords', 'action' => 'index')
); ?>
