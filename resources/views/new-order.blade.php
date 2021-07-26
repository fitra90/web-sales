@extends('layout')
@section('title', 'New Order')
@section('title_section', 'New Order')

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
                    <button type="button" class="btn btn-lg btn-info">View Order</button>
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
                        <div class="col-md-12 table-order">
                            <div class="table-responsive" style="margin-bottom:20px;">
                                <h4 class="panel-title">Order List</h4>
                                <table class="table table-striped mb-none">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Picture</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        @foreach ($menus as $menu)
                        <div class="col-xs-18 col-sm-6 col-md-3" style="float:'left';">
                            <div class="thumbnail">
                                <img src="{{$menu->picture == '' ? '/assets/images/projects/project-5.jpg' : asset('storage/pictures/' . $menu->picture) }}">
                                <div class="caption">
                                    <h4>{{$menu->name}}</h4>
                                    <p>{{$menu->price}}</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="number" style="margin-top: 5%; width: 120%;" min=0 max=10 name="amount" class="form-control {{$menu->id}}" id="amount" value=0 required>

                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" style="width:100%;" class="mb-xs mt-xs mr-xs btn btn-success" onclick="add(<?= $menu->id ?>)">Add</button>
                                        </div>
                                    </div>
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
    $(document).ready(function() {
        $('.table-order').hide();
    });

    function add(id) {
        var amount = $('.' + id).val()
        if (amount > 0) {
            $('.table-order').show();
            $.ajax({
                url: '/single-stuff/' + id,
                type: 'GET'
            }).done(function(response) {
                if (response) {
                    $row = "";
                    $row += `
                                <tr id='${response.data.id}'>
                                    <td>${response.data.name}</td>
                                    <td>${response.data.price}</td>
                                    <td>${response.data.picture}</td>
                                    <td>${response.data.type}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger" onclick="removeOrderItem(${response.data.id})">Remove</button>
                                    </td>
                                </tr>
                            `
                    $('tbody').append($row)

                } else {
                    alert("Failed to load data");
                }
            })
        }

    }

    function removeOrderItem(id) {
        $('#'.id).remove();
    }

    function saveOrder() {
        $data = localStorage.getItem('order')
        $.ajax({
            url: '/save-order/',
            type: 'POST',
            data: {
                'id': id,
                'data': data,
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
@stop