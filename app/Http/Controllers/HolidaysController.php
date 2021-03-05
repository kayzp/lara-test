<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HolidaysController extends Controller
{
	public $holidays = [
		'1st of January' => 'New Year`s Day',
		'7th of January' => 'Old Rock Day',
		'From 1st of May till 7th of May' => 'Labor Day / May Day',
		'Monday of the 3rd week of January' => 'Blue Monday',
		'Monday of the last week of March' => 'National Goof Off Day',
		'Thursday of the 4th week of November' => 'Thanksgiving'
	];
	public $year = '';

	// Check Holidays from Array
    public function CheckHolidays(Request $request) {

    	$dates = [];

    	$dat = date('l', strtotime($request->input('date'))).' '.$this->WeekOfMonth(strtotime($request->input('date'))).' '.date('F', strtotime($request->input('date')));

    	$this->year = date('Y', strtotime($request->input('date')));
    	
    	foreach ($this->holidays as $date => $name) {
    		if (str_contains($date, 'From') && str_contains($date, 'till')) {
    			$dates['normal'] = array_merge($dates['normal'], $this->CheckPerionDate($date, $name));
    		} else if (str_contains($date, 'week')) {
    			$dates['week'][$this->CheckWeekDate($date)] = $name;
    		} else {
    			$dates['normal'][$this->CheckSimpleDate($date)] = $name;
    		}
    	}

    	foreach ($dates['normal'] as $key => $value) {
			if ($request->input('date') == $key) {
				return redirect()->route('home')->with('holiday_result' , $value);
			}
    	}

    	foreach ($dates['week'] as $key => $value) {
    		if ($dat == $key) {
    			return redirect()->route('home')->with('holiday_result' , $value);
    		}
    	}

    	return redirect()->route('home')->with('holiday_result' , 'No Holidays Found');
    }

    // Check Period Date type
   	public function CheckPerionDate($date, $name) {

   		$string = explode(' till ', str_replace('From ', '', $date));

   		foreach ($string as $key => $value) {
   			$array[] = $this->CheckSimpleDate($value);
   		}

   		foreach ($this->CreateDateRangeArray($array[0], $array[1]) as $key => $value) {
   			$period[$value] = $name;
   		}

   		return $period;
   	}

   	// Check Week Number Date type
   	public function CheckWeekDate($date) {

   		$date = explode(' of ', $date);

   		if (str_contains($date[1], 'last')) {
   			if ($date[2] == 'February') {
   				$month = '4';
   			} else {
   				$month = '5';
   			}
   		} else if (str_contains($date[1], 'first')) {
   			$month = '1';
   		} else {
   			$month = intval(str_replace('the ', '', str_replace(' week', '', $date[1])));
   		}

   		return $date[0].' '.$month.' '.$date[2];
   	}

   	// Check Simple Date type
   	public function CheckSimpleDate($date) {

   		$string = explode(' of ', $date);
   		$day = intval($string[0]) < 10 ? '0'.intval($string[0]) : intval($string[0]);
   		$date = $this->year.'-'.$this->CheckMonth($string[1]).'-'.$day;

   		return $date;
   	}

   	// Get month number from case
   	public function CheckMonth($month) {

   	 	switch ($month) {
		    case 'January':
		        $month = '01';
		        break;
		    case 'February':
		        $month = '02';
		        break;
		    case 'March':
		        $month = '03';
		        break;
		    case 'April':
		        $month = '04';
		        break;
		    case 'May':
		        $month = '05';
		        break;
		    case 'June':
		        $month = '06';
		        break;
		    case 'July':
		        $month = '07';
		        break;
		    case 'August':
		        $month = '08';
		        break;
		    case 'September':
		        $month = '09';
		        break;
		    case 'October':
		        $month = '10';
		        break;
		    case 'November':
		        $month = '11';
		        break;
		    case 'December':
		        $month = '12';
		        break;
		}

		return $month;
   	}

   	// Make list of date from Period Date type
   	public function CreateDateRangeArray($From, $To) {

	    $aryRange 	= [];
	    $iDateFrom 	= mktime(1, 0, 0, substr($From,5,2), substr($From,8,2), substr($From,0,4));
	    $iDateTo 	= mktime(1, 0, 0, substr($To,5,2), substr($To,8,2), substr($To,0,4));

	    if ($iDateTo >= $iDateFrom) {
	        array_push($aryRange, date('Y-m-d', $iDateFrom));
	        while ($iDateFrom < $iDateTo)
	        {
	            $iDateFrom += 86400;
	            array_push($aryRange, date('Y-m-d', $iDateFrom));
	        }
	    }
	    return $aryRange;
	}

	// Get Week Number of month
	public function WeekOfMonth($date) {

	    $firstOfMonth = strtotime(date("Y-m-01", $date));
	    return $this->WeekOfYear($date) - $this->WeekOfYear($firstOfMonth) + 1;
	}

	// Get Wekk Number of year
	public function WeekOfYear($date) {

	    $weekOfYear = intval(date("W", $date));

	    if (date('n', $date) == "1" && $weekOfYear > 51) {
	        $weekOfYear = 0;    
	    }

	    return $weekOfYear;
	}
}