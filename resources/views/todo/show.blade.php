@extends('layouts.master')
@section('title', 'Todo List')
@section('page-css')
<style type="text/css">
    .todo-editor {
        height: 400px;
        overflow: auto;
        border-radius: 0 0 10px 10px;
        -webkit-box-shadow: inset 0px 0px 10px -1px rgba(34,34,34,1);
        -moz-box-shadow: inset 0px 0px 10px -1px rgba(34,34,34,1);
        box-shadow: inset 0px 0px 10px -1px rgba(34,34,34,1);
    }

    .ql-toolbar {
        border-radius: 10px 10px 0 0;
        -webkit-box-shadow: 0px 5px 12px -4px rgba(34,34,34,0.82);
        -moz-box-shadow: 0px 5px 12px -4px rgba(34,34,34,0.82);
        box-shadow: 0px 5px 12px -4px rgba(34,34,34,0.82);
    }

</style>
@endsection
@section('main')
<div class="row">
    <div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 d-flex flex-column flex-sm-row align-items-center justify-content-between">
                    <h5 class="card-title">Todo List</h5>
                    @if($todo_list)
                        <small class="text-muted">
                            Last Updated at:
                            <span class="fw-bold">{{ date("d F g:i A", strtotime($todo_list->updated_at)) }}</span>
                        </small>
                    @endif
                </div>
                <div class="pb-3 todo-editor bg-light" id="todo_editor">
                </div>
                <form action="{{ route('todo-list.store') }}" method="POST" id="todo_form" class="mt-3">
                    @csrf
                    @if($todo_list)
                        <input type="hidden" name="todo_list_id" value="{{ $todo_list->id }}">
                    @endif
                    <input type="hidden" name="todo_content" id="todo_content">
                    <button type="submit" class="btn btn-primary shadow col-8 offset-2 col-sm-6 offset-sm-3">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-js')
    <script>
        $( document ).ready(function() {
            var quill = new Quill('#todo_editor', {
                theme: 'snow'
            });

            quill.setContents({!! $todo_list?->content !!});

            $('#todo_form').on('submit', function() {
                $('#todo_content').val(JSON.stringify(quill.getContents()));

                return true; // submit form
            });
        });
    </script>
@endsection
