@extends('layout')
@section('title', 'Admin Dashboard')
@section('title_section', 'List of Stuffs')
@section('content')


<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <button class="btn btn-info" type="button">New Stuff</button>
            </header>
            <div class="panel-body">
                <div class="table-responsive">
                   {{ $data }}
                    <table class="table table-striped mb-none">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>Otto</td>
                                <td>
                                    <button class="btn btn-default" type="button">Edit</button>
                                    <button class="btn btn-danger" type="button">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>

@stop