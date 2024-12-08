<div data-backdrop="false" class="modal fade" id="delete{{$category->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel"> {{__('messages.confirm_delete')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              
               {{__('messages.deleted')}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> {{__('messages.cancel')}}</button>
                <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" value="1" name="page_id">
                    <button type="submit" class="btn btn-danger">  {{__('messages.confirm_delete')}}</button>
                </form>
            </div>
        </div>
    </div>
  </div>

  