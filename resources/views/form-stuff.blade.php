@extends('layout')
@section('title', 'Admin Dashboard')
<?php if (isset($data)) { ?>
    @section('title_section', 'Edit Stuff')
<?php } else { ?>
    @section('title_section', 'New Stuff')
<?php } ?>
@section('content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">Form</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= isset($data) ? '/save-edit-stuff/'.$data->id : '/save-new-stuff'; ?>" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">Name</label>
                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control" id="name" value="<?= isset($data) ? $data->name : ""; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">Stock</label>
                        <div class="col-md-6">
                            <input type="number" name="stock" class="form-control stock" id="stock" value="<?= isset($data) ? $data->stock : ""; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">Status</label>
                        <div class="col-md-6">
                            <select id="status" name="status" class="form-control mb-md status">
                                <option value="0">&nbsp;</option>
                                <option value="1" <?= isset($data) && $data->status == 1 ? "selected" : ""; ?>>Available</option>
                                <option value="0" <?= isset($data) && $data->status == 0 ? "selected" : ""; ?>>Not Available</option>
                            </select>
                            <span class="help-block">Leave this empty, stuff will be automatically registered as <b>Not Available</b></span>
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
        location.href="/stuffs"
    }
</script>
@stop