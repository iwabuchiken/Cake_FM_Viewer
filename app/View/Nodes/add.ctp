<h1>Add Keyword</h1>
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

	$opt_input_genre = array(
				
			'onmouseover' => 'this.select()',
			
			'id'		=> "genre",
			
	);

	$opt_input_category = array(
				
// 			'onmouseover' => 'this.select()',
// 			'rows' => '3',
			
			'id'		=> "category"
			
			
	);

	echo $this->Form->create('Keyword');
	
	echo $this->Form->input('word', $opt_input_name);
	echo $this->Form->input('memo', $opt_input_name);
	echo $this->Form->input('genre_id', $opt_input_genre);
	echo $this->Form->input('type_id', $opt_input_genre);
	
	echo $this->Form->end('Save Keyword');
	
?>

<hr>

<?php echo $this->Html->link("Back to list",
							array(
								'controller' => 'keywords', 
								'action' => 'index')
							); 
?>


<!-- <div id="add_kw_ajax">abc</div> -->