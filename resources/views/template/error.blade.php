@if (isset($errors) && $errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<section id="areaAlert">
    @foreach(['danger', 'warning', 'success', 'info'] as $msg )
    @if(Session::has('alert_' . $msg))
    <div class="alert alert-{{$msg}} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4>
            @if($msg == 'danger') <i class="icon fa fa-ban"></i> @endif
            @if($msg == 'warning') <i class="icon fa fa-warning"></i> @endif
            @if($msg == 'success') <i class="icon fa fa-check"></i> @endif
            @if($msg == 'info') <i class="icon fa fa-info"></i> @endif
            Alert!
        </h4>
        {{ Session::get('alert_' . $msg) }}
    </div>
    @endif
    @endforeach
    <script type="text/javascript">
        setTimeout(function(){ $('.close').click(); }, 3000);
    </script>
</section>
<script type="text/javascript">
    function alertOutput(msg,message)
    {
        var icon = "";
        switch(msg)
        {
            case "danger":
            icon = '<i class="icon fa fa-ban"></i>';
            break;
            case "warning":
            icon = '<i class="icon fa fa-warning"></i>';
            break;
            case "success":
            icon = '<i class="icon fa fa-check"></i>';
            break;
            case "info":
            icon = '<i class="icon fa fa-info"></i>';
            break;
        }
        var _html = '<div class="alert alert-'+msg+' alert-dismissible">'+
        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4>'+
        icon +'Alert!</h4>'+message+'</div>';
        $('#areaAlert').html(_html);
        setTimeout(function(){ $('.close').click(); }, 3000);

    }
</script>