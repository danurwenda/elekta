@extends('adminlte::page')
@section('header', 'MainMedia')
@section('description', 'Berita Terbaru')
@section('content')


<div class="row">
  
          <!-- AREA CHART -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Hari Ini</h3>
				<div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              
            </div>
            <div class="box-body">
               <div class="box-body table-responsive no-padding">
				  <table class="table table-hover">
					<tr>
					  <th><center>Media</center></th>
					  <th><center>Judul</center></th>
					  <th><center>Tayang</center></th>
					</tr>
					<tr>
					  @foreach ($khof as $khof)
								<tr>
									<td><span style="font-size:12px;">{{ \App\Http\Controllers\MainmediaController::getMedia($khof['link']['@attributes']['href']) }}</span></td>
									<td><a style="font-size:14px;" href={{ $khof['link']['@attributes']['href'] }} target="_blank">{!! $khof['title'] !!}</a></td>
									<td><span style="font-size:12px;">{{\Carbon\Carbon::createFromTimeStamp(strtotime($khof['published']))->diffForHumans()}}</span></td>
								</tr>
						@endforeach	
					</tr>
					
				  </table>
				</div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          

        
      </div>
      <!-- /.row -->
@endsection
