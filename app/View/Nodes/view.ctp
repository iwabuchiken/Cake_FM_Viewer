<h1><?php echo h($keyword['Keyword']['word']); ?></h1>

<table class="table_show">
  <tr>
    <td class="td_label_narrow">ID</td>
    <td class="td_value_mideum"><?php echo $keyword['Keyword']['id']; ?></td>
  </tr>
  <tr>
    <td class="td_label_narrow">name</td>
    <td class="td_value_mideum"><?php echo $keyword['Keyword']['word']; ?></td>
  </tr>
  
  <tr>
    <td class="td_label_narrow">Genre</td>
    
    <td class="td_value_mideum">

    	<?php echo $keyword['Keyword']['genre_id']?>
    
    </td>
    
  </tr>
  
  <tr>
    <td class="td_label_narrow">Type</td>
    
    <td class="td_value_mideum">

    	<?php echo $keyword['Keyword']['type_id']?>
    
    </td>
    
  </tr>
  
  <tr>
    <td class="td_label_narrow">Memo</td>
    
    <td class="td_value_mideum">

    	<?php echo $keyword['Keyword']['memo']?>
    
    </td>
    
  </tr>
  
</table>

<p>
	<?php echo $this->Html->link(
					'Delete Keyword',
					array(
							'controller' => 'keywords', 
							'action' => 'delete', 
							$keyword['Keyword']['id']
					),
					array(
							// 							'style'	=> 'color: blue'
// 							'class'		=> 'link_word_alert'
					),
						
					//REF http://stackoverflow.com/questions/22519966/cakephp-delete-confirmation answered Mar 19 at 23:18
					__("Delete? => %s", $keyword['Keyword']['word'])
	
				);
	?>

</p>
