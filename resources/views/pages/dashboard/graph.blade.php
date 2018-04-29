

<style>
    #graph-container {
        top: 10;
        bottom: 10;
        left: 10;
        right: 10;
        height:500px;
    }


</style>



<div id="graph-container"></div>




@section('js')
<script src="{{{ URL::asset('vendor/sigma/sigma.min.js')}}}"></script>
<script id="example-content">


g = {!! \App\Http\Controllers\DashboardController::getGraph() !!} ;

s = new sigma({
    graph: g,
    container: 'graph-container',
    settings: {
        skipErrors: true
    }

});



</script>
@append
