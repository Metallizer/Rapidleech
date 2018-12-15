<?php

if (!defined('RAPIDLEECH')) {
	require_once('index.html');
	exit;
}

class spankbang_com extends DownloadClass {
	public function Download($link) {
		if (!preg_match('@(https?://(?:[\w\-]+\.)+[\w\-]+)(?:/[\d\w]+)(?:/video)(\S+)@i', $link, $vid)) html_error('Invalid Link.');

			$page = $this->GetPage($link);

		preg_match_all('/Set-Cookie: (.*);/U',$page,$temp);
            $cookie = $temp[1];
            $cookie = implode(';',$cookie);		

		if (!preg_match('@<h1 title="[^"<>]+?">\s*([^"<>]+?)\s*</h1>@i', $page, $title)) {
			is_present($page, 'Sorry but the page you requested was not found.', 'Video not found or it was deleted.');
			is_present($page, 'We received a request to have this video deleted.', 'Video disabled for dispute.');
			html_error('Error: Video title not found.');
		}

		if (preg_match('@(?<=source src=")\S+?[\"]+@', $page, $DL));
		else html_error('Error: Download link not found.');
		$DL = str_replace( 'amp;', '', $DL );
		$DL = urldecode($DL[0]);

		if (!preg_match('@\.(?:mp4|flv|webm|avi)$@i', basename($DL), $ext)) $ext = array('.mp4');
		$filename = preg_replace('@(?:\.(?:mp4|flv|mkv|webm|wmv|(m2)?ts|rm(vb)?|mpe?g?|vob|avi|[23]gp))+$@i', '', preg_replace('@[^ A-Za-z_\-\d\.,\(\)\[\]\{\}&\!\'\@\%\#]@u', '_', html_entity_decode(trim($title[1]), ENT_QUOTES, 'UTF-8')));
		$filename .= sprintf(' [SB][%s]%s', $vid[2], $ext[0]);

		$this->RedirectDownload($DL, $filename, 0, 0, 0, $filename);
	}
}

//[03-07-2017] SpangBang plugin written by Metallizer.
//Based on xvideo plugin written by Th3-822.

?>