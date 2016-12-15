<?php
function footer_call_mediaElement ()
{
	return '<script>$(\'audio.story-music-upload-html\').mediaelementplayer();</script>';
}
\SocialKit\Addons::register('body_end_add_content', 'footer_call_mediaElement');
