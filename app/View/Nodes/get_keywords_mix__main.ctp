<a class="button" onclick="get_kw_mix()" id="btn_keyword_mix">Click Me!</a>

<br>
<br>

<div id="message_area">Message</div>

<br>

<div id="area_composition">

	<?php 
	
		$opt = array(
		
		// 			'onmouseover' => 'show_msg();',
				'onmouseover' => 'this.select();',
				// 			'onmouseover' => 'this.select(); show_msg();',
				'rows' => '1',
					
				'div'	=> null,

// 				'width'	=> '50%',
				
				'class'	=> 'add_name'
				// 			'cols'	=> '10'
		// 			'width'	=> '100px'
		// 			'columns'	=> '5'
					
					
		);
		
		echo $this->Form->input('Compose', $opt);
		
		echo $this->Form->input('Memo', $opt);
		
	?>

	<a class="button" onclick="submit_composition();" id="submit_composition">
			Submit
	</a>
	
</div>
