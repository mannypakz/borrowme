<div class="modal fade" id="review_status_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            @csrf
            <div class="modal-header">
                <h3 class="modal-title">Reviews</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body review-body">{{ $review_status }}</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border:0;color:#000!important;">Close</button>
            </div>
        </div>
    </div>
</div>
