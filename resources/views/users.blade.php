@extends('layout')
@section('title', 'Users')
@section('title_section', 'List of Users')
@section('content')

<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <button class="btn btn-info" type="button" onclick="newUser()">New User</button>
            </header>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-none">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($data as $user)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->username}}</td>
                                <td>{{$user->role == 1 ? "Admin" : "Staff"}}</td>
                                <td>{{$user->status == 1 ? "Available" : "Not Available"}}</td>
                                <td>
                                    <button class="btn btn-default" type="button" onclick='editUser(<?= $user->id; ?>)'>Edit</button>
                                    <button class="btn btn-danger" type="button" onclick='deleteUser(<?= $user->id; ?>)'>Delete</button>
                                </td>
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
    function deleteUser(id) {
        var r = confirm("Are you sure want to delete this user?");
        if (r == true) {
            yesDelete(id)
        }
    }

    function editUser(id) {
        location.href = "/edit-user/" + id
    }

    function newUser() {
        location.href = "/new-user/"
    }

    function yesDelete(id) {
        $.ajax({
            url: '/delete-user/' + id,
            type: 'DELETE',
            data: {
                'id': id,
                '_token': '{{ csrf_token() }}',
            }
        }).done(function(response) {
            // console.log(response)
            if(response) {
                location.reload()
            } else {
                alert("Failed to delete data");
            }
        })
    }
</script>

@stop