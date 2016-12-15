<?php
function music_upload_css()
{
	return '<style>
	.music-upload-container {
	display: block;
	color: #898f9c;
	padding: 5px 10px;
	}
	</style>';
}
\SocialKit\Addons::register('head_tags_add_content', 'music_upload_css');
