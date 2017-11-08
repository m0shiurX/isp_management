<?php

	/**
	 * Class of common functions
	 */
	class Commons
	{

		private $dbh = null;
		public function __construct($db)
		{
			$this->dbh = $db->dbh;
		}


	    /**
	     * Check user_name
	     */
	    public function isAvailableuser_name($user_name)
	    {
	        $request = $this->dbh->prepare("SELECT user_name FROM kp_user WHERE user_name = ?");
	        return $request->execute( array($user_name) );
	    }


	    /*
	     * Check if a field is empty or not
	     */
	    public function isFieldEmpty($field)
	    {
	    	if ( isset($field) && ( empty($field) || trim($field)  == '' ) )
	    	{
	    		return true;
	    	}else{
	    		return false;
	    	}
	    }



	    /*
	     * Redirecting helper
	     */
	    public function redirectTo($url)
	    {
	    	if (!headers_sent())
	    	{
	    		header('location:'.$url);
	    		exit;
	    	}else{
	    		print '<script type="text/javascript">';
	            print 'window.location.href="'.$url.'";';
	            print '</script>';

	            print '<noscript>';
	            print '<meta http-equiv="refresh" content="0;url='.$url.'" />';
	            print '</noscript>'; exit;
	    	}
	    }


	}

	/**
 * Function to convert a number to a the string literal for the number
 */
function getToText($num) {
	$count = 0;
	global $ones, $tens, $triplets;
	$ones = array(
	  '',
	  ' One',
	  ' Two',
	  ' Three',
	  ' Four',
	  ' Five',
	  ' Six',
	  ' Seven',
	  ' Eight',
	  ' Nine',
	  ' Ten',
	  ' Eleven',
	  ' Twelve',
	  ' Thirteen',
	  ' Fourteen',
	  ' Fifteen',
	  ' Sixteen',
	  ' Seventeen',
	  ' Eighteen',
	  ' Nineteen'
	);
	$tens = array(
	  '',
	  '',
	  ' Twenty',
	  ' Thirty',
	  ' Forty',
	  ' Fifty',
	  ' Sixty',
	  ' Seventy',
	  ' Eighty',
	  ' Ninety'
	);
  
	$triplets = array(
	  '',
	  ' Thousand',
	  ' Million',
	  ' Billion',
	  ' Trillion',
	  ' Quadrillion',
	  ' Quintillion',
	  ' Sextillion',
	  ' Septillion',
	  ' Octillion',
	  ' Nonillion'
	);
	return convertNum($num);
  }
  
  /**
   * Function to dislay tens and ones
   */
  function commonloop($val, $str1 = '', $str2 = '') {
	global $ones, $tens;
	$string = '';
	if ($val == 0)
	  $string .= $ones[$val];
	else if ($val < 20)
	  $string .= $str1.$ones[$val] . $str2;  
	else
	  $string .= $str1 . $tens[(int) ($val / 10)] . $ones[$val % 10] . $str2;
	return $string;
  }
  
  /**
   * returns the number as an anglicized string
   */
  function convertNum($num) {
	$num = (int) $num;    // make sure it's an integer
  
	if ($num < 0)
	  return 'negative' . convertTri(-$num, 0);
  
	if ($num == 0)
	  return 'Zero';
	return convertTri($num, 0);
  }
  
  /**
   * recursive fn, converts numbers to words
   */
  function convertTri($num, $tri) {
	global $ones, $tens, $triplets, $count;
	$test = $num;
	$count++;
	// chunk the number, ...rxyy
	// init the output string
	$str = '';
	// to display hundred & digits
	if ($count == 1) {
	  $r = (int) ($num / 1000);
	  $x = ($num / 100) % 10;
	  $y = $num % 100;
	  // do hundreds
	  if ($x > 0) {
		$str = $ones[$x] . ' Hundred';
		// do ones and tens
		$str .= commonloop($y, ' and ', '');
	  }
	  else if ($r > 0) {
		// do ones and tens
		$str .= commonloop($y, ' and ', '');
	  }
	  else {
		// do ones and tens
		$str .= commonloop($y);
	  }
	}
	// To display lakh and thousands
	else if($count == 2) {
	  $r = (int) ($num / 10000);
	  $x = ($num / 100) % 100;
	  $y = $num % 100;
	  $str .= commonloop($x, '', ' Lakh ');
	  $str .= commonloop($y);
	  if ($str != '')
		$str .= $triplets[$tri];
	}
	// to display till hundred crore
	else if($count == 3) {
	  $r = (int) ($num / 1000);
	  $x = ($num / 100) % 10;
	  $y = $num % 100;
	  // do hundreds
	  if ($x > 0) {
		$str = $ones[$x] . ' Hundred';
		// do ones and tens
		$str .= commonloop($y,' and ',' Crore ');
	  }
	  else if ($r > 0) {
		// do ones and tens
		$str .= commonloop($y,' and ',' Crore ');
	  }
	  else {
		// do ones and tens
		$str .= commonloop($y);
	  }
	}
	else {
	  $r = (int) ($num / 1000);
	}
	// add triplet modifier only if there
	// is some output to be modified...
	// continue recursing?
	if ($r > 0)
	  return convertTri($r, $tri+1) . $str;
	else
	  return $str;
  }

