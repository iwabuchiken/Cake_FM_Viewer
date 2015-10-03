<th class="table_header">

	<?php echo $this->Html->link(
						'Category',
						array('controller' => 'keywords', 
								'action' => 'index',
								'?' => "sort=category_id"),
						array('class'	=> 'has_link'));
	?>
		
	<?php 

		$opt_input = array(
				'type' => 'select',
				'options' => $category_Id_Array,
				'label'	=> false
		);
		
		if (isset($chosen_category_id)) {
		
			//REF http://stackoverflow.com/questions/6259371/cakephp-this-form-input-how-to-set-a-select-default-option answered Jun 7 '11 at 0:38
			$opt_input['default'] = $chosen_category_id;
		
		} else {
			
			$opt_input['default'] = -1;
		}
		
		$opt_create = array(
				
				'div'	=> false,
				//REF http://wiltonsoftware.com/posts/view/customizing-your-form-labels-in-cakephp-1-2
				'label'	=> false,
				'url'	=> array(
								'controller'	=> 'Historys',
								'action'	=> 'index'),
				'type'	=> 'get'
				
			
		);
			
		$opt_End = array(
				
				'div'	=> false,
				'label'	=> false,
			
		);
			
		echo $this->Form->create(null, $opt_create);
		
		echo $this->Form->input('filter_Cat', $opt_input);
		
		echo $this->Form->end(
						'Filter');
		
	?>
		
</th>
