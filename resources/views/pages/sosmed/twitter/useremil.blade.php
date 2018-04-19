<div class="box-body table-responsive no-padding">
<table class="table table-hover">
	<tr>
		<th><center>Username</center></th>
		<th><center>Followers</center></th>
		<th><center>Posts</center></th>
	</tr>
	<tr>
	@foreach ($emil as $data)
			<tr>
				<td><center><span style="font-size:14px;">{{ $data['user'] }}</span></center></td>
				<td><center><span style="font-size:14px;">{{ $data['follower'] }}</span></center></td>
				<td><center><span style="font-size:14px;">{{ $data['post'] }}</span></center></td>
			</tr>
	@endforeach	
	</tr>

</table>
</div>