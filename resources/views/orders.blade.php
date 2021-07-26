@extends('layout')
@section('title', 'Orders')
@section('css')
<link rel="stylesheet" href="/assets/vendor/magnific-popup/magnific-popup.css" />
<link rel="stylesheet" href="/assets/vendor/isotope/jquery.isotope.css" />
@stop
@section('title_section', 'List of Orders')
@section('content')


<div class="row">
    <div class="col-md-12">
        <section class="panel">
            @if(Session::get('role') == 1)
            <header class="panel-heading">
                <button class="btn btn-info" type="button" onclick="newStuff()">New Order</button>
            </header>
            @endif
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-none">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order Number</th>
                                <th>Table Number</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Time</th>
                                @if(Session::get('role') == 1)
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $perPage = $data->perPage();
                            $i = $data->currentPage() * $perPage - $perPage + 1;
                            ?>
                            @foreach ($data as $stuff)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$stuff->order_code}}</td>
                                <td>{{$stuff->is_paid == 0 ? "Not Paid" : "Paid"}}</td>
                                <td>{{$stuff->table_number}}</td>
                                <td>{{$stuff->status == "1" ? "Active" : "Completed"}}</td>
                                <td><?php $date = date_create($stuff->created_at);
                                    echo date_format($date, "h:i A D d/m/y"); ?></td>
                                @if(Session::get('role') == 1)
                                <td>
                                    <button class="btn btn-success" type="button" onclick='editStuff(<?= $stuff->idorders; ?>)'>Complete</button>
                                    <button class="btn btn-danger" type="button" onclick='deleteStuff(<?= $stuff->idorders; ?>)'>Cancel</button>
                                </td>
                                @endif
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->links() }}
                </div>
            </div>
        </section>
    </div>
</div>
@section('js')
<script src="/assets/vendor/magnific-popup/magnific-popup.js"></script>
<script src="/assets/vendor/isotope/jquery.isotope.js"></script>
<script src="/assets/javascripts/pages/examples.mediagallery.js"></script>
@stop
<script>
    function deleteStuff(id) {
        var r = confirm("Are you sure want to delete this stuff?");
        if (r == true) {
            // txt = "You pressed OK!";
            yesDelete(id)
        }
    }

    function editStuff(id) {
        location.href = "/edit-order/" + id
    }

    function newStuff() {
        location.href = "/new-order/"
    }

    function yesDelete(id) {
        $.ajax({
            url: '/delete-order/' + id,
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