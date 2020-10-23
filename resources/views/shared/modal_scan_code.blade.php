<div class="modal fade" id="modalScanCode" tabindex="-1" role="dialog"
     aria-labelledby="modalScanCodeLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body my-0">
                <div class="">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="modalScanCodeLabel">Search Product</h5>
                </div>
                <div class="mt-4 mb-0" style=";">
{{--                    <qrcode-stream @decode="onQrDecode"></qrcode-stream>--}}

{{--                    <div class="form-group mt-4 mb-0">--}}
{{--                        <label for="scanned_product_uuid">UUID</label>--}}
{{--                        <input type="text" id="scanned_product_uuid" class="form-control" value="N/A">--}}
{{--                    </div>--}}
                    <qrcode-scanner></qrcode-scanner>
                </div>
            </div>
            <div class="modal-footer pb-3 pt-0 d-block text-center">
                <button type="button" class="btn btn-outline-primary btn-block" data-dismiss="modal">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>
