<?php
	$q=strtotime($_GET["q"]);

	$con = mysqli_connect('mysqlcluster.adm.library.oregonstate.edu', 'drupal', 'dr@dm1n', 'drupal_cms');
	if (!$con){
		die('Could not connect: ' . mysqli_error());
	}

	$sql="SELECT term_start_date, term_end_date, id FROM `hours` WHERE loc='The Valley Library'";
	$result = mysqli_query($con, $sql);
	
	$i = date('w',$q)-1;
	//if current day is sunday fix index
	if($i < 0){
		$i = 6;
	}
	$j = 0;
	$curr_day = $q;
	
	$n = 0;
	while($row = mysqli_fetch_assoc($result)){
		$start = strtotime($row['term_start_date']);
		$end = strtotime($row['term_end_date']);
		$hoursId = $row['id'];
		
		//Find the term the date resides in
		if($curr_day >= $start && $curr_day <= $end){
			$term_query = "SELECT * FROM `hours` WHERE id='".$hoursId."' AND loc ='The Valley Library'";
			$term_result = mysqli_query($con, $term_query);
			$term_row = mysqli_fetch_assoc($term_result);
			switch($i){
				case 6:
					$open[$i] = (substr($term_row['open_time_7'],0,2)-0).''.substr($term_row['open_time_7'],2);
					$close[$i] = (substr($term_row['close_time_7'],0,2)-0).''.substr($term_row['close_time_7'],2);
					break;
				case 5:
					$open[$i] = (substr($term_row['open_time_6'],0,2)-0).''.substr($term_row['open_time_6'],2);
					$close[$i] = (substr($term_row['close_time_6'],0,2)-0).''.substr($term_row['close_time_6'],2);
					break;
				case 4:
					$open[$i] = (substr($term_row['open_time_5'],0,2)-0).''.substr($term_row['open_time_5'],2);
					$close[$i] = (substr($term_row['close_time_5'],0,2)-0).''.substr($term_row['close_time_5'],2);
					break;
				default:
					$open[$i] = (substr($term_row['open_time_1'],0,2)-0).''.substr($term_row['open_time_1'],2);
					$close[$i] = (substr($term_row['close_time_1'],0,2)-0).''.substr($term_row['close_time_1'],2);
					break;
			}
		}
		
		//Intersession
		$int_query = "SELECT * FROM `int_hours` WHERE hours_id = '".$hoursId."'";
		$int_result = mysqli_query($con, $int_query);
		
		//Find the term the date resides in
		if(mysqli_num_rows($int_result) > 0){
			while($int_row = mysqli_fetch_assoc($int_result)){
				if(($curr_day >= strtotime($int_row['start_date']))&&($curr_day <= strtotime($int_row['end_date']))){
					switch($i){
						case 6: //sunday
							/*if(substr($int_row['open_time_sun'],0,2) > 12){
								$open[$i] = (substr($int_row['open_time_sun'],0,2)-12).':'.substr($int_row['open_time_sun'],3,2).' pm';
							}
							else if(substr($int_row['open_time_sun'],0,2) == 12){
								$open[$i] = (substr($int_row['open_time_sun'],0,2)-0).':'.substr($int_row['open_time_sun'],3,2).' pm';
							}
							else{
								$open[$i] = (substr($int_row['open_time_sun'],0,2)-0).':'.substr($int_row['open_time_sun'],3,2).' am';
							}*/

							$open[$i] = date('g:iA', strtotime($int_row['open_time_sun']));
						
							/*if(substr($int_row['close_time_sun'],0,2) > 12){
								$close[$i] = (substr($int_row['close_time_sun'],0,2)-12).':'.substr($int_row['close_time_sun'],3,2).' pm';
							}
							else if(substr($int_row['close_time_sun'],0,2) == 12){
								$close[$i] = (substr($int_row['close_time_sun'],0,2)-0).':'.substr($int_row['close_time_sun'],3,2).' pm';
							}
							else{
								$close[$i] = (substr($int_row['close_time_sun'],0,2)-0).':'.substr($int_row['close_time_sun'],3,2).' am';
							}*/

							$close[$i] = date('g:iA', strtotime($int_row['close_time_sun']));
							break;
						case 5: //saturday
							/*if(substr($int_row['open_time_sat'],0,2) > 12){
								$open[$i] = (substr($int_row['open_time_sat'],0,2)-12).':'.substr($int_row['open_time_sat'],3,2).' pm';
							}
							else if(substr($int_row['open_time_sat'],0,2) == 12){
								$open[$i] = (substr($int_row['open_time_sat'],0,2)-0).':'.substr($int_row['open_time_sat'],3,2).' pm';
							}
							else{
								$open[$i] = (substr($int_row['open_time_sat'],0,2)-0).':'.substr($int_row['open_time_sat'],3,2).' am';
							}*/

							$open[$i] = date('g:iA', strtotime($int_row['open_time_sat']));
						
							/*if(substr($int_row['close_time_sat'],0,2) > 12){
								$close[$i] = (substr($int_row['close_time_sat'],0,2)-12).':'.substr($int_row['close_time_sat'],3,2).' pm';
							}
							else if(substr($int_row['close_time_sat'],0,2) == 12){
								$close[$i] = (substr($int_row['close_time_sat'],0,2)-0).':'.substr($int_row['close_time_sat'],3,2).' pm';
							}
							else{
								$close[$i] = (substr($int_row['close_time_sat'],0,2)-0).':'.substr($int_row['close_time_sat'],3,2).' am';
							}*/
							$close[$i] = date('g:iA', strtotime($int_row['close_time_sat']));
							break;
						default:
							/*if(substr($int_row['open_time_wk'],0,2) > 12){
								$open[$i] = (substr($int_row['open_time_wk'],0,2)-12).':'.substr($int_row['open_time_wk'],3,2).' pm';
							}
							else if(substr($int_row['open_time_wk'],0,2) == 12){
								$open[$i] = (substr($int_row['open_time_wk'],0,2)-0).':'.substr($int_row['open_time_wk'],3,2).' pm';
							}
							else{
								$open[$i] = (substr($int_row['open_time_wk'],0,2)-0).':'.substr($int_row['open_time_wk'],3,2).' am';
							}*/
							$open[$i] = date('g:iA', strtotime($int_row['open_time_wk']));

							/*if(substr($int_row['close_time_wk'],0,2) > 12){
								$close[$i] = (substr($int_row['close_time_wk'],0,2)-12).':'.substr($int_row['close_time_wk'],3,2).' pm';
							}
							else if(substr($int_row['close_time_wk'],0,2) == 12){
								$close[$i] = (substr($int_row['close_time_wk'],0,2)-0).':'.substr($int_row['close_time_wk'],3,2).' pm';
							}
							else{
								$close[$i] = (substr($int_row['close_time_wk'],0,2)-0).':'.substr($int_row['close_time_wk'],3,2).' am';
							}*/
							$close[$i] = date('g:iA', strtotime($int_row['close_time_wk']));
							break;
					}
				}
			}
		}	
		
		//Special Events
		$special_query = "SELECT * FROM `special_hours` WHERE hours_id = '".$hoursId."'";
		$special_result = mysqli_query($con, $special_query);
		if(mysqli_num_rows($special_result) > 0){
			while($special_row = mysqli_fetch_assoc($special_result)){
				if(($curr_day >= strtotime($special_row['start_date']))&&($curr_day <= strtotime($special_row['end_date']))){
					/*if(substr($special_row['open_time'],0,2) > 12){
						$open[$i] = (substr($special_row['open_time'],0,2)-12).':'.substr($special_row['open_time'],3,2).' pm';
					}
					else if(substr($special_row['open_time'],0,2) == 12){
						$open[$i] = (substr($special_row['open_time'],0,2)-0).':'.substr($special_row['open_time'],3,2).' pm';
					}
					else{
						$open[$i] = (substr($special_row['open_time'],0,2)-0).':'.substr($special_row['open_time'],3,2).' am';
					}*/
					$open[$i] = date('g:iA', strtotime($special_row['open_time']));
				
					/*if(substr($special_row['close_time'],0,2) > 12){
						$close[$i] = (substr($special_row['close_time'],0,2)-12).':'.substr($special_row['close_time'],3,2).' pm';
					}
					else if(substr($special_row['close_time'],0,2) == 12){
						$close[$i] = (substr($special_row['close_time'],0,2)-0).':'.substr($special_row['close_time'],3,2).' pm';
					}
					else{
						$close[$i] = (substr($special_row['close_time'],0,2)-0).':'.substr($special_row['close_time'],3,2).' am';
					}*/
					$close[$i] = date('g:iA', strtotime($special_row['close_time']));
					$special_note[$i] = '('.$special_row['title'].')';
					break;
				}
			}
		}
	}
	//Print Hours	
	$days = array(0=>'Mon:', 'Tues:', 'Wed:', 'Thurs:', 'Fri:', 'Sat:', 'Sun:');
	$j = 0;
	$i = date(w, $q)-1;
	//if current day is sunday fix index
	if($i < 0){
		$i = 6;
	}
	
	if(isset($open[$i])){
		//Print todays date specially
		if($close[$i] == '12:15AM' || $open[$i] == '12:15AM'){
			echo '<p><strong>'.$_GET['q'].':</strong><br />'. ($open[$i] == '12:15AM' ? 'No Closing' : $open[$i]) .' - ' . ($close[$i] == '12:15AM' ? 'No Closing' : $close[$i]) . ' '.((isset($special_note[$i])) ? $special_note[$i] : '').'<br />';
		}else{
			echo '<p><strong>'.$_GET['q'].':</strong><br />'.($open[$i] == $close[$i] ? (($open[$i] == '12:00AM') ? 'Open 24 Hours': 'Closed') : $open[$i].' - '.$close[$i]).' '.((isset($special_note[$i])) ? $special_note[$i] : '').'<br />';
		}
			$j++;
			$i = ($i+1)%7;
	}
	else{
		//Print todays date specially
		echo '<p><strong>'.$_GET['q'].'</strong><br />No Hours for this Date<br />';
		$j++;
		$i = ($i+1)%7;
	}
	
	echo '</p>';

	mysqli_close($con);
?>
