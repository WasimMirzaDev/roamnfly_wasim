<div class="table-responsive">
	<table class="table table-striped table-inverse mb-1">
		<tbody>
			<tr>
				<td>{{display_date($booking->start_date)}} <i class="fa fa-long-arrow-right"></i> {{ display_date($booking->end_date)}}</td>
				<td class="text-right">{{$room->price}}*{{$booking->duration_nights}}</td>
			</tr>
		</tbody>
	</table>
</div>
