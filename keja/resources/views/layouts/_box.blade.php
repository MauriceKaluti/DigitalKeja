
<div class="box box-info">
    <div class="box-header with-border">
        <h4 class="text-center box-title">{{  isset($title) ? $title : "" }}</h4>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-primary btn-box-tool mb-3 text-white" data-widget="collapse"><i class="fa fa-minus"></i> Toggle Section
            </button>
        </div>
    </div>
    <div class="box-body">
        {{$slot}}
    </div>
</div>

