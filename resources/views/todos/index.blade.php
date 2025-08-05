@extends('layouts.app')
@section('content')
    @include('todos.create')


    <div class="container py-5">
        <div class="row">
            <h3 class="text-center">Ajax CRUD In Laravel</h3>
            <div class="col-xl-6">
                <div id='response-div'></div>
            </div>

            <div class="col-xl-6 text-end ">

                <!-- Button trigger modal -->
                <button type="button" id="create-todo-btn" class="btn btn-primary">
                    Create Todo
                </button>

            </div>
        </div>

        <div class="table-responsive pt-4">
            <table class="table table-striped" id="todo_table">
                <thead>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </thead>
                <tbody id="todo_table_body">
                    @if ($todos && !empty($todos))
                        @foreach ($todos as $todo)
                            <tr>
                                <td>{{ $todo->id }}</td>
                                <td>{{ $todo->title }}</td>
                                <td>{{ $todo->description }}</td>
                                <td>{{ $todo->status }}</td>
                                <td>
                                    <a href="" class="btn btn-sm btn-info">View</a>
                                    <a href="" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>

            </table>
        </div>
    </div>
@endsection


@section('js')
    <script>
        $(document).ready(function() {


            var table = $('#todo_table').DataTable({
                language: {
                    emptyTable: "No todos found", // Custom empty message
                    info: "Showing _START_ to _END_ of _TOTAL_ entries", // Proper pagination info
                    infoEmpty: "Showing 0 to 0 of 0 entries" // Empty state message
                },
                destroy: true // Allows reinitialization
            });


            $('#create-todo-btn').click(function() {
                $('#todo_modal').modal('toggle');
            });

            $('#todo_form').validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 3,
                        maxlength: 50,
                    },
                    description: {
                        required: true,
                        minlength: 10,
                        maxlength: 255,
                    }
                },
                messages: {
                    title: {
                        required: "Please Enter Todo Title",
                        minlength: "Todo Title must be atleast 3 chars",
                        maxlength: "Todo Title must not be greater than 50 chars"
                    },
                    description: {
                        required: "Please Enter Todo Description",
                        minlength: "Todo Description must be atleast 10 chars",
                        maxlength: "Todo Description must not be greater than 255 chars"
                    },
                },
                submitHandler: function(form) {
                    $("#response-div").empty();
                    const formData = $(form).serializeArray();

                    $.ajax({
                        url: "{{ route('todos.store') }}",
                        type: "POST",
                        data: formData,
                        columns: [
        { data: 'id' },
        { data: 'title' },
        { data: 'description' },
        { data: 'status' },
        {
            data: 'actions',
            orderable: false,
            searchable: false
        }
    ],
                        beforeSend: function() {
                            console.log('Loading...');
                        },
                        success: function(response) {

                            $("#todo_form")[0].reset();
                            $('#todo_modal').modal('toggle');


                            if (response.status === 'success') {


                                $('#response-div').html(
                                    `<div class='alert alert-success alert-dismissible'>
                                        ${response.message}
                                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                    </div>`
                                );


                                $('#todo_table').DataTable().destroy();


                                $("#todo_table_body").append(
                                    `
                                        <tr>
                                            <td>${response.todo.id}</td>
                                            <td>${response.todo.title}</td>
                                            <td>${response.todo.description}</td>
                                            <td>${response.todo.status}</td>
                                            <td>
                                                <a href="" class="btn btn-sm btn-info">View</a>
                                                <a href="" class="btn btn-sm btn-warning">Edit</a>
                                                <a href="" class="btn btn-sm btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    `
                                );

                                $("#todo_table").DataTable({
                                    language: {
                                        emptyTable: "No todos found",
                                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                                        infoEmpty: "Showing 0 to 0 of 0 entries"
                                    }
                                });

                            } else if (response.status === 'failed') {
                                $('#response-div').html(
                                    `<div class='alert alert-danger alert-bs-dismissible'>
                                        ${response.message}
                                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                    </div>`
                                );
                            }
                        },
                        error: function(error) {
                            $('#response-div').html(
                                `<div class='alert alert-danger alert-bs-dismissible'>
                                        ${response.message}
                                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                    </div>`
                            );
                        }
                    });
                }

            });

            $("#todo_table").dataTable();
        });
    </script>
@endsection
