@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">

                        <a href="#" class="btn btn-dark-blue btn-success" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            {{ __('Add New') }}
                            <br>
                        </a>
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Contact No</th>
                                    <th>Category</th>
                                    <th>Hobbies</th>
                                    <th>Profile Picture</th>
                                    <th>Action</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($profiles as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->contact_no }}</td>
                                        <td>{{ $item->category->category }}</td>
                                        <td>
                                            @foreach ($item->hobbies as $hobby)
                                                {{ $hobby->hobby }}
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @if ($item->profile_pic != '')
                                                <img src="{{ asset('assets/uploads/profile/') }}/{{ $item->profile_pic }}"
                                                    alt="{{ $item->profile_pic }}" width="100px" />
                                            @else
                                                No image
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('profile.edit', ['profile' => $item->id]) }}"
                                                class="btn btn-warning btn-circle btn-md">Edit</a>
                                            <a href="#" class="btn btn-danger btn-circle btn-md delete-profile"
                                                data-id="{{ $item->id }}">Delete</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-danger text-center">No records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{ $profiles->links('pagination::bootstrap-4') }}


                    </div>
                    @include('profile.create', ['categories' => $categories, 'hobbies' => $hobbies])

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
    searching: false,
    select: true, // Enable row selection
    buttons: [
        {
            extend: 'copy',
            text: 'Copy to Clipboard',
            exportOptions: {
                modifier: {
                    selected: true // Export selected rows, if any
                }
            }
        },
        // Other buttons...
    ]
});
        });

        function createForm() {
            const form = document.getElementById('MyContent');
            const formData = new FormData(form)
            $.ajax({
                url: '{{ route('profile.store') }}',
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
                        location.reload();
                    }, 1500);
                    // Server validation was successful

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Server validation failed
                    $('#validationResult').empty(); // Clear any previous error messages
                    const errors = jqXHR.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function(inputName, errorMsg) {
                            $('#validationResult').append(`<div>${errorMsg}</div>`);
                        });
                    } else {
                        $('#validationResult').text('Form validation failed');
                    }
                }
            });
        }

        $('.delete-profile').click(function(e) {
            e.preventDefault();
            const profileId = $(this).data('id');
            // const confirmation = confirm('Are you sure you want to delete this profile?');
            swal({
                title: 'Are you sure?',
                text: 'You are about to delete this profile.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }, function(isConfirmed) {
                if (isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('profile.destroy') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE',
                            id: profileId
                        },
                        success: function(data) {
                            // Handle success, remove the row from the table
                            if (data.success) {
                                swal({
                                    title: 'Success',
                                    html: true,
                                    text: data.success,
                                    type: 'success',
                                    timer: 1500, // Set the timer to 1500 milliseconds (1.5 seconds)
                                    showConfirmButton: false


                                });

                                $(`[data-id=${profileId}]`).closest('tr').remove();
                            }
                        },
                        error: function() {
                            // Handle errors
                        }
                    });
                }
            });
        });
    </script>
@endsection
