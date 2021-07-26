@extends('layout')
@section('title', 'Menu')
@section('title_section', 'Menu')

@section('customCSS')
<style>
    .spinner {
        width: 100px;
    }

    .spinner input {
        text-align: right;
    }

    .input-group-btn-vertical {
        position: relative;
        white-space: nowrap;
        width: 1%;
        vertical-align: middle;
        display: table-cell;
    }

    .input-group-btn-vertical>.btn {
        display: block;
        float: none;
        width: 100%;
        max-width: 100%;
        padding: 8px;
        margin-left: -1px;
        position: relative;
        border-radius: 0;
    }

    .input-group-btn-vertical>.btn:first-child {
        border-top-right-radius: 4px;
    }

    .input-group-btn-vertical>.btn:last-child {
        margin-top: -2px;
        border-bottom-right-radius: 4px;
    }

    .input-group-btn-vertical i {
        position: absolute;
        top: 0;
        left: 4px;
    }
</style>
@stop

@section('content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <a href="/new-order">
                    <button type="button" class="btn btn-lg btn-success">Create Order</button>
                </a>
            </header>
            <div class="panel-body">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif
                    <div class="row">
                        @foreach ($data as $menu)
                        <div class="col-xs-18 col-sm-6 col-md-3" style="float:'left';">
                            <div class="thumbnail">
                                <img src="{{$menu->picture == '' ? '/assets/images/projects/project-5.jpg' : asset('storage/pictures/' . $menu->picture) }}">
                                <div class="caption">
                                    <h4>{{$menu->name}}</h4>
                                    <p>{{$menu->price}}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <!--/row-->
                </div>

            </div>
        </section>
    </div>
</div>
@section('js')
<script src="assets/vendor/fuelux/js/spinner.js"></script>
@stop
@section('customJS')
<script>
    (function($) {
        $('.spinner .btn:first-of-type').on('click', function() {
            $('.spinner input').val(parseInt($('.spinner input').val(), 10) + 1);
        });
        $('.spinner .btn:last-of-type').on('click', function() {
            if ($('.spinner input').val() > 0) {
                $('.spinner input').val(parseInt($('.spinner input').val(), 10) - 1)
            } else {
                $('.spinner input').val(parseInt($('.spinner input').val(), 10) - 0);
            }
        });
    })(jQuery);
</script>
@stop
<script>
    function add(id) {
        var dataku = $('.' + id).val()
        $.ajax({
            url: '/delete-stuff/' + id,
            type: 'DELETE',
            data: {
                'id': id,
                '_token': '{{ csrf_token() }}',
            }
        }).done(function(response) {
            // console.log(response)
            if (response) {
                location.reload()
            } else {
                alert("Failed to delete data");
            }
        })
    }
</script>
@stop