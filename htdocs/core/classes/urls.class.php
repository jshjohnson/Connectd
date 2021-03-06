<?php 
	class URLs {

		/**
		 * Truncate URL to 50 characters
		 * Based upon http://stackoverflow.com/questions/3161816/php-cut-a-string-after-x-characters/15584818#15584818
		 *
		 * @param  integer  $starredBy The user logged in voting
		 * @return array
		 */ 
	    public function truncate($text, $len) {
	        if (strlen($text) < $len) {
	            return $text;
	        }
	        $text_words = explode(' ', $text);
	        $out = null;

	        foreach ($text_words as $word) {
	            if ((strlen($word) > $len) && $out == null) {

	                return substr($word, 0, $len) . "...";
	            }
	            if ((strlen($out) + strlen($word)) > $len) {
	                return $out . "...";
	            }
	            $out.=" " . $word;
	        }
	        return $out;
	    }

		/**
		 * Generate URLs from Twitter anchors, hastags, mentions and URLs
		 * Based upon http://roadha.us/2011/04/create-anchor-links-in-twitter-status-text-with-php/
		 *
		 * @param  integer  $starredBy The user logged in voting
		 * @return array
		 */ 
		public function twitterLinks($text) {
			// convert URLs into links
			$text = preg_replace(
				"#(https?://([-a-z0-9]+\.)+[a-z]{2,5}([/?][-a-z0-9!\#()/?&+]*)?)#i", "<a href='$1'>$1</a>",
				$text);
			// convert protocol-less URLs into links
			$text = preg_replace(
				"#(?!https?://|<a[^>]+>)(^|\s)(([-a-z0-9]+\.)+[a-z]{2,5}([/?][-a-z0-9!\#()/?&+.]*)?)\b#i", "$1<a href='http://$2'>$2</a>",
				$text);
			// convert @mentions into follow links
			$text = preg_replace(
				"#(?!https?://|<a[^>]+>)(^|\s)(@([_a-z0-9\-]+))#i", "$1<a href=\"http://twitter.com/$3\" title=\"Follow $3\">@$3</a>",
				$text);
			// convert #hashtags into tag search links
			$text = preg_replace(
				"#(?!https?://|<a[^>]+>)(^|\s)(\#([_a-z0-9\-]+))#i", "$1<a href='http://twitter.com/search?q=%23$3' title='Search tag: $3'>#$3</a>",
				$text);
			return $text;
		}
		
	}