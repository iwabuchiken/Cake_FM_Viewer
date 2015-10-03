<?php 

	$opt_input_name = array(
	
	// 			'onmouseover' => 'show_msg();',
			'onmouseover' => 'this.select();',
			// 			'onmouseover' => 'this.select(); show_msg();',
			'rows' => '1',
				
			'class'	=> 'add_name'
			// 			'cols'	=> '10'
	// 			'width'	=> '100px'
	// 			'columns'	=> '5'
				
	);
	
	echo $this->Form->create('Keyword');
	
	echo $this->Form->input('word', $opt_input_name);
	echo $this->Form->input('memo', $opt_input_name);
	echo $this->Form->input('genre_id');
	echo $this->Form->input('type_id');
// 	echo $this->Form->input('genre_id', $opt_input_name);
// 	echo $this->Form->input('type_id', $opt_input_name);
	
	echo $this->Form->end('Save Bulk');


?>