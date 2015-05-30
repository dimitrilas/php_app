<?php
	if(!empty($_POST[city]))
	{
		double latitude, longitude;
		string select_city="";
		if($_POST[city] == 1)
		{
			latitude=51.51;
			longitude=-0.13;
			select_city="London";
		}
		else if($_POST[city] == 2)
		{
			latitude=59.325;
			longitude=18.07;
			select_city="Stockholm";
		}
		else
		{
			latitude=48.86;
			longitude=2.34;
			select_city="Paris";
		}
		
		$req2 = new HttpRequest('https://simple-weather.p.mashape.com/weather?lat='+$latitude+'&lng='+$longitude+'', HttpRequest::METH_GET);
		$req2->setHeaders(array('X-Mashape-Key'  => 'Ri4j5gX4ORmshweHbjBSUUMevXWIp1i0xRujsnjCz7wW9w5zLB'));
		try {
			$req2->send();
			if ($req2->getResponseCode() == 200) {
				echo $req2->getResponseBody();
				$resp2=$req2->getResponseBody();
			}
		} catch (HttpException $ex) {
			echo $ex;
		}
		
		
		
		$req = new HttpRequest('http://api.openweathermap.org/data/2.5/weather?q='+$select_city+'', HttpRequest::METH_GET);
		$req->setHeaders(array('X-Mashape-Key'  => '87db9f8219947bdac7068c479acfccdd'));
		try {
			$req->send();
			if ($req->getResponseCode() == 200) {
				echo $req->getResponseBody();
				$resp=$req->getResponseBody();
			}
		} catch (HttpException $ex) {
			echo $ex;
		}
		
		$map = new GMapsStaticMap();
		$map->set_center($latitude, $longitude);
		$map->set_size(600, 400);
		$map->set_zoom(12);
		//$map->add_markers('http://openweathermap.org/img/w/'+$resp['weather'][0].icon+'.png%7C'+$select_city);
		
}

?>

<html>
  <body>
    <form action="monapp.php" method="post">
     <select id="city">
            <option value="1" selected="selected">London</option>
            <option value="2">Stockholm</option>
            <option value="3">Paris</option>
        </select>
		<br />
		<input type="submit" value="Check"/>
        <br/><br/>
        <div id="weather_in_city"></div><br/><br/>
		<div><img src="<?php if(!empty($map)) {echo $map->get_url();}?>"/></div>
    </form>
  </body>
</html>

