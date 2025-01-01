<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Review</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="fn_editReview.php" method="post">
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Review:</label>
            <textarea class="form-control" name="reviewText" id="reviewText" required></textarea>
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Rating:</label>
            <input type="number" min="1" max="5" class="form-control" name="rating" value="4" required>
            <input type="hidden" name="reviewID" class="reviewID">
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
        </form>
    </div>
  </div>
</div>