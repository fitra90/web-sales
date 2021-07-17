@extends('layout')
@section('title', 'Admin Dashboard')
@section('title_section', 'List of Stuffs')
@section('content')


<div class="row">
    <div class="col-md-12">
        <section class="panel">
            @if(Session::get('role') == 1)
                <header class="panel-heading">
                    <button class="btn btn-info" type="button" onclick="newStuff()">New Stuff</button>
                </header>
            @endif
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-none">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Stock</th>
                                <th>Status</th>
                                @if(Session::get('role') == 1)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($data as $stuff)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$stuff->name}}</td>
                                <td>{{$stuff->stock}}</td>
                                <td>{{$stuff->status == 1 ? "Available" : "Not Available"}}</td>
                                @if(Session::get('role') == 1)
                                    <td>
                                        <button class="btn btn-default" type="button" onclick='editStuff(<?= $stuff->id; ?>)'>Edit</button>
                                        <button class="btn btn-danger" type="button" onclick='deleteStuff(<?= $stuff->id; ?>)'>Delete</button>
                                    </td>
                                @endif
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
    function deleteStuff(id) {
        var r = confirm("Are you sure want to delete this stuff?");
        if (r == true) {
            // txt = "You pressed OK!";
            yesDelete(id)
        }
    }

    function editStuff(id) {
        location.href = "/edit-stuff/" + id
    }

    function newStuff() {
        location.href = "/new-stuff/"
    }

    function yesDelete(id) {
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