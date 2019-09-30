<?PHP
$query = $_GET["q"];
$id = $_GET["id"];
$format = $_GET["fmt"];
$civicrm_root = '/var/www/drupal/web/sites/all/modules/civicrm';
require_once $civicrm_root . '/civicrm.config.php';
require_once $civicrm_root . '/api/api.php';
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$res = Array();
switch($query){
	case "petition":
		if($id != ""){
		$result = civicrm_api3('Activity', 'get', [
			'sequential' => 1,
			'return' => ["id"],
			'activity_type_id' => "Petition",
			'options' => ['limit' => 0],
			'source_record_id' => $id,
		]);
		$res["content"] = $result['count'];
		}
		break;
	default:
		break;
}

if(array_key_exists("content", $res)){
	$res["status"] = 0;
}else{
	$res["status"] = 1;
	$res["content"] = "Query not handled";
}

if ($format == "json"){
	header('Content-Type: application/json');
	echo(json_encode($res));
	return true;
}else{
	header('Content-Type: text/html');
}

?>
<html>
<header>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<style>

.counter{
	
	display:block;
        border-radius: 5px;
	background: #aa0000;
	text-align: center;
	font-weight: bold;
	color: #ffffff;

	width:20%;
	margin: auto;
	padding:10px;
}
</style>
</header>

<body>
	<label class="counter">
		<i class="material-icons">people</i>
		<?PHP echo $res["content"];?>
	</label>
</body>

</html>
