#!/usr/bin/php
<?php
	array_shift($argv) and empty($argv) and die('Input file not especified');
	define('_FILE_IO_', $argv[0]);
	function File2HTML() {
		($conts = file_get_contents(_FILE_IO_)) or die('File not found.');

		require_once 'function.file2functionlist.php';
		$functions = File2FunctionList($conts);

		$output = '';
		$head = '<h1>'._FILE_IO_.'</h1>'.PHP_EOL;
		$items = "<ul>\n";
		$body = <<<RANTES

		<a name="#{{functionName}}"></a>
		<h2>{{functionName}}</h2>
		<p>{{comment}}</p>

RANTES;

		foreach ($functions as $entry):
			$output .= str_replace('{{functionName}}', $entry['name'], $body);
			$output .= str_replace('{{comment}}', $entry['comment'], $body);
			$items .= "\t<li><a href=\"#{$entry['name']}\">{$entry['name']}</a></li>\n";
		endforeach;

		$items .= "</ul>";

		$output = "{$head}\n{$items}\n{$output}";
		return $output;
	}

	var_dump(File2HTML());
?>