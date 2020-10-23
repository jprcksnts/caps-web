<div class="modal fade" id="modalImportProductSale" tabindex="-1" role="dialog"
     aria-labelledby="modalImportProductSaleLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post"
                  action="{{ route('import') }}" role="form" id="form-data" enctype="multipart/form-data">
                @csrf
                <div class="modal-body my-0">
                    <div class="text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title" id="modalImportProductSaleLabel">Import Product Sale</h5>
                    </div>
                    <div class="mt-4 mb-0 text-left">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="document" lang="en"
                                   accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                   name="document" required>
                            <label class="custom-file-label" for="document"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pb-3 pt-0 d-block text-center">
                    <input type="hidden" name="import_action" value="import_product_sales">
                    <button type="submit" class="btn btn-primary btn-block">
                        <span id="import-button-label">Upload File</span>
                    </button>
                    <p class="small text-center text-muted pt-2 px-5">
                        Please make sure to upload the right Excel file format with the correct details.
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
