<!DOCTYPE html>
<html>
<head>
	<title>Reporting Mail</title>
</head>
<body>

<div class="container" style="padding: 30px">

<label>Dear Office in-charge </label><br><br>

<label>We will like to report few suspicious cases that recently happen in off campus UNIMAS. The report were descriped below.</label>
<br><br>
	@foreach($content as $item)
	<?php $no = 1  ?>
		<label style="font-size: 14pt"> <strong> Case {{$no++}} </strong> </label>
			<br>
		<label style="font-size: 14pt"> Title: <br> {{$item->report->report_Title}} </label>
			<br><br>
		<label style="font-size: 12pt"> Description: <br> {{$item->report->report_Description}}</label>
			<br><br>
		<label style="font-size: 12pt"> {{$item->report->location->location_name}}</label>
			<br><br>
		<img class="img-thumbnail" style="height: auto; width: 20vw;" alt="{{$item->report->report_Title}}" src="{{$item->report->image}}">
			<br><br>

	@endforeach

	<br>
	<label style="font-size: 10pt">We are looking forward for your attention. </label>

	<br><br><br>

	<label style="font-size: 10pt">Thank you. </label>
	<br>
	<label style="font-size: 10pt">From: UOCS-Safe (UNIMAS Off-Campus Student Safe) </label>

	
</div>


</body>
</html>