<?php
require_once('Helpers/Modal.php');

class Person extends Modal{

	
	private $columns = array(
		array("column" => "id", "label"=>"#ID", "width"=>40),
		array("column" => "first_name", "label"=>"PRENOM"),
		array("column" => "last_name", "label"=>"NOM"),
		array("column" => "person_profile", "label"=>"PROFILE"),
		array("column" => "telephone", "label"=>"TELEPHONE"),
		array("column" => "status", "label"=>"STATUS", "width"=>80)
	);
	
// construct
	public function __construct(){
		try{
			parent::__construct("config");
			$this->setTableName("person");
		}catch(Exception $e){
			$this->err->save("person -> Constructeur",$e->getMessage());
		}
	}	
	
	
	public function getColumns(){
		
		if ( isset($this->columns) ){
			return $this->columns;
		}else{
			$columns = array();
			//var_dump($this->getColumnsName("client"));
			foreach($this->getColumnsName("person") as $k=>$v){
				//var_dump($v["Field"]);
				array_push($columns, array("column" => $v["Field"], "label" => $v["Field"]) );
			}
			return $columns;
		}
		
	}

	public function checkLogin($login_password = null){

		$data = $this->find(null,array("conditions AND"=>array("login=" => $login_password[0], "pwd="=>$login_password[1])),"v_person");
		if (count($data)>0){
			return $data;			
		}else{
			return null;
		}
		
		
	}
	
	public function saveLogin($idPerson){
		
	}
	
	public function getPersonActivities($conditions, $as="table"){
		$data = $this->find("", $conditions, "v_person_activity");

		$host = $_SESSION["HOST"];
		if($as === "table"){
				
			$table = "<table class='table'>";
			$table .= "	<tbody>";
			
			$template = '<tr style="padding: 0!important">
							<td style="padding: 0!important">
								<div class="user-activities">
									<div class="user-activities-item">
										<div class="user">
											<img src="http://' . $host .'templates/default/images/user.png">
											<div class="name">{{user}}</div>
										</div>
										<div class="detail">
											{{action}}
										</div>	
										<div class="time">
											{{time}}
										</div>
									</div>
								</div>

							</td>
						</tr>';
			
			$replace_this = array("{{user}}", "{{action}}", "{{time}}");
			
			foreach($data as $k=>$v){
				$_date = explode(" ", $v["created"]);
				$replace_by = array($v["first_name"], $v["activity_message"], "<i class='far fa-calendar-alt'></i> ".$_date[0]." <br><i class='far fa-clock'></i>".$_date[1]);
				
				$table .= str_replace($replace_this, $replace_by, $template);
			}
			$table .= "	</tbody>";
			$table .= "</table>";
			
			return $table;
		}else{
			return $data;
		}
		
	}
	
}
$person = new Person;

