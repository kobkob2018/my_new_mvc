<?= $this->data['nesting_message']; ?>
<?php $this->call_module('system_messages','show'); ?>
<table>

    
    <?php foreach($this->data['test_list'] as $tag_id=>$tag_name): if($tag_id!='0'): ?>
			<tr>
                <td><?php echo $tag_id; ?></td>
				<td><?php echo $tag_name; ?></td>
				<td>
                    <form action="" method="POST">
                        <input type="hidden" name="delete_tag" value="1" />
						<input type="hidden" name="tag_data[tag_id]" value="<?php echo $tag_id; ?>" />
						<input type="submit" value="מחק" />
					</form>				
				</td>
			</tr>
            <?php endif; endforeach; ?>



        </table>


        <h2>nesting data(nesting_test_list)</h2>

        
        <?php foreach($this->data['nesting_test_list'] as $tag_id=>$tag_name): if($tag_id!='0'): ?>
			<tr>
                <td><?php echo $tag_id; ?></td>
				<td><?php echo $tag_name; ?></td>
				<td>
                    <form action="" method="POST">
                        <input type="hidden" name="delete_tag" value="1" />
						<input type="hidden" name="tag_data[tag_id]" value="<?php echo $tag_id; ?>" />
						<input type="submit" value="מחק" />
					</form>				
				</td>
			</tr>
            <?php endif; endforeach; ?>



        </table>