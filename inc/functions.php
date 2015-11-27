
<?php
/* PROTOTYPE PORK TRACEABILITY SYSTEM
* Copyright © 2014 UPLB.*/


require_once ('dbinfo.inc');
$fxn = new phpork_functions;
if(isset($_POST['feed'])){
	
	$feed = $_POST['feed'];
	$fxn->getFeedType($feed);
	$fxn->getFeedProdDate($feed);
}
if(isset($_POST['med'])){
	$med = $_POST['med'];
	$fxn->getMedType($med);
}

class phpork_functions {
	private function connect() {
		$link = mysqli_connect ( HOSTNAME, USERNAME, PASSWORD, DATABASE ) or die ( 'Could not connect: ' . mysqli_error () );
		mysqli_select_db ( $link, DATABASE ) or die ( 'Could not select database' . mysql_error () );
		return $link;
	}
	
	public function ddl_mainlocation(){
		$link = $this->connect();
		$query = "SELECT loc_name,
					loc_id
				FROM location";
		$result = mysqli_query($link,$query) or die ( mysqli_error ( $link ) );
		while($row = mysqli_fetch_row($result)){
			echo "<option value = $row[1] >$row[0]</option>";
		}
	}
	public function ddl_house($loc) {
		$link = $this->connect ();
		$hquery = "SELECT house_id,
						house_no, 
						house_name 
					FROM house
					WHERE loc_id = ".$loc."";
		$hresult = mysqli_query ( $link, $hquery );
		while ( $row = mysqli_fetch_row ( $hresult ) ) {
			echo "<option value = '$row[0]'> $row[1] : $row[2] </option>";
		}
	}
	public function ddl_pig($house, $pen) {
		$link = $this->connect ();
		$pquery = "SELECT p.pig_id,
						rt.label 
					FROM pig p 
					INNER JOIN rfid_tags rt ON 
						rt.pig_id = p.pig_id 
					WHERE p.pen_id = '".$pen."'";
		$presult = mysqli_query ( $link, $pquery );
		while ( $row = mysqli_fetch_row ( $presult ) ) {
			echo "<option value = '$row[0]'> Pig $row[1]</option>";
		}
	}
	public function ddl_pen($house) {
		$link = $this->connect ();
		$pquery = "SELECT pen_no,
						pen_id 
					FROM pen 
					WHERE house_id = '".$house."'";
		$presult = mysqli_query ( $link, $pquery );
		while ( $row = mysqli_fetch_row ( $presult ) ) {
			echo "<option value = '$row[1]'> Pen $row[0] </option>";
		}
	}

	public function ddl_HousePen($loc) {
		$link = $this->connect ();
		$search = "SELECT a.pen_id, 
						a.pen_no, 
						b.house_no, 
						b.function 
				FROM pen a 
				INNER JOIN house b ON 
					a.house_id = b.house_id
				INNER JOIN location l ON
					l.loc_id = b.loc_id
				WHERE l.loc_name = '".$loc."'";
		$resultq = mysqli_query ( $link, $search );
		while ( $row = mysqli_fetch_row ( $resultq ) ) {
			$pen_id = $row [0];
			$pen_no = $row [1];
			$house_no = $row [2];
			$function = $row [3];
			echo "<option value = '$pen_id'> House $house_no : $function : Pen $pen_no </option>";
		}
	}
	
	
	
	
	
	public function getNextPigID() {
		$link = $this->connect ();
		$search = "SELECT max(p.pig_id) 
					FROM pig p ";
		$resultq = mysqli_query ( $link, $search );
		$row2 = mysqli_fetch_row ( $resultq );
		return $row2 [0] + 1;
	}

	public function getLastWeight($pig) {
		$link = $this->connect ();
		$query = "SELECT WEEK(record_date)
				FROM weight_record
				WHERE pig_id = '".$pig."'
				ORDER BY record_date DESC LIMIT 1";
		$result = mysqli_query ( $link, $query );
		$row = mysqli_fetch_row ( $result );
		$week = $row [0];
		return $week;
	}
	public function getFirstWeight($pig) {
		$link = $this->connect ();
		$query = "SELECT WEEK(record_date) 
				FROM weight_record 
				WHERE pig_id = '".$pig."' 
				ORDER BY record_date ASC LIMIT 1";
		$result = mysqli_query ( $link, $query );
		$row = mysqli_fetch_row ( $result );
		$week = $row [0];
		return $week;
	}
	public function getWeekDateWeight($pig, $first) {
		$link = $this->connect ();
		$query = "SELECT WEEK(record_date) 
				FROM weight_record 
				WHERE pig_id = '".$pig."'
				ORDER BY record_date ASC";
		$result = mysqli_query ( $link, $query );
		$a = array ();
		$ds = "";
		while ( $row = mysqli_fetch_row ( $result ) ) {
			$week = $row [0];
			$d = ($week - $first) + 1;
			if ($ds == "") {
				$ds = $d;
			} else {
				$ds = $ds . "%%%" . $d;
			}
		}
		print "<input type=hidden id='ds' value='" . $ds . "' />";
	}
	public function getWeeksNum($pig, $first) {
		$link = $this->connect ();
		$query = "SELECT record_date 
					FROM weight_record 
					WHERE pig_id = '".$pig."' 
					ORDER BY record_date ASC";
		$result = mysqli_query ( $link, $query );
		$a = array ();
		$d = "";
		while ( $row = mysqli_fetch_row ( $result ) ) {
			$ddate = $row [0];
			$date = new DateTime ( $ddate );
			$week = $date->format ( "W" );
			if ($d == "") {
				$d = ($week - $first) + 1;
			} else {
				$d = $d . "%%%" . (($week - $first) + 1);
			}
		}
		return $d;
	}
	public function getPigWeight($pig) {
		$link = $this->connect ();
		$query = "SELECT record_date, 
						max(weight), 
						WEEK(record_date) 
				FROM weight_record 
				WHERE pig_id = '". $pig." ' 
				GROUP BY WEEK(record_date) 
				ORDER BY record_date ASC";
		$result = mysqli_query ( $link, $query );
		$a = array ();
		$dates = "";
		$weeks = "";
		$weights = "";
		while ( $row = mysqli_fetch_row ( $result ) ) {
			$ddate = $row [0];
			$wt = $row [1];
			$weekno = $row [2];
			if ($dates == "") {
				$dates = $ddate;
				$weeks = $weekno;
				$weights = $wt;
			} else {
				$dates = $dates . "%%%" . $ddate;
				$weeks = $weeks . "%%%" . $weekno;
				$weights = $weights . "%%%" . $wt;
			}
		}
		print "<input type=hidden id='dts' value='" . $dates . "' />";
		print "<input type=hidden id='wks' value='" . $weeks . "' />";
		print "<input type=hidden id='wts' value='" . $weights . "' />";
	}
	public function getWeekDateMvmnt($pig, $first) {
		$link = $this->connect ();
		$query = "SELECT WEEK(date_moved) 
				from movement 
				where pig_id = '$pig' 
				ORDER BY date_moved ASC";
		$result = mysqli_query ( $link, $query );
		$ds = "";
		while ( $row = mysqli_fetch_row ( $result ) ) {
			$week = $row [0];
			$d = ($week - $first) + 1;
			if ($ds == "") {
				$ds = $d;
			} else {
				$ds = $ds . "%%%" . $d;
			}
		}
		print "<input type=hidden id='dsMvmnt' value='" . $ds . "' />";
	}
	public function getFirstMovement($pig) {
		$link = $this->connect ();
		$query = "SELECT Week(date_moved) 
				from movement 
				where pig_id = '$pig' 
				ORDER BY date_moved ASC LIMIT 1";
		$result = mysqli_query ( $link, $query );
		$row = mysqli_fetch_row ( $result );
		$week = $row [0];
		return $week;
	}
	public function getLastMovement($pig) {
		$link = $this->connect ();
		$query = "SELECT Week(date_moved) 
				from movement 
				where pig_id = '$pig' 
				ORDER BY date_moved DESC LIMIT 1";
		$result = mysqli_query ( $link, $query );
		$row = mysqli_fetch_row ( $result );
		$week = $row [0];
		return $week;
	}
	public function getPigMvmnt($pig) {
		$link = $this->connect ();
		$query = "SELECT m.date_moved, 
						m.pen_id, 
						p.pen_no, 
						h.house_no, 
						h.house_name 
					from movement m 
					INNER JOIN pen p ON 
						p.pen_id = m.pen_id 
					INNER JOIN house h ON 
						h.house_id = p.house_id 
					where m.pig_id = '$pig' 
					ORDER BY date_moved ASC";
		$result = mysqli_query ( $link, $query );
		
		$housepen = "";
		while ( $row = mysqli_fetch_row ( $result ) ) {
			if ($housepen == "") {
				$housepen = "H" . $row [3] . "P" . $row [2];
			} else {
				$housepen = $housepen . "%%%" . "H" . $row [3] . "P" . $row [2];
			}
		}
		print "<input type='hidden' id='housepen' value='" . $housepen . "' >";
	}
	public function getFeedProdDate($var){
		$link = $this->connect();
		$query = "SELECT prod_date
					FROM 	feeds
					WHERE feed_id = '".$var."'";
		$result = mysqli_query($link,$query);
		$row = mysqli_fetch_row($result);
		$date = date_create($row[0]);
		$d = $date->format('F j,Y');
		echo  "<input type = 'text' class = 'form-control' name = 'birth' disabled title='Click to input the date of birth of the pig.' value='$d'>"; 
	}
	public function getFeedType($var){
		$link = $this->connect();
		$query = " SELECT DISTINCT feed_type
				FROM feeds
				WHERE feed_id = '".$var."'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);

			echo "<input type = 'text' class = 'form-control' name = 'feedtypeText' disabled  value='$row[0]'>";
		
	}
	public function getMedType($var){
		$link = $this->connect();
		$query = " SELECT DISTINCT med_type
				FROM medication
				WHERE med_id = '".$var."'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);

			echo "<input type = 'text' class = 'form-control' name = 'medtypeText' disabled  value='$row[0]'>";
		
	}
}