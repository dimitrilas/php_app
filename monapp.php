<?php

	//if the user click on check, the page is called again and this part is 'doing his job'
	if(isset($_GET['city']))
	{
		if($_GET['city'] == "1")
		{
			$latitude=51.51;
			$longitude=-0.13;
			$select_city="London";
			
		}
		else if($_GET['city'] == "2")
		{
			$latitude=59.325;
			$longitude=18.07;
			$select_city="Stockholm";
		}
		else
		{
			$latitude=48.86;
			$longitude=2.34;
			$select_city="Paris";
		}
		
		$opts2 = array('http' => array(
			'method'  => 'GET',
			'header' => "X-Mashape-Key: Ri4j5gX4ORmshweHbjBSUUMevXWIp1i0xRujsnjCz7wW9w5zLB")); // key for the API
		$context2  = stream_context_create($opts2);
		$result2 = file_get_contents('https://simple-weather.p.mashape.com/weather?lat='.$latitude.'&lng='.$longitude.'', false, $context2);
		
		$weather=explode(' c,', $result2);
		$weather2=explode(' at ', $weather[1]);
		$letemps="It is ".$weather[0]." degree celsius and it's".$weather2[0]." in ".$weather2[1];
		
		
		
		$opts = array('http' => array(
			'method'  => 'GET',
			'header' => "X-Mashape-Key: 87db9f8219947bdac7068c479acfccdd")); // key for the open weather map API
		$context  = stream_context_create($opts);
		//get the result of the open weather map api
		$result = file_get_contents('http://api.openweathermap.org/data/2.5/weather?q='.$select_city.'', false, $context);
		// just explode the array in order to get only the icon name for the marker
		$final=explode("icon\":\"", $result);
		$final=explode("\"}", $final[1]);
		
		// call for a static google map with a marker based on the icon previously found.
		$map="http://maps.googleapis.com/maps/api/staticmap?center=".$select_city."&zoom=12&size=400x400&maptype=roadmap&markers=icon:http://openweathermap.org/img/w/".$final[0].".png%7C".$select_city;
}

?>
<!DOCTYPE html>
<html>
  <head>
	<meta charset="UTF-8">
	<title>my php app</title>
  </head>
   <body>
	<form action="monapp.php" method="GET">
		 <select name="city">
			<option value="1" selected="selected">London</option>
			<option value="2">Stockholm</option>
			<option value="3">Paris</option>
		</select>
		<br />
		<input type="submit" value="Check"/>
	</form>
        <br/><br/>
		<div>
		<?php
			if(!empty($letemps))
			{
				echo "<p>".$letemps."</p>";
			}
			if(!empty($map))
			{
				echo "<img src=".$map."/>";
			}
		?>
		</div>
    
  </body>
</html>

