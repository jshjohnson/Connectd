<?php 
	class URLs {

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
		
	}