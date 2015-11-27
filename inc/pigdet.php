
<?php
/* PROTOTYPE PORK TRACEABILITY SYSTEM
* Copyright © 2014 UPLB.*/


require_once ('dbinfo.inc');
class pigdet_functions {
	private function connect() {
		$link = mysqli_connect ( HOSTNAME, USERNAME, PASSWORD, DATABASE ) or die ( 'Could not connect: ' . mysqli_error () );
		mysqli_select_db ( $link, DATABASE ) or die ( 'Could not select database' . mysql_error () );
		return $link;
	}
	public function getLocation($pigid){
		$link = $this->connect();
		$query = "SELECT l.loc_name
				FROM location l
				INNER JOIN house h  ON 
					h.loc_id = l.loc_id
				INNER JOIN pen p ON 
					p.house_id = h.house_id
				INNER JOIN pig pi ON 
					pi.pen_id = p.pen_id
				WHERE pi.pig_id = '".$pigid."'";
		$result = mysqli_query($link,$query);
		$row = mysqli_fetch_row($result);
		return $row[0];
	}
	public function getLabel($pigid){
		$link = $this->connect();
		$query = "SELECT label
				FROM rfid_tags
				WHERE pig_id = '".$pigid."'";
		$result = mysqli_query($link,$query);
		$row = mysqli_fetch_row($result);
		return $row[0];
	}
	public function getRFID($pigid){
		$link = $this->connect();
		$query = "SELECT tag_rfid
				FROM rfid_tags 
				WHERE pig_id = '".$pigid."'";
		$result = mysqli_query($link,$query);
		$row = mysqli_fetch_row($result);
		return $row[0];
	}
	public function getGender($pigid){
		$link = $this->connect();
		$query = "SELECT gender
				FROM pig
				WHERE pig_id = '".$pigid."'";
		$result = mysqli_query($link,$query);
		$row = mysqli_fetch_row($result);
		return $row[0];
	}
	public function getBirthDate($pigid){
		$link = $this->connect();

		$query = "SELECT birth_date
				FROM pig
				WHERE pig_id = '".$pigid."'";
		$result = mysqli_query($link,$query);
		$row = mysqli_fetch_row($result);
		return $row[0];
		
	}
	public function getAge($pigid){
		$link = $this->connect();

		$query = "SELECT birth_date
				FROM pig
				WHERE pig_id = '".$pigid."'";
		$result = mysqli_query($link,$query);
		$row = mysqli_fetch_row($result);
		$from = new DateTime($row[0]);
		$to   = new DateTime('today');
		if($from->diff($to)->y == 0){
			$diff = $from->diff(new DateTime());
			$months = $diff->format('%m') + 12 * $diff->format('%y');
			return $months." months";
		}else{
			return $from->diff($to)->y." years old";	
		}
		
	}
	public function getBreed($pigid){
		$link = $this->connect();

		$query = "SELECT pb.breed_name
				FROM pig p
				INNER JOIN pig_breeds pb ON
					pb.breed_id = p.breed_id
				WHERE p.pig_id = '".$pigid."'";
		$result = mysqli_query($link,$query);
		$row = mysqli_fetch_row($result);
		return $row[0];
		
	}
	public function getWeight($pigid){
		$link = $this->connect();

		$query = "SELECT max(record_date)
				FROM weight_record
				WHERE pig_id = '".$pigid."'";
		$result = mysqli_query($link,$query);
		$row = mysqli_fetch_row($result);
		$query2 = "SELECT weight
				FROM weight_record
				WHERE pig_id = '".$pigid."'
				AND record_date = '".$row[0]."'";
		$result2 = mysqli_query($link,$query2);
		$row2 = mysqli_fetch_row($result2);
		return $row2[0];
	}
	public function getBoar($pigid){
		$link = $this->connect();

		$query = "SELECT boar_id
				FROM pig
				WHERE pig_id = '".$pigid."'";
		$result = mysqli_query($link,$query);
		$row = mysqli_fetch_row($result);
		$query2 = "SELECT rt.label 
					FROM rfid_tags rt
					INNER JOIN pig p ON
					p.pig_id = rt.pig_id
					WHERE p.pig_id = '".$row[0]."'";
		$result2 = mysqli_query($link,$query2);
		$row2 = mysqli_fetch_row($result2);
		return $row2[0];
	}
	public function getSow($pigid){
		$link = $this->connect();

		$query = "SELECT sow_id
				FROM pig
				WHERE pig_id = '".$pigid."'";
		$result = mysqli_query($link,$query);
		$row = mysqli_fetch_row($result);
		$query2 = "SELECT rt.label 
					FROM rfid_tags rt
					INNER JOIN pig p ON
					p.pig_id = rt.pig_id
					WHERE p.pig_id = '".$row[0]."'";
		$result2 = mysqli_query($link,$query2);
		$row2 = mysqli_fetch_row($result2);
		return $row2[0];
	}
	public function getFosterSow($pigid){  //foster
		$link = $this->connect();

		$query = "SELECT boar_id
				FROM pig
				WHERE pig_id = '".$pigid."'";
		$result = mysqli_query($link,$query);
		$row = mysqli_fetch_row($result);
		return $row[0];
	}
	public function getCurrentHouse($pigid) {
		$link = $this->connect ();
		$query = "SELECT h.house_no
				FROM pig pi 
				INNER JOIN pen p ON 
					p.pen_id = pi.pen_id
				INNER JOIN house h ON
					h.house_id = p.house_id
				WHERE pi.pig_id = '".$pigid."'";
		$result = mysqli_query ( $link, $query );
		$row2 = mysqli_fetch_row ( $result );
		echo $row2 [0];
	}
	public function getCurrentPen($pigid) {
		$link = $this->connect ();
		$query = "SELECT p.pen_no
				FROM pig pi 
				INNER JOIN pen p ON 
					p.pen_id = pi.pen_id
				WHERE pi.pig_id = '".$pigid."'";
		$result = mysqli_query ( $link, $query );
		$row2 = mysqli_fetch_row ( $result );
		echo $row2 [0];
	}

	public function getLastFeed($pigid) {
		$link = $this->connect ();
		$query = "SELECT f.feed_name,
						f.feed_type,
						max(ft.date_given)
				FROM feeds f
				INNER JOIN feed_transaction ft ON 
					ft.feed_id = f.feed_id
				WHERE ft.pig_id = '".$pigid."'";
		$result = mysqli_query ( $link, $query );
		$row2 = mysqli_fetch_row ( $result );
		$last = $row2[0] . "-". $row2[1];
		return $last;
	}
	public function getLastMed($pigid) {
		$link = $this->connect ();
		$query = "SELECT m.med_name,
						m.med_type,
						max(mr.date_given)
				FROM medication m
				INNER JOIN med_record mr ON 
					mr.med_id = m.med_id
				WHERE mr.pig_id = '".$pigid."'";
		$result = mysqli_query ( $link, $query );
		$row2 = mysqli_fetch_row ( $result );
		$last = $row2[0] . "-". $row2[1];
		return $last;
	}
	public function ddl_locations($pig) {
		$link = $this->connect ();
		$query = "SELECT m.date_moved, 
						m.time_moved, 
						m.pen_id 
				FROM movement m 
				WHERE m.pig_id = '$pig'
				ORDER BY m.date_moved desc, 
						m.time_moved desc";
		$result = mysqli_query ( $link, $query );
		while ( $row = mysqli_fetch_row ( $result ) ) {
			echo "<tr><td>$row[0]</td> <td>$row[1]</td> <td>Pen $row[2]</td></tr> ";
		}
	}
	public function ddl_locations_edit($pig) {
		$link = $this->connect ();
		$query = "SELECT m.date_moved, 
						m.time_moved, 
						m.pen_id 
				FROM movement m 
				WHERE m.pig_id = '$pig'
				ORDER BY m.date_moved desc, 
						m.time_moved desc";
		$result = mysqli_query ( $link, $query );
		while ( $row = mysqli_fetch_row ( $result ) ) {
			echo "<tr><td><input type='date' value='$row[0]' name='d_moved'/></td> <td><input type='text' value='$row[1]' size='8' name='t_moved'/></td> <td>Pen <input type='text' value='$row[2]' size = '4' name='l_moved'/></td></tr> ";
		}
	}
	public function ddl_feedRecordEdit($pig){
		$link = $this->connect();
		$query = "SELECT f.feed_name,
						f.feed_type,
						f.prod_date,
						ft.ft_id
				FROM feeds f
				INNER JOIN feed_transaction ft ON
					ft.feed_id = f.feed_id
				WHERE ft.pig_id = '".$pig."'";
		$result = mysqli_query($link,$query);
		while($row = mysqli_fetch_row($result)){
			echo "<tr>
					<td>$row[0]</td>
					<td>$row[1]</td>
					<td>$row[2]</td>
					<td><select id='ed_feeds".$row[3]."'>".$this->ddl_feeds()."</select></td>
					<td><button type=button onclick='updateFR(".$row[3].");'>Edit</button></td>
				</tr>";
		}
	}
	public function ddl_medRecordEdit($pig){
		$link = $this->connect();
		$query = "SELECT m.med_name,
						m.med_type,
						mr.mr_id
				FROM medication m 
				INNER JOIN med_record mr ON
					mr.med_id = m.med_id
				WHERE mr.pig_id = '".$pig."'";
		$result = mysqli_query($link,$query);
		while($row = mysqli_fetch_row($result)){
			echo "<tr>
					<td>$row[0]</td>
					<td>$row[1]</td>
					<td><select id='ed_medication".$row[2]."'>".$this->ddl_medications()."</select></td>
					<td><button type=button onclick='updateMR(".$row[2].");'>Edit</button></td>
				</tr>";
		}
	}
	public function ddl_feedRecord($pig){
		$link = $this->connect();
		$query = "SELECT f.feed_name,
						f.feed_type,
						f.prod_date,
						ft.ft_id
				FROM feeds f
				INNER JOIN feed_transaction ft ON
					ft.feed_id = f.feed_id
				WHERE ft.pig_id = '".$pig."'";
		$result = mysqli_query($link,$query);
		while($row = mysqli_fetch_row($result)){
			echo "<tr>
					<td>$row[0]</td>
					<td>$row[1]</td>
					<td>$row[2]</td>
				</tr>";
		}
	}
	public function ddl_medRecord($pig){
		$link = $this->connect();
		$query = "SELECT m.med_name,
						m.med_type,
						mr.mr_id
				FROM medication m 
				INNER JOIN med_record mr ON
					mr.med_id = m.med_id
				WHERE mr.pig_id = '".$pig."'";
		$result = mysqli_query($link,$query);
		while($row = mysqli_fetch_row($result)){
			echo "<tr>
					<td>$row[0]</td>
					<td>$row[1]</td>
				</tr>";
		}
	}
	public function ddl_pigpen($pig,$pen,$house,$location,$pen){
		$link = $this->connect();
		$query = "SELECT rt.label,
						p.pig_id
				FROM  rfid_tags rt
				INNER JOIN pig p ON
					p.pig_id = rt.pig_id
				INNER JOIN pen pe ON
					pe.pen_id = p.pen_id
				INNER JOIN house h ON
					h.house_id = pe.house_id
				WHERE p.pen_id  = '".$pen."'
				AND p.pig_id != $pig 
				AND h.house_id = $house";
		$result = mysqli_query($link,$query);
		$info = "info";
		while($row = mysqli_fetch_row($result)){
			echo "<form method='get' ><tr>
					<td>$row[0] <input type='hidden' name = 'pig' class='pig' value='$row[1]'/><br>
					<input type='hidden' name = 'pen' class='pen' value='$pen'/><br>
					<input type='hidden' name = 'location' class='location' value='$location'/><br>
					<input type='hidden' name = 'house' class='house' value='$house'/></td>
					<td><input type='submit' class='infoBtn' value='Info'  onmouseover='popinfo()' onmouseout='hideprompt()'></td>
				</tr>
				</form>";
		}
	}
	public function ddl_medications(){
		$link = $this->connect();

		$query = "SELECT med_id,
						med_name,
						med_type
				FROM medication";
		$result = mysqli_query($link,$query);
		$ret = "";
		while($row = mysqli_fetch_row($result)){
			$ret = $ret. "<option value='".$row[0]."'>".$row[1]."</option>";
		}
		return $ret;
	}
	public function ddl_feeds(){
		$link = $this->connect();

		$query = "SELECT feed_id,
						feed_name,
						feed_type
				FROM feeds";
		$result = mysqli_query($link,$query);
		$ret = "";
		while($row = mysqli_fetch_row($result)){
			$ret = $ret. "<option value='".$row[0]."'>".$row[1]."</option>";
		}
		return $ret;
	}
	public function getUserEdited($pigid){
		$link = $this->connect();

		$query = "SELECT user
				FROM pig
				WHERE pig_id = '".$pigid."'";
		$result = mysqli_query($link,$query);
		$row = mysqli_fetch_row($result);
		return $row[0];
	}

}