<div class="modal fade" id="review_modal" tabindex="-1" role="dialog" aria-labelledby="review_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="review_modalLongTitle">Give Feedback</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('rate_order')}}">
                    @csrf
                    <p>Tell us about your borrower and rented item condition and share your experience of renting your items on "BorrowMe" with us and other users. Thanks!</p>
                    <div class="row">
                        <div class="col-md-6">
                            <p><b>Rating</b></p>
                        </div>
                        <div class="col-md-6">
                            <div class="text-right">
                                <div id="rating"></div>
                            </div>
                        </div>
                    </div>
                    <textarea name="feedback" placeholder="Type your review here..."></textarea>
                    <input type="hidden" name="order_id">
                    <input type="hidden" name="stars">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    <button type="button" class="btn btn-outline-primary btn-block" data-dismiss="modal" style="border:0;color:#000!important;">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
