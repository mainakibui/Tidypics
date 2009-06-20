<?php
	$photo_tags = $vars['photo_tags'];
	$links = $vars['links'];
	$photo_tags_json = $vars['photo_tags_json'];
	$file_guid = $vars['file_guid'];
	$viewer = $vars['viewer'];
	$owner = $vars['owner'];

	
	if ($photo_tags) { 
?>
<div id="tidypics_phototags_list">
	<h3><?php echo elgg_echo('tidypics:inthisphoto') ?></h3>
	<ul>
<?php
		foreach ($links as $id=>$link) {
			echo "<li><a class='phototag-links' id='taglink{$id}' href='{$link[1]}'>{$link[0]}</a></li>";
		}
?>
	</ul>
</div>
<?php 
	} 
?>
<div id='tagging_instructions'>
	<div id='tag_instruct_text'><?php echo elgg_echo('tidypics:taginstruct'); ?></div>
	<div id='tag_instruct_button_div'><button class='submit_button' id='tag_instruct_button' onclick='stopTagging()'><?php echo elgg_echo('tidypics:finish_tagging'); ?></button></div>
</div>
<div id="tag_menu">
<?php

	if($viewer) {
		$friends = get_entities_from_relationship('friend', $viewer->getGUID(), false, 'user', '', 0);

		$content = "<input type='hidden' name='image_guid' value='{$file_guid}' />";
		$content .= "<input type='hidden' name='coordinates' id='coordinates' value='' />";
		$content .= "<input type='hidden' name='user_id' id='user_id' value='' />";
		$content .= "<input type='hidden' name='word' id='word' value='' />";
	
		$content .= "<ul id='phototagging-menu'>";
		$content .= "<li><a href='javascript:void(0)' onClick='selectUser({$viewer->getGUID()},\"{$viewer->name}\")'> {$viewer->name} (" . elgg_echo('me') . ")</a></li>";
	
		if ($friends) {
			foreach($friends as $friend) {
				$content .= "<li><a href='javascript:void(0)' onClick='selectUser({$friend->getGUID()}, \"{$friend->name}\")'>{$friend->name}</a></li>";
			}
		}
	}
	$content .= "</ul>";

	$content .= "<input type='submit' value='" . elgg_echo('tidypics:actiontag') . "' class='submit_button' />";
	
	echo elgg_view('input/form', array('internalid' => 'quicksearch', 'internalname' => 'form-phototagging', 'class' => 'quicksearch', 'action' => "{$vars['url']}action/tidypics/addtag", 'body' => $content));

?>
</div>
<div id="delete_tag_menu">
<?php
	if ($photo_tags) {
		echo elgg_echo('tidypics:deltag_title') . '<br />';
		$content = "<input type='hidden' name='image_guid' value='{$file_guid}' />";
		foreach ($links as $id => $text) {
			$name = "tags[{$id}]";
			$content .= elgg_view("input/checkboxes", array('options' => array($text[0] => $text[0]), 'internalname' => $name, 'value' => '' ));
		}

		$content .= "<input type='submit' value='" . elgg_echo('tidypics:actiondelete') . "' class='submit_button' />";
		$content .= "<input type='button' value='" . elgg_echo('cancel') . "' class='cancel_button' onclick='hideDeleteMenu();' />"; 

		echo elgg_view('input/form', array('internalname' => 'form-deletetag', 'action' => "{$vars['url']}action/tidypics/deletetag", 'body' => $content));

	}
	echo '</div>'; // delete_tag_menu
	
	echo elgg_view('js/tagging', array('photo_tags_json' => $photo_tags_json,) );
?>