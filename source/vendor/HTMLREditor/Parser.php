<?php

namespace Work\plugin\core;

use Work\plugin\lib\jQuery;

/**
 * Interface LoggerParser
 * интерфейс для класса Parser
 *
 * @file /example/Parser.php
 * @package Work\plugin\core
 */
interface LoggerParser {

	/**
	 *
	 * @param $content
	 * @return string|string[]|null
	 */
	public static function register($content);

}

/**
 * Class Parser
 *
 * @package Work\plugin\core
 */
class Parser implements LoggerParser {

	/**
	 *
	 * @param $content
	 * @return string|string[]|null
	 */
	public static function register($content) {

		// $content = htmlspecialchars($content);

		$search = [
			'/\[b\](.*?)\[\/b\]/is',
			'/\[i\](.*?)\[\/i\]/is',
			'/\[u\](.*?)\[\/u\]/is',
			'/\[s\](.*?)\[\/s\]/is',

			'/\[line\]/is',

			'/\[h1\](.*?)\[\/h1\]/is',
			'/\[h2\](.*?)\[\/h2\]/is',
			'/\[h3\](.*?)\[\/h3\]/is',
			'/\[h4\](.*?)\[\/h4\]/is',
			'/\[h5\](.*?)\[\/h5\]/is',
			'/\[h6\](.*?)\[\/h6\]/is',

			'/\[img\](.*?)\[\/img\]/is',

			'/\[media\](.*?)\[\/media\]/is',

			'/\[url\](.*?)\[\/url\]/is',
			'/\[url\=(.*?)\](.*?)\[\/url\]/is',

			'/\[center\](.*?)\[\/center\]/is',
			'/\[left\](.*?)\[\/left\]/is',
			'/\[right\](.*?)\[\/right\]/is',

			'/\[code\=(.*?)\](.*?)\[\/code\]/is',

			'/\[quote\](.*?)\[\/quote\]/is',

			'/\[list\](.*?)\[\/list\]/is',
			'/\[list\=(.*?)](.*?)\[\/list\]/is',
			'/\[l\](.*?)\[\/l\]/is',

			'/\[font\=(.*?)](.*?)\[\/font\]/is',

			'/\[size\=(.*?)](.*?)\[\/size\]/is',

			'/\[a\=(.*?)](.*?)\[\/a\]/is',

			'/\[spoiler\](.*?)\[\/spoiler\]/is'
		];

		$replace = [
			'<strong>$1</strong>',
			'<em>$1</em>',
			'<u>$1</u>',
			'<s>$1</s>',

			'<hr />',

			'<h1>$1</h1>',
			'<h2>$1</h2>',
			'<h3>$1</h3>',
			'<h4>$1</h4>',
			'<h5>$1</h5>',
			'<h6>$1</h6>',

			'<img src="$1" />',

			'<div class="bbmedia" data-url="$1" style="margin: 1px; display: inline-block; vertical-align: bottom;">
				<script>if (typeof bbmedia == "undefined") { bbmedia = true; var e = document.createElement("script"); e.async = true; e.src = "http://phpbbex.com/api/bbmedia.js"; var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(e, s); }</script>
			</div>',

			'<a href="$1">$1</a>',
			'<a href="$1">$2</a>',

			'<div align="center">$1</div>',
			'<div align="left">$1</div>',
			'<div align="right">$1</div>',

			'<div class="code-wrapper code-wapper-rees">
				<div class="code-wp-title">$1</div>
				<pre><code>$2</code></pre>
			</div>',

			'<div class="quote-wrapper quote-wrapper-rees">$1</div>',

			'<ul>$1</ul>',
			'<ul type="$1">$2</ul>',
			'<li>$1</li>',

			'<div><font	face="$1">$2</font></div>',
			'<div sass="font-size: $1px">$2</div>',

			'<a href="$1">$2</a>',

			'<div class="spoiler-wrapper spoiler-wrapper-rees">
				<input type="checkbox" id="spoiler-onclick">
				<div class="spoiler-wp-title"><label class="spoiler-click" for="spoiler-onclick">Спойлер:</label></div>
				<div class="spoiler-wp-content">$1</div>
			</div>'
		];

		$content = nl2br($content);

		$content = preg_replace($search, $replace, $content);

		return $content;

	}

}