<link rel="stylesheet" href="{{asset('/vendor/phobrv/css/admin.css')}}">
<script src="{{asset('/vendor/phobrv/js/admin.js')}}"></script>
<div class="row">
	<div class="col-lg-3 col-xs-6">
		<div class="small-box bg-aqua">
			<div class="inner">
				<h3>{{$data['count_blog']}}</h3>
				<p>@lang('Total Post')</p>
			</div>
			<div class="icon">
				<i class="ion ion-bag"></i>
			</div>
			<a href="/admin/post" class="small-box-footer"> @lang('More info') <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	</div>
	<div class="col-lg-3 col-xs-6">
		<div class="small-box bg-purple">
			<div class="inner">
				<h3>{{$data['count_order']}}</h3>
				<p>@lang('Total Order')</p>
			</div>
			<div class="icon">
				<i class="ion ion-stats-bars"></i>
			</div>
			<a href="/admin/order" class="small-box-footer">@lang('More info')  <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	</div>
	<div class="col-lg-3 col-xs-6">
		<div class="small-box bg-green">
			<div class="inner">
				<h3>{{$data['count_order_success']}}</h3>

				<p>@lang('Order Success')</p>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div>
			<a href="/admin/order" class="small-box-footer">@lang('More info')  <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	</div>
	<div class="col-lg-3 col-xs-6">
		<div class="small-box bg-orange">
			<div class="inner">
				<h3>{{$data['count_order_pendding']}}</h3>

				<p>@lang('Order Pending')</p>
			</div>
			<div class="icon">
				<i class="ion ion-pie-graph"></i>
			</div>
			<a href="/admin/order" class="small-box-footer">@lang('More info')  <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	</div>
</div>
<div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title">@lang('Site Analytics')</h3>
		<input type="hidden" id="reportTrafficInDay" value="{{$data['reportTrafficInDay']}}">
		<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
			</button>
			<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		</div>
	</div>
	<div id="chart-report" class="box-body chart-responsive">
		<div class="row">
			<div class="col-xs-12 " style="margin-bottom: 15px;" >
				<div class="chart" id="line-chart" style="height: 300px;"></div>
			</div>
			<div class="col-xs-6 col-md-3">
				<div class="info-box">
					<span class="info-box-icon bg-orange">
						<i class="ion ion-ios-eye"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">Sessions </span>
						<span class="info-box-number">
							{{$data['trafficSource']['ga:sessions']}}
						</span>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-md-3">
				<div class="info-box">
					<span class="info-box-icon bg-aqua">
						<i class="ion ion-ios-people"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">Visitors</span>
						<span class="info-box-number">
							{{$data['trafficSource']['ga:users']}}
						</span>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-md-3">
				<div class="info-box">
					<span class="info-box-icon bg-olive">
						<i class="ion ion-ios-world-outline"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">PageViews</span>
						<span class="info-box-number">
							{{$data['trafficSource']['ga:pageviews']}}
						</span>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-md-3">
				<div class="info-box">
					<span class="info-box-icon bg-purple">
						<i class="ion ion-flash"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">Bounce Rate</span>
						<span class="info-box-number">
							{{number_format($data['trafficSource']['ga:bounceRate'],2)}} <small>%</small>
						</span>
					</div>
				</div>
			</div>

			<div class="col-xs-6 col-md-3">
				<div class="info-box">
					<span class="info-box-icon bg-maroon">
						<i class="ion ion-arrow-graph-up-right"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">
							Percent new session
						</span>
						<span class="info-box-number">
							{{number_format($data['trafficSource']['ga:percentNewSessions'],2)}} <small>%</small>
						</span>
					</div>
				</div>
			</div>

			<div class="col-xs-6 col-md-3">
				<div class="info-box">
					<span class="info-box-icon bg-yellow">
						<i class="ion ion-steam"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">
							Pages/Session
						</span>
						<span class="info-box-number">
							{{number_format($data['trafficSource']['ga:pageviewsPerSession'],2)}}
						</span>
					</div>
				</div>
			</div>

			<div class="col-xs-6 col-md-3">
				<div class="info-box">
					<span class="info-box-icon bg-red">
						<i class="ion ion-ios-clock-outline"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">
							Avg. Duration
						</span>
						<span class="info-box-number">
							{{date('H:i:s',$data['trafficSource']['ga:avgSessionDuration'])}}
						</span>
					</div>
				</div>
			</div>

			<div class="col-xs-6 col-md-3">
				<div class="info-box">
					<span class="info-box-icon bg-green">
						<i class="ion ion-person-add"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">
							New visitors
						</span>
						<span class="info-box-number">
							{{$data['trafficSource']['ga:newUsers']}}
						</span>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title">@lang('Topmost visit pages')</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
				<table class="table table-striped">
					<tr>
						<th style="width: 10px">#</th>
						<th>Url</th>
						<th style="width: 40px">View</th>
					</tr>
					@foreach($data['topVisitorAndPageView'] as $r)
					<tr>
						<td align="center">{{$loop->index + 1}}</td>
						<td>{{$r['pageTitle']}}</td>
						<td align="center">{{$r['pageViews']}}</td>
					</tr>
					@endforeach
				</table>
			</div>

		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title">Active Log</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
				<table class="table table-striped">
					<tr>
						<th style="width: 10px">#</th>
						<th>Task</th>
						<th>Progress</th>
						<th style="width: 40px">Label</th>
					</tr>
					<tr>
						<td>1.</td>
						<td>@lang('Update') software</td>
						<td>
							<div class="progress progress-xs">
								<div class="progress-bar progress-bar-danger" style="width: 55%"></div>
							</div>
						</td>
						<td><span class="badge bg-red">55%</span></td>
					</tr>

				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function () {
		"use strict";
    	// LINE CHART
    	var reportTrafficInDay = $('#reportTrafficInDay').val();
    	var reportTrafficInDayObj = JSON.parse(reportTrafficInDay);
    	var dataReport = [];
    	for(var i=0 ;i<reportTrafficInDayObj.length ; i++ )
    	{
    		dataReport.push(
    			{y: (parseInt(reportTrafficInDayObj[i][0])+1).toString()+"h" , item1: reportTrafficInDayObj[i][1], item2: reportTrafficInDayObj[i][2]}
    			);
    	}
    	console.log(dataReport);
    	var line = new Morris.Line({
    		element: 'line-chart',
    		resize: true,
    		data: dataReport,
    		xkey: 'y',
    		ykeys: ['item1','item2'],
    		labels: ['Visitors','PageViews'],
    		lineColors: ['#3c8dbc','#f56'],
    		hideHover: 'auto',
    		xLabelFormat:  function(d) {
    			return d.getYear()+"h";
    		},
    	});
    });
</script>