<?php
use App\Models\User;
use App\Models\PostLocation;
use function GuzzleHttp\json_encode;
use App\Models\LoginHistory;
?>

@extends('admin.layouts.main')
@section('title', 'Dashboard - Admin')
@section('content')
<div class="breadcrumbs">
	<div class="col-sm-4">
		<div class="page-header float-left">
			<div class="page-title">
				<h1>Dashboard</h1>
			</div>
		</div>
	</div>
</div>
<div class="row mt-3">	
		<div class="col-sm-6 col-lg-3">
		<a href="{{ URL::to('admin/users') }}">
			<div class="card text-white bg-flat-color-3 bg-black cmnht">
				<div class="card-body pb-0">
					<div class="row">
						<div class="col">
							<h4 class="mb-0">
        						<strong>                              
                                {{ $count }}
                                </strong>
        					</h4>
							<p class="text-light">All Users</p>
						</div>
					  	<div class="col d-flex justify-content-end">
					   		<div class="icon-wrap">
					    		<i class="fa fa-users"></i>
					   		</div>
					  	</div>
					</div>
				</div>
				<div class="chart-wrapper px-0" style="height: 50px;"></div>
			</div>
			</a>
		</div>		
		<div class="col-sm-6 col-lg-3">
		<a href="{{ URL::to('admin/users') }}">
			<div class="card text-white bg-flat-color-3 bg-blue cmnht">
				<div class="card-body pb-0">
					<div class="row">
						<div class="col">
							<h4 class="mb-0">
        						<strong>                           
                                {{ $activeUser }}
                                </strong>
        					</h4>
							<p class="text-light">Active Users</p>
						</div>
					  	<div class="col d-flex justify-content-end">
					   		<div class="icon-wrap">
					    		<i class="fa fa-user-plus"></i>
					   		</div>
					  	</div>
					</div>
				</div>
				<div class="chart-wrapper px-0" style="height: 50px;"></div>
			</div>
			</a>
		</div>		
		<div class="col-sm-6 col-lg-3">
		<a href="{{ URL::to('admin/users') }}">
			<div class="card text-white bg-flat-color-3 bg-orange cmnht">
				<div class="card-body pb-0">
					<div class="row">
						<div class="col">
							<h4 class="mb-0">
        						<strong>                            
                                {{ $inactiveUser }}
                                </strong>
        					</h4>
							<p class="text-light">Inactive Users</p>
						</div>
					  	<div class="col d-flex justify-content-end">
					   		<div class="icon-wrap">
					    		<i class="fa fa-user"></i>
					   		</div>
					  	</div>
					</div>
				</div>
				<div class="chart-wrapper px-0" style="height: 50px;"></div>
			</div>
			</a>
		</div>	
		<div class="col-sm-6 col-lg-3">
		<a href="{{ URL::to('admin/login-history') }}">
			<div class="card text-white bg-flat-color-3 bg-blue cmnht">
				<div class="card-body pb-0">
					<div class="row">
						<div class="col">
							<h4 class="mb-0">
        						<strong>
                                {{ $countlogin }}
                                </strong>
        					</h4>
							<p class="text-light">Login History</p>
						</div>
					  	<div class="col d-flex justify-content-end">
					   		<div class="icon-wrap">
					    		<i class="fa fa-history"></i>
					   		</div>
					  	</div>
					</div>
				</div>
				<div class="chart-wrapper px-0" style="height: 50px;"></div>
			</div>
			</a>
		</div>		
		<div class="col-sm-6 col-lg-3">
		<a href="{{ URL::to('admin/travel-record/') }}">
			<div class="card text-white bg-flat-color-3 bg-orange cmnht">
				<div class="card-body pb-0">
					<div class="row">
						<div class="col">
							<h4 class="mb-0">
        						<strong>
                                {{ $countpost }}
                                </strong>
        					</h4>
							<p class="text-light">Total Published Experiences</p>
						</div>
					  	<div class="col d-flex justify-content-end">
					   		<div class="icon-wrap">
					    		<i class="fa fa-eye"></i>
					   		</div>
					  	</div>
					</div>
				</div>
				<div class="chart-wrapper px-0" style="height: 50px;"></div>
			</div>
			</a>
		</div>			
	 <div class="col-sm-6 col-lg-3">
		<a href="{{ URL::to('admin/users/') }}">
			<div class="card text-white bg-flat-color-3 bg-black cmnht">
				<div class="card-body pb-0">
					<div class="row">
						<div class="col">
							<h4 class="mb-0">
        						<strong>                               
                                {{ $countActivePost }}
                                </strong>
        					</h4>
							<p class="text-light">Total Active Experiences</p>
						</div>
					  	<div class="col d-flex justify-content-end">
					   		<div class="icon-wrap">
					    		<i class="fa fa-dashboard"></i>
					   		</div>
					  	</div>
					</div>
				</div>
				<div class="chart-wrapper px-0" style="height: 50px;"></div>
			</div>
		  </a>
		</div>			
		<div class="col-sm-6 col-lg-3">
		<a href="{{ URL::to('admin/users/') }}">
			<div class="card text-white bg-flat-color-3 bg-blue cmnht">
				<div class="card-body pb-0">
					<div class="row">
						<div class="col">
							<h4 class="mb-0">
        						<strong>                              
                                {{ $googleSocial }}
                                </strong>
        					</h4>
							<p class="text-light">Total visits on Google </p>
						</div>
					  	<div class="col d-flex justify-content-end">
					   		<div class="icon-wrap">
					    		<i class="fa fa-google"></i>
					   		</div>
					  	</div>
					</div>
				</div>
				<div class="chart-wrapper px-0" style="height: 50px;"></div>
			</div>
			</a>
		</div>
		<div class="col-sm-6 col-lg-3">
		<a href="{{ URL::to('admin/users/') }}">
			<div class="card text-white bg-flat-color-3 bg-black cmnht">
				<div class="card-body pb-0">
					<div class="row">
						<div class="col">
							<h4 class="mb-0">
        						<strong>                               
                                {{ $facebooksocial }}
                                </strong>
        					</h4>
							<p class="text-light">Total Visits on Facebook</p>
						</div>
					  	<div class="col d-flex justify-content-end">
					   		<div class="icon-wrap">
					    		<i class="fa fa-facebook-square"></i>
					   		</div>
					  	</div>
					</div>
				</div>
				<div class="chart-wrapper px-0" style="height: 50px;"></div>
			</div>
			</a>
		</div>		
</div>
    <div class="graphchart">
         <div class="col-md-4 mb-5">
            <div id="cont">
            <div id="piechart" style="width: 100%; height: 300px;"></div>
           </div>
         </div> 
          <div class="col-md-4 mb-5">
            <div id="cont">
            <div id="record" style="width: 100%; height: 300px;"></div>
         	</div>
    	</div> 
         <div class="col-md-4 mb-5">
            <div id="cont">
            <div id="location" style="width: 100%; height: 300px;"></div>
         	</div>
    	</div> 
    	 <div class="col-md-4 mb-5">
            <div id="cont">
            <div id="travelrecord" style="width: 100%; height: 300px;"></div>
         	</div>
    	</div>    	
    	<div class="col-md-4 mb-5">
            <div id="cont">
             <canvas id="usercanvas" style="width: 100%; height: 300px;"></canvas>
         	</div>
    	</div>
    	<div class="col-md-4 mb-5">
            <div id="cont">
             <canvas id="locationcanvas" style="width: 100%; height: 300px;"></canvas>
         	</div>
    	</div>     	     	       
    </div>
@endsection


@section('after_footer')
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <script src="https://code.highcharts.com/highcharts.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
 
        function drawChart() {
 
        var data = google.visualization.arrayToDataTable([
            ['Month Name', 'Registered User Count'],
 
                @php
                foreach($data as $d) {
                foreach($d as $val){
                    echo "['".$val->month_name."', ".$val->count."],";
                    }
                }
                @endphp
        ]);
 
          var options = {
            title: 'Registered Users Month Wise Detail',
            is3D: false,
          };
 
          var chart = new google.visualization.PieChart(document.getElementById('piechart'));
 
          chart.draw(data, options);
        }
      </script>
       <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
 
        function drawChart() {        
        var data = google.visualization.arrayToDataTable([
            ['Day Name', 'Travel Exeprience Count'],
 
                @php
                foreach($record as $records) {
                foreach($records as $value){
                    echo "['".$value->day_name."', ".$value->count."],";
                    }
                }
                @endphp
        ]);
 
          var options = {
            title: 'Registered Users weekly Detail',
            is3D: false,
          };
 
          var chart = new google.visualization.PieChart(document.getElementById('record'));
 
          chart.draw(data, options);
        }
        </script>
      <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
 
        function drawChart() {
 
        var data = google.visualization.arrayToDataTable([
            ['Month Name', 'Travel Exeprience Count'],
 
                @php
                foreach($location as $data) {
                foreach($data as $value){
                    echo "['".$value->month_name."', ".$value->count."],";
                    }
                }
                @endphp
        ]);
 
          var options = {
            title: 'Travel Record Month Wise Detail',
            is3D: false,
          };
 
          var chart = new google.visualization.PieChart(document.getElementById('location'));
 
          chart.draw(data, options);
        }
        </script>
        <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
 
        function drawChart() {        
        var data = google.visualization.arrayToDataTable([
            ['Day Name', 'Travel Exeprience Count'],
 
                @php
                foreach($travelRecord as $travel) {
                foreach($travel as $value){
                    echo "['".$value->day_name."', ".$value->count."],";
                    }
                }
                @endphp
        ]);
 
          var options = {
            title: 'Travel Records weekly Detail',
            
            is3D: false,
          };
 
          var chart = new google.visualization.PieChart(document.getElementById('travelrecord'));
 
          chart.draw(data, options);
        }
        </script>
        <script> 
        var year = <?php echo $year; ?>;
        var user = <?php echo $users; ?>;
        var userbarChartData = {
            labels: year,
            datasets: [{
                label: 'User',
                backgroundColor: "#20c997",
                data: user
            }]
        };
      
            var ctxuser = document.getElementById("usercanvas").getContext("2d");
            window.myBarabc = new Chart(ctxuser, {
                type: 'bar',
                data: userbarChartData,
                options: {
                    elements: {
                        rectangle: {
                            borderWidth: 2,
                            borderColor: 'pink',
                            borderSkipped: 'bottom'
                        }
                    },
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Register User Monthly'
                    }
                }
            });
            
        var yearLocation = <?php echo $yearlocation; ?>;
        var userLocation = <?php echo $userlocation; ?>;
         var locationbarChartData = {
            labels: yearLocation,
            datasets: [{
                label: 'Travel Experience',
                backgroundColor: "#20c997",
                data: userLocation
            }]
        };
            var ctx = document.getElementById("locationcanvas").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: locationbarChartData,
                options: {
                    elements: {
                        rectangle: {
                            borderWidth: 2,
                            borderColor: 'pink',
                            borderSkipped: 'bottom'
                        }
                    },
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Travel Experience Monthly'
                    }
                }
            });
      
        </script>
@endsection