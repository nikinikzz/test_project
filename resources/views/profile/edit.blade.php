@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data"
                            id="MyEditContent">
                            <div class="row">
                                {{ csrf_field() }}
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Name</strong><span class="text-danger">*</span>
                                        <input id="name" class="form-control" type="text" placeholder="Name"
                                            name="name" value="{{ old('name') ?? $profile->name }}" autofocus>

                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Contact No</strong><span class="text-danger">*</span>
                                        <input id="name" class="form-control" type="text" placeholder="Contact No"
                                            name="contact_no" value="{{ old('name') ?? $profile->contact_no }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>Hobbies</strong><span class="text-danger">*</span>

                                    @foreach ($hobbies as $hobby)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="hobbies[]"
                                                value="{{ $hobby->id }}" id="hobby-{{ $hobby->id }}"
                                                @if (in_array($hobby->id, $selectedHobbies)) checked @endif>
                                            <label class="form-check-label"
                                                for="hobby-{{ $hobby->id }}">{{ $hobby->hobby }}</label>
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
                                                    <option value="{{ $category->id }}"
                                                        {{ $profile->category->id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->category }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">

                                            <strong>Profile Image</strong>
                                            <br>
                                            @if ($profile->profile_pic != '')
                                                <img src="{{ asset('assets/uploads/profile/') }}/{{ $profile->profile_pic }}"
                                                    alt="{{ $profile->profile_pic }}" width="100px" />
                                            @else
                                                No image
                                            @endif
                                            <input type="file" name="profile_image" class="form-control" />

                                        </div>



                                    </div>
                                </div>




                                <div class="modal-footer">
                                    <a href="{{ route('index') }}" class="btn btn-secondary">Back</a>
                                    <button type="button" onclick="EditForm()" class="btn btn-warning"
                                        id="add-btn">Update</button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        <script>
            function EditForm() {

                const form = document.getElementById('MyEditContent');
                const formData = new FormData(form)
                $.ajax({
                    url: '{{ route('profile.update', ['profile' => $profile->id]) }}', // Replace $profileId with the actual profile ID
                    method: 'POST',
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false,
                    success: function(response) {
                        swal({
                            title: 'Success',
                            html: true,
                            text: response.message,
                            type: 'success',
                            timer: 1500, // Set the timer to 1500 milliseconds (1.5 seconds)
                            showConfirmButton: false


                        });
                        setTimeout(function() {
                            window.location.href = '{{ route('index') }}';
                        }, 1400);
                        // Server validation was successful

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Server validation failed
                        $('#validationResult').empty(); // Clear any previous error messages

                        const errors = jqXHR.responseJSON.errors;
                        if (errors) {
                            // Loop through validation errors and display them individually
                            $.each(errors, function(inputName, errorMsg) {
                                $('#validationResult').append(`<div>${errorMsg}</div>`);
                            });
                        } else {
                            $('#validationResult').text('Form validation failed');
                        }
                    }
                });
            }
        </script>
    @endsection
