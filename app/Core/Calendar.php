<?php
require_once('Helpers/Modal.php');

class Calendar extends Modal{

	
	
	private $tableName = "Contrat";
	
// construct
	public function __construct(){
		try{
			parent::__construct();
			$this->setTableName(strtolower($this->tableName));
		}catch(Exception $e){
			die($e->getMessage());
		}
	}	
	
	public function days_in_month($month, $year) { 

	return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
		
	} 
	
	public function drawCalendar($month,$year, $args=null){
		
		$calendar = "Error Creating Calendar ...!";
		$counter = $args["options"]["counter"];
		
		if(isset($args["options"]["style"]) && $args["options"]["style"] === "vehicule"){
			
			$counter = isset($args["options"]["counter"])? $args["options"]["counter"]:0;
			$days_in_selected_month = $this->days_in_month(($month + $counter), $year);
			
			$_month = (($month + $counter)>9)? ($month + $counter): "0". ($month + $counter);
			$first_day_date = $year . "-" . $_month . "-01";
			$last_day_date = $year . "-" . $_month . "-" . $days_in_selected_month;
			
			$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';
			$calendar.= '<tr class="calendar-row">';
			$row = array();
			for($i=0; $i<$days_in_selected_month; $i++){
				$calendar.= '<td style="min-width:40px; font-size:10px" class="calendar-day-head"><span class="days">'.($i+1).'</span></td>';
			}
			$calendar.= '</tr>';
			
			$value="";
			$span = 1;
			//var_dump($args["data"]);
			foreach($args["data"] as $k=>$row){
				$value="";
				$span = 1;
				$i = 0;
				//var_dump($row);
				foreach($row as $day=>$content){
					$i++;
					if($value === $content){
						
						if($i === count($row)){
							$extract = explode(";",explode("|",$value)[0]);
							$calendar.= '<td style="border-right:1px solid #ccc; max-width:40px; padding:4px 0px" colspan='.$span.'><div class="label label-green" style="padding:3px 5px; border-right:5px solid red; border-left:5px solid yellow; font-size:10px; background-color:' . $extract[1] . '">' . $extract[0] . '</div></td>';
						}else{
							$span += 1;
							$value = $content;
						}
					}else{
						if($day === 1){
							$span = 1;
							$value = $content;
						}else{
							$extract = explode(";",explode("|",$value)[0]);
								//var_dump($extract);
							if( $extract[0] === "empty"){
								$calendar.= '<td style="border-right:1px solid #ccc; max-width:40px; padding:4px 0px" colspan='.$span.'><div class="label label-green" style="padding:3px 5px; font-size:10px; background-color:' . $extract[1] . '">vide</div></td>';
							}else{
								$calendar.= '<td style="border-right:1px solid #ccc; max-width:40px; padding:4px 0px" colspan='.$span.'><div class="label label-green" style="padding:3px 5px; font-size:10px; border-right:5px solid red; border-left:5px solid yellow; ">' . $extract[0] . '</div></td>';
							}
							
							$span = 1;
							$value = $content;								
						}
					}
					
				}
				$calendar.= '</tr>';
			}
			//var_dump($row);
			$calendar.= '</table>';
			
		}elseif(isset($args["options"]["style"]) && $args["options"]["style"] === "month"){
			/* draw table */
			$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

			/* table headings */
			$headings = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
			$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';
			$month += $counter;
			/* days and weeks vars now ... */
			$running_day = date('w',mktime(0,0,0,$month,1,$year)); 		// order of first day in the week
			$days_in_month = date('t',mktime(0,0,0,$month,1,$year)); 	// number of days in given month
			$days_in_this_week = 1;
			$day_counter = 0;
			$dates_array = array();

			/* row for week one */
			$calendar.= '<tr class="calendar-row">';

			for($x = 0; $x < $running_day; $x++):
				$calendar.= '<td class="calendar-day-np"> </td>';
				$days_in_this_week++;
			endfor;

			for($list_day = 1; $list_day <= $days_in_month; $list_day++):
				$calendar.= '<td class="calendar-day">';
				$day = ($list_day<10)? "0" . $list_day: $list_day;
				$_month = ($month>9)? $month: "0". $month;
				$date = $year . "-" . $_month . "-" . $day;
			
				$calendar.= '<div class="day-number">'.$list_day.'</div>';
				$i	= 	0;
				$j	=	0;
				$complexes = array();
			
				foreach($args["data"] as $k=>$v){

					if( $v["date_debut"] === $date || $v["date_fin"] === $date){
						if(!in_array($v["vehicule"], $complexes)){
							array_push($complexes,$v["vehicule"]);
							if($i<6){
								$calendar.= "<div class='label label-green' style='padding:2px 3px; font-size:10px;background-color:" .  $v["color"] . "'>" .  $v["vehicule"] . "</div>";
							}else{
								$j++;
							}
							$i++;							
						}
						

					}else{
						/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
					//$calendar.= str_repeat('<p></p>',1);
					}				
				}

				if($j>0){
					$calendar.= "<div class='label label-default' style='padding:2px; font-size:10px;'>" .  $j . " Autres</div>";
				}
			
				$calendar.= '</td>';
				if($running_day == 6):
					$calendar.= '</tr>';
					if(($day_counter+1) != $days_in_month):
						$calendar.= '<tr class="calendar-row">';
					endif;
					$running_day = -1;
					$days_in_this_week = 0;
				endif;
				$days_in_this_week++; $running_day++; $day_counter++;
			endfor;

			/* finish the rest of the days in the week */
			if($days_in_this_week < 8):
				for($x = 1; $x <= (8 - $days_in_this_week); $x++):
					$calendar.= '<td class="calendar-day-np"> </td>';
				endfor;
			endif;

			$calendar.= '</tr>';
			$calendar.= '</table>';	
			
		}

		return $calendar;
	}
	
}

$calendar = new Calendar;