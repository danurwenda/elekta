<script>
    var
            g = {!! \App\Http\Controllers\SigmaController::getGraph('khofifah') !!}
    ,
            g2 = {!! \App\Http\Controllers\SigmaController::getGraph('gusipul') !!}
    ,
            g3 = {!! \App\Http\Controllers\SigmaController::getGraph('emil') !!}
    ,
            g4 = {!! \App\Http\Controllers\SigmaController::getGraph('puti') !!}
    ;</script>
<script src="{{{ URL::asset('vendor/sigma/sigma.min.js')}}}"></script>
<style>
    #graph-container {
        top: 10;
        bottom: 10;
        left: 10;
        right: 10;
        height:400px;
    }

    #graph-container2 {
        top: 10;
        bottom: 10;
        left: 10;
        right: 10;
        height:400px;
    }

    #graph-container3 {
        top: 10;
        bottom: 10;
        left: 10;
        right: 10;
        height:400px;
    }

    #graph-container4 {
        top: 10;
        bottom: 10;
        left: 10;
        right: 10;
        height:400px;
    }
</style>


<div class="row">
    <div class="col-md-6">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Graph Khofifah</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body" >
                <div id="graph-container"></div>

            </div>
            <!-- /.box-body -->
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Graph Gus Ipul</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body" >
                <div id="graph-container2"></div>

            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Graph Emil</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body" >
                <div id="graph-container3"></div>

            </div>
            <!-- /.box-body -->
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Graph Puti</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body" >
                <div id="graph-container4"></div>

            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>



</div>
<script id="example-content" type="text/javascript">

    let s = new sigma({
    graph: g,
            container: 'graph-container',
            settings: {
            skipErrors: true
            }

    });
    let s2 = new sigma({
    graph: g2,
            container: 'graph-container2',
            settings: {
            skipErrors: true
            }

    });
    let   s3 = new sigma({
    graph: g3,
            container: 'graph-container3',
            settings: {
            skipErrors: true
            }

    });
    let  s4 = new sigma({
    graph: g4,
            container: 'graph-container4',
            settings: {
            skipErrors: true
            }

    });



</script>

