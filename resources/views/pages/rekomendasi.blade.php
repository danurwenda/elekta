@extends('adminlte::page')
@section('header', 'Rekomendasi')
@section('description', 'pemenangan')
@section('js')
<!-- Resources -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- MAP & BOX PANE -->
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>
                Perkembangan Kumulatif
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="box">
                            <div class="box-body">
                                @include('pages.rekomendasi.allpie')
                            </div>	
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-8">
                        <div class="box">
                            <div class="box-body">
                                @include('pages.dashboard.weeks')
                            </div>		
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-body">
                                @include('pages.rekomendasi.rekomendasi')
                            </div>	
                        </div>
                    </div>
                    <!-- /.col -->

                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
        </div>

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>
                Komposisi
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-body">
                                @include('pages.rekomendasi.khofpie')
                            </div>	
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-body">
                                @include('pages.rekomendasi.ipulpie')
                            </div>		
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-body">
                                @include('pages.rekomendasi.emilpie')
                            </div>	
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-body">
                                @include('pages.rekomendasi.putipie')
                            </div>		
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-body">
                                @include('pages.rekomendasi.rekomendasi2')
                            </div>	
                        </div>
                    </div>
                    <!-- /.col -->

                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>
@endsection