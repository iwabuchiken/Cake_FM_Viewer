<tr>

		<th class="table_header">
		
				ID
				
		</th>
		
		<th class="table_header">
		
			Text
			
			<?php 
			
				$option_input = array(
						'style' => 'width: 100px;height: 50px;',
						'label' => '',
						'name' => 'filter[text]',
						'onmouseover'	=> 'this.select()',
						
// 						'name' => 'filter[w1]'
				
				);
			
				// default value
				if (isset($filter_text)) {
					
					$option_input['value'] = $filter_text;
					
				}//isset($filter_text)
				
				echo $this->Form->create('Tweet',
						array(
								'type' => 'get',
								'action' => 'index'
								// 									'?' => $query_String
						)
				);
				
				echo $this->Form->input('text',
						$option_input);
				// 								array(
				// 									'style' => 'width: 100px;height: 50px;',
				// 									'label' => '',
				// 									'name' => 'filter[w1]'
				// // 									'name' => 'filter_w1'
				// 							));
				
				// 				echo $this->Form->input('w1',
				// 								array(
				// 									'style' => 'width: 100px;height: 50px;',
				// 									'label' => 'ww',
				// 									'name' => 'filter[w1]'
				// 							));
				
				echo $this->Form->end('Search'
				// 						,
				// 						array(
						// 							'label' => 'go',
						// 							'style' => 'color: red;'
						// 						)
				
				);
					
			
			
			?>
			
		</th>
		
		<th class="table_header">Created at</th>
		<th class="table_header">Modified at</th>
		
</tr>
