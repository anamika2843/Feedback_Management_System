<?php echo $this->extend('theme/theme'); ?>
<?php echo $this->section('content'); ?>
<?php echo form_open(site_url('admin/refresh_chart'), ['id'=>'chart_filter_frm']); ?>
<div class="form-group mb-3">
	<div class="row">
		<div class="col-md-4">
			<select name="board_id" id="board_id" class="form-select">
				<option value=""><?php echo app_lang('select-board'); ?></option>
				<?php foreach ($boards as $key => $value) { ?>
					<option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
				<?php } ?>
			</select>
		</div>
		<div  class="col-md-3">
			<div class="form-group">
				<select
				class="form-select"
				name="range"
				id="range"
				data-width="100%"<?php echo isset($onChange) ? 'onchange="'.$onChange.'"' : ''; ?>>
				<option value="0"><?php echo app_lang('select-board-range'); ?></option>
				<option value='<?php echo json_encode(
    [
                _d(date('Y-m-d')),
                _d(date('Y-m-d')),
                ]
); ?>'>
				<?php echo app_lang('today'); ?>
			</option>
			<option value='<?php echo json_encode(
                    [
                _d(date('Y-m-d', strtotime('monday this week'))),
                _d(date('Y-m-d', strtotime('sunday this week'))),
                ]
                ); ?>'>
				<?php echo app_lang('this_week'); ?>
			</option>
			<option value='<?php echo json_encode(
                    [
            _d(date('Y-m-01')),
            _d(date('Y-m-t')),
            ]
                ); ?>'>
			<?php echo app_lang('this_month'); ?>
			</option>
			<option value='<?php echo json_encode(
                [
            _d(date('Y-m-01', strtotime('-1 MONTH'))),
            _d(date('Y-m-t', strtotime('-1 MONTH'))),
            ]
            ); ?>'>
			<?php echo app_lang('last_month'); ?>
			</option>
			<option value='<?php echo json_encode(
                [
            _d(date('Y-m-d', strtotime(date('Y-01-01')))),
            _d(date('Y-m-d', strtotime(date('Y-12-31')))),
            ]
            ); ?>'>
			<?php echo app_lang('this_year'); ?>
			</option>
			<option value='<?php echo json_encode(
                [
            _d(date('Y-m-d', strtotime(date(date('Y', strtotime('last year')).'-01-01')))),
            _d(date('Y-m-d', strtotime(date(date('Y', strtotime('last year')).'-12-31')))),
            ]
            ); ?>'>
			<?php echo app_lang('last_year'); ?>
			Last Year
			</option>
			<option value="period"><?php echo app_lang('custom'); ?></option>
		</select>
	</div>
	</div>
	<div class="col-md-3">
		<input type="text" class="form-control" name="daterange" id="from_date" value="<?php echo date('m-d-y'); ?>" disabled="disabled">
	</div>
	<div class="col-md-2">
		<button type="submit" class="mb-2 me-2 btn btn-shadow btn-primary w-100"><?php echo app_lang('filter'); ?></button>
	</div>
	</div>
</div>
<?php echo form_close(); ?>
<div class="mb-3 card form-group">
	<div class="tabs-lg-alternate card-header">
		<ul class="nav nav-justified">
			<li class="nav-item">
				<a href="<?= site_url('admin/users') ?>" target="_blank" class="nav-link minimal-tab-btn-1">
					<div class="widget-number text-info">
						<span class="pe-2 opactiy-6">
							<i class="fa fa-users"></i>
						</span>
						<span id="span_total_user"><?php echo $total_user; ?></span>
					</div>
					<div class="tab-subheading">
						<?php echo app_lang('user-total'); ?>
					</div>
				</a>
			</li>
			<li class="nav-item">
				<a href="<?= site_url('admin/feedback/comments') ?>" target="_blank" class="nav-link minimal-tab-btn-2">
					<div class="widget-number">
						<span class="pe-2 text-success">
							<i class="fa fa-comments"></i>
						</span>
						<span id="span_total_comments"><?php echo $total_comments; ?></span>
					</div>
					<div class="tab-subheading"><?php echo app_lang('comments-total'); ?></div>
				</a>
			</li>
			<li class="nav-item">
				<a href="<?= site_url('admin/roadmap') ?>" target="_blank" class="nav-link minimal-tab-btn-3">
					<div class="widget-number text-danger">
						<span class="pe-2 opactiy-6">
							<i class="fa fa-bullhorn"></i>
						</span>
						<span id="span_total_roadmap"><?php echo $total_roadmap; ?></span>
					</div>
					<div class="tab-subheading">
						<?php echo app_lang('roadmap-changes-total'); ?>
					</div>
				</a>
			</li>
			<li class="nav-item">
				<a href="<?= site_url('admin/feedback') ?>" target="_blank" class="nav-link minimal-tab-btn-4">
					<div class="widget-number text-warning">
						<span class="pe-2 opactiy-6">
							<i class="fa fa-puzzle-piece"></i>
						</span>
						<span id="span_total_feedbacks"><?php echo $total_feedbacks; ?></span>
					</div>
					<div class="tab-subheading">
						<?php echo app_lang('feature-requests-total'); ?>
					</div>
				</a>
			</li>
		</ul>
	</div>
	<div class="tab-content">
		<div class="tab-pane active" id="tab-minimal-0">
			<div class="card-body">
				<figure class="highcharts-figure">
					<div id="total_user_chart"></div>
					<p class="highcharts-description"></p>
				</figure>
				<figure class="highcharts-figure">
					<div id="top_ten_charts"></div>
					<p class="highcharts-description"></p>
				</figure>
			</div>
		</div>
	</div>
</div>
<?php echo $this->endSection(); ?>
<?php echo $this->section('scripts'); ?>
<script>
	"use strict";
	Highcharts.chart('total_user_chart', {
		chart: {
			type: 'column'
		},
		title: {
			text: '<?php echo app_lang('feature_request_chart'); ?>'
		},
		subtitle: {
			text: '<?php echo app_lang('feature_request_chart'); ?>'
		},
		accessibility: {
			announceNewData: {
				enabled: true
			}
		},
		xAxis: {
			type: 'category'
		},
		yAxis: {
			title: {
				text: '<?php echo app_lang('chart_total'); ?>'
			}

		},
		legend: {
			enabled: false
		},
		plotOptions: {
			series: {
				borderWidth: 0,
				dataLabels: {
					enabled: true,
					format: '{point.y:.0f}'
				}
			}
		},

		tooltip: {
			headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
			pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> of total<br/>'
		},

		series: [
		{
			name: "Feedbacks",
			colorByPoint: true,
			data: [
			{
				name: "Total Users",
				y:<?php echo $total_user; ?>,
				drilldown: "Total Users"
			},
			{
				name: "Comments Total",
				y:<?php echo $total_comments; ?>,
				drilldown: "Comments Total"
			},
			{
				name: "Roadmap Changes Total",
				y:<?php echo $total_roadmap; ?>,
				drilldown: "Roadmap Changes Total"
			},
			{
				name: "Feature Request Total",
				y:<?php echo $total_feedbacks; ?>,
				drilldown: "Feature Request Total"
			},
			]
		}
		],
		drilldown: {
			series: [
			{
				name: "Total Users",
				id: "Total Users",
				data: [
				[
				<?php echo $total_user; ?>,
				<?php echo $total_user; ?>
				]
				]
			},
			{
				name: "Comments Total",
				id: "Comments Total",
				data: [
				[
				<?php echo $total_comments; ?>,
				<?php echo $total_comments; ?>
				]
				]
			},
			{
				name: "Roadmap Changes Total",
				id: "Roadmap Changes Total",
				data: [
				[
				<?php echo $total_roadmap; ?>,
				<?php echo $total_roadmap; ?>
				]
				]
			},
			{
				name: "Feature Request Total",
				id: "Feature Request Total",
				data: [
				[
				<?php echo $total_feedbacks; ?>,
				<?php echo $total_feedbacks; ?>
				]
				]
			}
			]
		}
	});

	Highcharts.chart('top_ten_charts', {
		chart: {
			type: 'column'
		},
		title: {
			text: '<?php echo app_lang('top_ten_feedback'); ?>'
		},
		subtitle: {
			text: '<?php echo app_lang('top_ten_feedback'); ?>'
		},
		accessibility: {
			announceNewData: {
				enabled: true
			}
		},
		xAxis: {
			type: 'category'
		},
		yAxis: {
			title: {
				text: '<?php echo app_lang('chart_total'); ?>'
			}

		},
		legend: {
			enabled: false
		},
		plotOptions: {
			series: {
				borderWidth: 0,
				dataLabels: {
					enabled: true,
					format: '{point.y:.0f}'
				}
			}
		},

		tooltip: {
			headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
			pointFormat: '<span style="color:{point.color}">Board</span>: <b>{point.board}</b><br/>'
		},

		series: [
		{
			name: "Feedbacks",
			colorByPoint: true,
			data: [<?php echo $top_ten_chart_series; ?>]
		}
		]
	});
	$('select[name="range"]').on('change',function(){

		if($(this).val()=="period"){
			$('#from_date').prop('disabled',false);
		}else{
			$('#from_date').prop('disabled',true);
		}
	})
	$('#chart_filter_frm').on('submit',function(e){
		e.preventDefault();

		var board_id = $('select[name="board_id"]').val();
		var range = $('select[name="range"]').val();
		var from_date = $('#from_date').val();

		$.ajax({
			url: site_url+"/admin/refresh_chart",
			type: 'POST',
			dataType: 'json',
			data: {board_id:board_id,range:range,from_date:from_date,[csrfName]:csrfHash},
		})
		.done(function(response) {
			var chart1 = $('#total_user_chart').highcharts();
			var chart2 = $('#top_ten_charts').highcharts();
			var total_user = 0;
			var total_comments = 0;
			var total_feedbacks = 0;

			if(response.data.total_user!=null){
				total_user = parseInt(response.data.total_user);
			}else{
				total_user = 0;
			}
			if(response.data.total_comments!=null){
				total_comments = parseInt(response.data.total_comments);
			}else{
				total_comments = 0;
			}
			if(response.data.total_feedbacks!=null){
				total_feedbacks = parseInt(response.data.total_feedbacks);
			}else{
				total_feedbacks = 0;
			}
			$("#span_total_user").html(total_user);
			$("#span_total_comments").html(total_comments);
			$("#span_total_feedbacks").html(total_feedbacks);
			chart1.update({
				series: [
				{
					name: "Feedbacks",
					colorByPoint: true,
					data: [
					{
						name: "Total Users",
						y:total_user,
						drilldown: "Total Users"
					},
					{
						name: "Comments Total",
						y:total_comments,
						drilldown: "Comments Total"
					},
					{
						name: "Roadmap Changes Total",
						y:<?php echo $total_roadmap; ?>,
						drilldown: "Roadmap Changes Total"
					},
					{
						name: "Feature Request Total",
						y:total_feedbacks,
						drilldown: "Feature Request Total"
					},
					]
				}
				],
			},true,true);
			chart1.options.drilldown = Highcharts.merge(chart1.options.drilldown, {
				series: [
				{
					name: "Total Users",
					id: "Total Users",
					data: [
					[
					total_user,
					total_user
					]
					]
				},
				{
					name: "Comments Total",
					id: "Comments Total",
					data: [
					[
					total_comments,
					total_comments
					]
					]
				},
				{
					name: "Feature Request Total",
					id: "Feature Request Total",
					data: [
					[
					total_feedbacks,
					total_feedbacks
					]
					]
				}
				]
			});
			if(response.is_json!=false){
				chart2.update({
					series: [
					{
						name: "Feedbacks",
						colorByPoint: true,
						data: response.top_ten_chart_series,
					}]
				},true,true);
			}else{
				chart2.update({
					series: [
					{
						name: "Feedbacks",
						colorByPoint: true,
						data: [response.top_ten_chart_series],
					}]
				},true,true);
			}
		});
	});
</script>
<?php echo $this->endsection(); ?>
