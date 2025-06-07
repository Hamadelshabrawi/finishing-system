<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // Set dates
        $('#date').val(new Date().toISOString().split('T')[0]);
        const nextWeek = new Date();
        nextWeek.setDate(nextWeek.getDate() + 7);
        $('#delivery_date').val(nextWeek.toISOString().split('T')[0]);

        // Handle client selection using event delegation
        $(document).on('click', '.select-client-btn', function() {
            const clientId = $(this).data('id');
            const clientName = $(this).data('name');

            $('#selected_client_id').val(clientId);
            $('#client-name').text(clientName);

            // Bootstrap 3 way to hide modal and remove backdrop
            // $('#clientModal').modal('hide');
            // $('body').removeClass('modal-open');
            // $('.modal-backdrop').remove();
            
            // Update button states
            $('.select-client-btn').not(this)
                .removeClass('btn-success')
                .addClass('btn-secondary')
                .text('Select');
            
            $(this).removeClass('btn-secondary')
                   .addClass('btn-success')
                   .text('Selected');
        });

        // File upload handling
        function setupFileDrop(dropAreaId, fileListId) {
            const dropArea = $('#' + dropAreaId);
            const fileInput = dropArea.find('.file-input');
            const fileList = $('#' + fileListId);

            dropArea.on('dragover', function(e) {
                e.preventDefault();
                $(this).css({'background': '#f8f9fa', 'border-color': '#007bff'});
            });

            dropArea.on('dragleave', function() {
                $(this).css({'background': '', 'border-color': '#6c757d'});
            });

            dropArea.on('drop', function(e) {
                e.preventDefault();
                $(this).css({'background': '', 'border-color': '#6c757d'});
                fileInput[0].files = e.originalEvent.dataTransfer.files;
                updateFileList(fileList, fileInput[0].files);
            });

            fileInput.on('change', function() {
                updateFileList(fileList, this.files);
            });
        }

        function updateFileList(listElement, files) {
            listElement.empty();
            if (files.length > 0) {
                $.each(files, function(i, file) {
                    listElement.append($('<li>').text(file.name));
                });
            }
        }

        // Initialize file drop areas
        setupFileDrop('initialDropArea', 'initialFileList');
        setupFileDrop('technicalDropArea', 'technicalFileList');

        // Create Client Form Submission
        $('#create-client-form').submit(function(e) {
            e.preventDefault();
            
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            
            const submitBtn = $(this).find('button[type="submit"]');
            const originalBtnText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');

            $.ajax({
                url: $(this).attr('action') || "{{ route('clients.store') }}",
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if(response.success) {
                        // Create new client list item with properly bound click handler
                        const $newClient = $(`
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                ${response.client.name}
                                <button type="button" class="btn btn-sm btn-secondary select-client-btn" 
                                    data-id="${response.client.id}" 
                                    data-name="${response.client.name}">
                                    Select
                                </button>
                            </li>
                        `);
                        
                        // Prepend to the list
                        $('#client-list').prepend($newClient);

                        // Auto-select the new client
                        $('#selected_client_id').val(response.client.id);
                        $('#client_name_display').text(response.client.name);
                        
                        // Update the new button state
                        $newClient.find('.select-client-btn')
                            .removeClass('btn-secondary')
                            .addClass('btn-success')
                            .text('Selected');

                        // Reset the form
                        $('#create-client-form')[0].reset();

                        // Show success message
                        $('#client-form-messages').html(`
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Client created successfully!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `);

                        // Close the modal after delay
                        setTimeout(() => {
                            $('#clientModal').modal('hide');
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            const input = $(`#create-client-form [name="${field}"]`);
                            input.addClass('is-invalid')
                                .closest('.form-group')
                                .append(`<div class="invalid-feedback">${messages.join('<br>')}</div>`);
                        });
                        $('html, body').animate({scrollTop: $('.is-invalid').first().offset().top - 100}, 500);
                    } else {
                        $('#client-form-messages').html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                ${xhr.responseJSON.message || 'An unexpected error occurred'}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `);
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalBtnText);
                }
            });
        });
    });
</script>