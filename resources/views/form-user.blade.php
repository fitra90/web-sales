@extends('layout')
@section('title', 'Admin Dashboard')
<?php if (isset($data)) { ?>
    @section('title_section', 'Edit User')
<?php } else { ?>
    @section('title_section', 'New User')
<?php } ?>
@section('content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">Form</h2>
            </header>
            <div class="panel-body">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form class="form-horizontal form-bordered" action="<?= isset($data) ? '/save-edit-user/' . $data->id : '/save-new-user'; ?>" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">Name</label>
                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control" id="name" value="{{ isset($data) ? $data->name : old('name')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">Username</label>
                        <div class="col-md-6">
                            <input type="text" name="username" class="form-control" id="username" value="{{ isset($data) ? $data->username : old('username')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">Password</label>
                        <div class="col-md-6">
                            <input type="password" name="password" class="form-control" id="password" value="{{ isset($data) ? $data->password : old('password')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">Role</label>
                        <div class="col-md-6">
                            <select id="role" name="role" class="form-control mb-md">
                                <option value="2">&nbsp;</option>
                                <option value="1" <?= isset($data) && $data->role == 1 ? "selected" : ""; ?>>Admin</option>
                                <option value="2" <?= isset($data) && $data->role == 2 ? "selected" : ""; ?>>Staff</option>
                            </select>
                            <span class="help-block">Leave this empty, user will be automatically registered as <b>Staff</b></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">Status</label>
                        <div class="col-md-6">
                            <select id="status" name="status" class="form-control mb-md status">
                                <option value="0">&nbsp;</option>
                                <option value="1" <?= isset($data) && $data->status == 1 ? "selected" : ""; ?>>Active</option>
                                <option value="0" <?= isset($data) && $data->status == 0 ? "selected" : ""; ?>>Not Active</option>
                            </select>
                            <span class="help-block">Leave this empty, user will be automatically registered as <b>Not Active</b></span>
                        </div>
                    </div>
                    <br>
                    <center>
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-default" onclick="cancel()">Cancel</button>
                        <button type="submit" class="mb-xs mt-xs mr-xs btn btn-success">Save</button>
                    </center>
                </form>
            </div>
        </section>
    </div>
</div>

<script>
    function cancel() {
        location.href = "/users"
    }
</script>
@stop