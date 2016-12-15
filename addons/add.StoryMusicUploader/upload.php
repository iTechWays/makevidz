<?php
function story_upload_music ($conn, $storyId, $file)
{
	global $user;
	$addon_data = json_decode(file_get_contents('addons/add.StoryMusicUploader/data.json'), true);
	
	if ($addon_data['verified_only'] == 1 && $user['verified'] == 0)
	{
		return "";
	}

	if (! isset ($file['music_upload']))
	{
		return "";
	}
	
	$music = $file['music_upload'];

	if ( is_numeric($storyId) )
	{
		if ( is_uploaded_file($music['tmp_name']) )
	    {
			$escapeObj = new \SocialKit\Escape();
			$music['name'] = $escapeObj->stringEscape($music['name']);
			$name = md5($music['name'] . time());
			$ext = strtolower(substr($music['name'], strrpos($music['name'], '.') + 1, strlen($music['name']) - strrpos($music['name'], '.')));
			
			if ($music['size'] > 1024 && $music['size'] < ($addon_data['max_upload_limit'] * 1024 * 1024))
			{
				if ( preg_match('/(mp3)/', $ext) )
				{
					$dir = 'music_uploads';

					if ( !file_exists($dir) )
					{
						mkdir($dir, 0777, true);
					}

					$url = $dir . '/' . $name . '.' . $ext;

					if ( move_uploaded_file($music['tmp_name'], $url) )
					{
						$query = $conn->query("INSERT INTO story_music_uploads (story_id,url) VALUES ($storyId,'$url')");

						if ( $query )
						{
							return $conn->insert_id;
						}
					}
				}
			}
		}
	}
}
\SocialKit\Addons::register('new_story_insert_datafile', 'story_upload_music');