<!-- Modal -->
<div class="modal fade" id="todo_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="todo_form" action="{{ route('todos.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal_title">Create Todo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group py-2">
                        <label for="title"> Todo Title</label>
                        <input type="text" name="title" id="title" placeholder="Title" class="form-control" />
                    </div>

                    <div class="form-group py-2">
                        <label for="description"> Todo Title</label>
                        <input type="text" name="description" id="description" placeholder="Description"
                            class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save </button>
                </div>
            </form>
        </div>
    </div>
</div>
