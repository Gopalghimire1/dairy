<!-- add modal -->

<div class="modal fade" id="createItems" tabindex="-1" role="dialog" data-ff="iname">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="createItem">Create New Item</h4>
            </div>
            <hr>
            <div class="card">
                <div class="body">
                    <form id="add-item" onsubmit="return createNewItem(event);">
                        @csrf
                        <input type="hidden" name="rettype" value="json">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">Item Name</label>
                                <div class="form-group">
                                    <input type="text" id="iname" name="name" class="form-control next" data-next="inum" placeholder="Enter item name" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Item Number / Barcode</label>
                                <div class="form-group">
                                    <input type="text" id="inum" name="number" class="form-control next" data-next="cprice" placeholder="Enter unique item number" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="cprice">Cost Price</label>
                                <div class="form-group">
                                    <input type="number" id="cprice" name="cost_price" min="0" class="form-control next" data-next="sprice" placeholder="Enter cost price" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="sprice">Sell Price</label>
                                <div class="form-group">
                                    <input type="number" id="sprice" name="sell_price" min="0" class="form-control next" data-next="stock" placeholder="Enter sell price" required>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label for="stock">Stock</label>
                                <div class="form-group">
                                    <input type="number" id="stock" name="stock" min="0" class="form-control next" data-next="unit" placeholder="Enter stock" required>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label for="unit">Unit Type</label>
                                <div class="form-group">
                                    <input type="text" id="unit" name="unit" class="form-control next" data-next="reward" placeholder="Enter unit type" required>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label for="unit">Reward (%)</label>
                                <div class="form-group">
                                    <input type="number" id="reward" name="reward" step="0.001" min="0" value="0" class="form-control" placeholder="Enter item reward percentage" >
                                </div>
                            </div>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-raised btn-primary waves-effect" type="submit">Submit Data</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

