<?php
namespace WordPress\L18N;
/**
 * Console application, which adds metadata strings from
 * a WordPress extension to a POT file
 *
 * @package wordpress-i18n
 * @subpackage tools
 */

if ( !class_exists( 'PO' ) )
	WordPressIncluder::get('wp-includes/pomo/po.php');

use \Translation_Entry;
use \PO;

class PotExtMeta {

	var $headers = array(
		'Plugin Name',
		'Theme Name',
		'Plugin URI',
		'Theme URI',
		'Description',
		'Author',
		'Author URI',
		'Tags',
	);


	function usage() {
		fwrite(STDERR, "Usage: php pot-ext-meta.php EXT POT\n");
		fwrite(STDERR, "Adds metadata from a WordPress theme or plugin file EXT to POT file\n");
		exit(1);
	}

	function load_from_file($ext_filename) {
		$source = MakePOT::get_first_lines($ext_filename);
		$pot = '';
		foreach($this->headers as $header) {
			$string = MakePOT::get_addon_header($header, $source);
			if (!$string) continue;
			$args = array(
				'singular' => $string,
				'extracted_comments' => $header.' of the plugin/theme',
			);
			$entry = new Translation_Entry($args);
			$pot .= "\n".PO::export_entry($entry)."\n";
		}
		return $pot;
	}

	function append( $ext_filename, $pot_filename, $headers = null ) {
		if ( $headers )
			$this->headers = (array) $headers;
		if ( is_dir( $ext_filename ) ) {
			$pot = implode('', array_map(array($this, 'load_from_file'), glob("$ext_filename/*.php")));
		} else {
			$pot = $this->load_from_file($ext_filename);
		}
		$potf = '-' == $pot_filename? STDOUT : fopen($pot_filename, 'a');
		if (!$potf) return false;
		fwrite($potf, $pot);
		if ('-' != $pot_filename) fclose($potf);
		return true;
	}
}
