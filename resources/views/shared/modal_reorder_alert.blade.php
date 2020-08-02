<div class="modal fade" id="modalProductBelowThreshold" tabindex="-1" role="dialog"
     aria-labelledby="modalProductBelowThreshold"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body my-0">
                <div class="">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title">Product below re-order point</h5>
                </div>

                <div class="mt-4 mb-0" style=";">
                    A product that needs re-stocking has been found. Products that are below their respective
                    re-order points are listed on the dashboard.
                </div>
            </div>
            <div class="modal-footer pb-3 pt-0 text-center">
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    Go to Dashboard
                </a>

                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
