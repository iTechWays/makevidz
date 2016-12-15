<?php
function story_youtube_detector ($story)
{
	$rgx1 = '/\<a href\=\"(|https:\/\/|http:\/\/)(|www\.)youtube.com\/watch\?v\=([a-zA-Z0-9_-]+)(|\&feature\=youtu\.be)\"(.*?)\<\/a\>/i';
	if (preg_match_all($rgx1, $story['text'], $matches))
	{
		foreach ($matches[0] as $k => $match)
		{
			$yid = $matches[3][$k];
			$iframe = '<iframe width="100%" height="315" src="https://www.youtube.com/embed/' . $yid . '" frameborder="0" allowfullscreen></iframe>';
			$story['text'] = str_replace($match, $iframe, $story['text']);
		}
	}

	$rgx2 = '/\<a href\=\"(|https:\/\/|http:\/\/)(|www\.)youtu.be\/([a-zA-Z0-9_-]+)\"(.*?)\<\/a\>/i';
	if (preg_match_all($rgx2, $story['text'], $matches))
	{
		foreach ($matches[0] as $k => $match)
		{
			$yid = $matches[3][$k];
			$iframe = '<iframe width="100%" height="315" src="https://www.youtube.com/embed/' . $yid . '" frameborder="0" allowfullscreen></iframe>';
			$story['text'] = str_replace($match, $iframe, $story['text']);
		}
	}

	$rgx3 = '/\<a href\=\"(|https:\/\/|http:\/\/)(|www\.)youtube.com\/(embed|v)\/([a-zA-Z0-9_-]+)\"(.*?)\<\/a\>/i';
	if (preg_match_all($rgx3, $story['text'], $matches))
	{
		foreach ($matches[0] as $k => $match)
		{
			$yid = $matches[4][$k];
			$iframe = '<iframe width="100%" height="315" src="https://www.youtube.com/embed/' . $yid . '" frameborder="0" allowfullscreen></iframe>';
			$story['text'] = str_replace($match, $iframe, $story['text']);
		}
	}

	$rgx4 = '/\<a href\=\"(|https:\/\/|http:\/\/)(|www\.)(.*?)\"(.*?)rel\=\"nofollow\"(.*?)\<\/a\>/i';
	if (preg_match_all($rgx4, $story['text'], $matches))
	{
		foreach ($matches[0] as $k => $match)
		{
			$url = $matches[1][$k] . $matches[2][$k] . $matches[3][$k];
			$urlname = preg_replace('/[^A-Za-z0-9_]/i', '', $url);
			$metadir = 'meta_tags/' . date('Y') . '/' . date('m');
			$metafile = $metadir . '/' . $urlname . '.json';
			if (! file_exists($metadir) )
			{
				mkdir($metadir, 0777, true);
			}

			if ( file_exists($metafile) )
			{
				$meta_data = file_get_contents($metafile);
				$meta_tags = json_decode($meta_data, true);
			}
			else
			{
				$escapeObj = new \SocialKit\Escape();
				$get_meta_tags = grab_meta_tags($url);
				$meta_tags = array();
				$meta_tags['title'] = $escapeObj->stringEscape($get_meta_tags['title']);
				
				if ( isset($get_meta_tags['img_preview']) )
				{
					$meta_tags['img_preview'] = $get_meta_tags['img_preview'];
					$ext = file_ext($meta_tags['img_preview']);
					$imgfile = $metadir . '/' . $urlname . '.' . $ext;
					file_put_contents($imgfile, file_get_contents($meta_tags['img_preview']));
					$meta_tags['img_preview'] = $imgfile;
				}

				if ( isset($get_meta_tags['description']) )
				{
					$meta_tags['description'] = $escapeObj->stringEscape($get_meta_tags['description']);
				}

				file_put_contents($metafile, json_encode($meta_tags));
			}

			$preview_data = '<div class="url-preview-container">';

			if (! empty($meta_tags['img_preview']) )
			{
				$preview_data .= '<a href="' . $url . '" target="_blank">
					<div class="img-preview">
						<div style="background-image: url(\'' . $meta_tags['img_preview'] .'\');"></div>
					</div>
				</a>';
			}

			if (! empty($meta_tags['title']) )
			{
				$preview_data .= '<div class="title">
					<a href="' . $url . '" target="_blank">' . $meta_tags['title'] . '</a>
				</div>';
			}

			if (! empty($meta_tags['description']) )
			{
				$preview_data .= '<div class="descr">
					<a href="' . $url . '" target="_blank">' . $meta_tags['description'] . '</a>
				</div>';
			}

			$preview_data .= '</div>';
			$story['text'] = str_replace($match, $match . $preview_data, $story['text']);
		}
	}
	
	return $story;
}
\SocialKit\Addons::register('story_content_editor', 'story_youtube_detector');

/* CSS */
function url_preview_css()
{
	return '<style>
	.url-preview-container
	{
		display: block;
		color: #898f9c;
		padding: 5px 10px;
	}
	.url-preview-container .img-preview
	{
		overflow: hidden;
		max-height: 250px;
	}
	.url-preview-container .img-preview div
	{
		background-position: center center;
		background-size: cover;
		background-repeat: no-repeat;
		width: 100%;
		height: 100%;
		padding: 60% 0 0 0;
		overflow: hidden;
	}
	.url-preview-container .title
	{
		color: #333;
		font-size: 15px;
		font-weight: bold;
		margin: 8px 0;
	}
	.url-preview-container .title a
	{
		color: #333;
	}
	.url-preview-container .descr
	{
		color: #555;
		margin: 0 0 8px 0;
	}
	.url-preview-container .descr a, .url-preview-container .descr a:hover
	{
		color: #555;
		text-decoration: none;
	}
	</style>';
}
\SocialKit\Addons::register('head_tags_add_content', 'url_preview_css');