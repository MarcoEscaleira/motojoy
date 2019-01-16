<?php
/**
 * Carregamento de assets
 */
class Assets
{
	public static function loadCSS_Assets($arquivo = null, $media = 'screen', $import = false) {
		if ($arquivo != null) {
			if ($import) {
				echo '<style type="text/css">@import url("'.ASSETS_PATH.$arquivo . '.css");</style>';
			} else {
				echo '<link rel="stylesheet" type="text/css" href="'.ASSETS_PATH.$arquivo.'.css" media="'.$media.'">'."\n\t";
			}
		}
	}

	public static function loadCSS_Custom($arquivo = null, $media = 'screen', $import = false) {
		if ($arquivo != null) {
			if ($import) {
				echo '<style type="text/css">@import url("'.CUSTOM_PATH_CSS.$arquivo . '.css");</style>';
			} else {
				echo '<link rel="stylesheet" type="text/css" href="'.CUSTOM_PATH_CSS.$arquivo.'.css" media="'.$media.'">'."\n\t";
			}
		}

	}

	public static function loadJS_Assets($arquivo = null, $remoto = false) {
		if ($arquivo != null) {
			if ($remoto == false) {
				echo '<script type="text/javascript" src="'.ASSETS_PATH.$arquivo.'.js"></script>'."\n\t";
			} else {
				echo '<script type="text/javascript" src="'.$arquivo.'.js"></script>'."\n\t";
			}
		}
	}

	public static function loadJS_Custom($arquivo = null, $remoto = false) {
		if ($arquivo != null) {
			if ($remoto == false) {
				echo '<script type="text/javascript" src="'.CUSTOM_PATH_JS.$arquivo.'.js"></script>'."\n\t";
			} else {
				echo '<script type="text/javascript" src="'.$arquivo.'.js"></script>'."\n\t";
			}
		}
	}
}
