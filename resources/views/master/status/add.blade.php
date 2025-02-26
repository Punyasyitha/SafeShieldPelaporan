<x-app-layout>
    <form id="iniForm" action="{{ route('master.status.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="w-full px-4 py-2">
            <div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto">
                <div class="flex flex-col mb-4">
                    <h6 class="text-lg font-bold mb-2">INSERT STATUS</h6>
                    <hr class="horizontal dark mt-1 mb-2">

                    <!-- Tombol Kembali dan Simpan di kiri -->
                    <div class="flex justify-start items-center gap-2 mt-5">
                        <button type="button" onclick="window.location='{{ route('master.status.list') }}'"
                            class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded-lg">
                            <i class="fas fa-circle-left me-1"></i><span class="font-weight-bold ml-1">Kembali</span>
                        </button>

                        @if ($authorize->add == '1')
                            <button id="submitForm"
                                class="bg-pink-300 hover:bg-pink-400 text-white font-semibold py-2 px-4 rounded-lg">
                                <i class="fas fa-floppy-disk me-1"></i>
                                <span class="font-weight-bold">Simpan</span>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Form input ID Status (read-only) dan Nama Status -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">ID Status</label>
                    <input type="text" name="idstatus" readonly
                        class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg focus:outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Status</label>
                    <input type="text" name="nama_status" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-200">
                </div>
            </div>
        </div>
    </form>
    {{-- <script>
        $(document).ready(function() {
            // Setup CSRF Token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Event handler for the form submit button
            $("#submitForm").on('click', function(e) {
                e.preventDefault(); // Prevent default form submission

                // This assumes the form has an ID of "iniForm"
                var formElement = $('#iniForm')[
                    0]; // Ensure you're selecting the form element, not the button

                if (!formElement) {
                    console.error('Form element not found');
                    return;
                }

                var formData = new FormData(formElement); // Use form element in FormData constructor
                var isValid = true;
                var errorMessage = '';
                var isFormValid = true;

                // Log the required inputs to console for debugging
                console.log($("input").prop('required', true));

                $("input:not(#myVendor_filter input)").prop('required', true).each(function() {
                    // Allow null or empty inputs to be valid
                    if ($(this).val() !== null && $(this).val() !== '' && !$(this)[0]
                        .checkValidity()) {
                        // Log invalid input to console for debugging
                        console.log('Invalid input:', $(this));
                        console.log('Value:', $(this).val());
                        console.log('Validation issue:', $(this)[0].validationMessage);

                        isFormValid = false; // Set flag invalid form
                        errorMessage +=
                            '<br>Lengkapi semua kolom yang wajib diisi dengan nilai yang valid.';
                        return false; // Exit the loop if any input is invalid
                    }
                });


                // If the form is not valid, show the error message and stop the process
                if (!isValid || !isFormValid) {
                    Swal.fire({
                        title: 'Kesalahan!',
                        html: errorMessage,
                        icon: 'error',
                        showConfirmButton: true
                    });
                    return;
                }

                // Function to submit the form
                function submitForm() {
                    // Send form data with AJAX
                    $.ajax({
                        url: "{{ URL::to($url_menu) }}", // Ensure the URL is correct
                        type: "POST",
                        data: formData, // Form data to be sent
                        contentType: false, // Necessary for sending FormData
                        processData: false, // Necessary for sending FormData
                        success: function(response) {
                            // Show success message on successful submission
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses',
                                text: 'Data tanda terima berhasil disimpan',
                                showConfirmButton: true,
                            }).then((result) => {
                                // Redirect after successful submission
                                window.location.href = "{{ url($url_menu) }}";
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            // Tangani error jika ada
                            var errorMessage = 'Terjadi kesalahan saat memperbarui data.';

                            // Mengecek apakah ada pesan error pada respons JSON
                            if (jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                                // Looping untuk menampilkan semua error dari response
                                var errorList = '';
                                $.each(jqXHR.responseJSON.errors, function(field, messages) {
                                    $.each(messages, function(index, message) {
                                        errorList += message + '<br>';
                                    });
                                });

                                // Update errorMessage dengan error yang ditemukan
                                errorMessage = errorList;
                            }

                            // Menampilkan pesan kesalahan menggunakan Swal
                            Swal.fire({
                                title: 'Gagal',
                                html: errorMessage,
                                icon: 'error',
                                showConfirmButton: true
                            });

                            // Debugging error
                            console.error(textStatus, errorThrown);
                        }
                    });
                }

                // Call the function to submit the form
                submitForm();
            });
        });
    </script> --}}
</x-app-layout>
