<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-danger" id="validationResult"></div>

                <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data"
                    id="MyContent">
                    <div class="row">
                        {{ csrf_field() }}
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name</strong><span class="text-danger">*</span>
                                <input id="name" class="form-control" type="text" placeholder="Name"
                                    name="name" value="{{ old('name') }}" autofocus>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Contact No</strong><span class="text-danger">*</span>
                                <input id="name" class="form-control" type="text" placeholder="Contact No"
                                    name="contact_no" value="{{ old('contact_no') }}" autofocus>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <strong>Hobbies</strong><span class="text-danger">*</span>

                            @foreach ($hobbies as $hobby)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="hobbies[]"
                                        value="{{ $hobby->id }}" id="hobby">
                                    <label class="form-check-label" for="programming">{{ $hobby->hobby }}</label>
                                </div>
                            @endforeach


                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>Choose Category</strong>
                                    <select class="form-control type_select" name="category">
                                        <option value="">--Select Category--</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">

                                    <strong>Profile Image</strong>
                                    <input type="file" name="profile_image" class="form-control" />

                                </div>



                            </div>
                        </div>




                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" onclick="createForm()" class="btn btn-warning"
                                id="add-btn">Add</button>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
