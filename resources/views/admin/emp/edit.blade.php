<div class="modal fade" id="editModal" tabindex="-1" role="dialog" data-ff="ename">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Edit Employee</h4>
            </div>
            <hr>
            <div class="card">
                <div class="body">
                    <form id="editform" onsubmit="return editData(event);">
                        @csrf
                        <input type="hidden" name="id" id="eid">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">Employee Name</label>
                                <div class="form-group">
                                    <input type="text" id="ename" name="name" class="form-control next" data-next="ephone" placeholder="Enter Employee name" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Employee Phone</label>
                                <div class="form-group">
                                    <input type="number" id="ephone" name="phone" class="form-control next" data-next="eaddress" placeholder="Enter Employee phone" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Employee Address</label>
                                <div class="form-group">
                                    <input type="text" id="eaddress" name="address" value="" class="form-control next" data-next="esalary" placeholder="Enter Employee address" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Employee Salary</label>
                                <div class="form-group">
                                    <input type="number" id="esalary" name="salary" class="form-control next" data-next="eacc" placeholder="Enter employee salary" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="name">Bank/Account Number</label>
                                <div class="form-group">
                                    <input type="text" id="eacc" name="acc" class="form-control" placeholder="Enter Bank Detail" required>
                                </div>
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