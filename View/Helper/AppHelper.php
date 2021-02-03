<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class AppHelper extends Helper 
{
    
    /**
	 * Function to convert a static time into a relative measurement
	 *
	 * @param   string  $date  The date to convert
	 * @param   string  $unit  The optional unit of measurement to return
	 *                         if the value of the diff is greater than one
	 * @param   string  $time  An optional time to compare to, defaults to now
	 *
	 * @return  string  The converted time string
	 *
	 * @since   2.5
	 */
	public function relativeTime($date)
	{
        $time = time();
		$publish = strtotime($date);
        // Get the difference in seconds between now and the time
		$diff = $time - $publish;

		if ($diff <= 10 && $diff >= 0) {
            return __('just now', true);
        }
        
        // Less than a minute
		if ($diff < 60)
		{
			return sprintf(__('seconds'), $diff);
		}

        $diff = round($diff / 60);
        // 1 to 59 minutes
		if ($diff < 60 )
		{
            return sprintf(__('minute'), $diff);
		}

        $diff = round($diff / 60);
		// 1 to 23 hours
		if ($diff < 24 )
		{
            return sprintf(__('hour'), $diff);
		}

		// Round to days
//		$diff = round($diff / 24);

		// 1 to 6 days
//		if ($diff < 7)
//		{
//			return JText::plural('JLIB_HTML_DATE_RELATIVE_DAYS', $diff);
//		}
//
//		// Round to weeks
//		$diff = round($diff / 7);
//
//		// 1 to 4 weeks
//		if ($diff <= 4 )
//		{
//			return JText::plural('JLIB_HTML_DATE_RELATIVE_WEEKS', $diff);
//		}

		// Over a month, return the absolute time
		return  '<a href="#" title="'.date('Y M d h:i:s', strtotime($date)).'">'.date('M d', strtotime($date)).'</a>';
//		return  $date;
	}
    
    /**
     * remove regx char (�, :, !)
     * @param type $string
     * @return type
     */
    public function cleanString($string = NULL)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?", "»", "«", "\"\ ", "?");

        if (!is_null($string)) {
            $string = trim(str_replace($strip, "", strip_tags($string)));
            $string = preg_replace('/[-\s]+/', '-', $string);
        }

        return $string;
    }
}
