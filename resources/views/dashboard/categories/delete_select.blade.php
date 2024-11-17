<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">تأكيد الحذف</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            
              هل أنت متأكد أنك تريد حذف هذا التصنيف؟
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
              <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="POST" style="display: inline;">
                  @csrf
                  @method('DELETE')
                  <input type="text" value="2" name="page_id">
                  <input type="text" id="delete_select_id" name="delete_select_id" value=''>
                  <button type="submit" class="btn btn-danger">تأكيد الحذف</button>
              </form>
          </div>
      </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
