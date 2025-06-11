<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle contact updates
        $('#projectEditForm').on('submit', function() {
            // Get all contact rows
            const contactRows = $('.contact-row');
            
            // Update contact indices to be sequential
            contactRows.each(function(index) {
                const contactRow = $(this);
                
                // Update all input names to use the correct index
                contactRow.find('input').each(function() {
                    const input = $(this);
                    const name = input.attr('name');
                    
                    // Skip if this is not a contacts input
                    if (!name.startsWith('contacts[')) return;
                    
                    // Get the field name (e.g., 'name', 'position', etc.)
                    const fieldName = name.split('[')[2].replace(']', '');
                    
                    // Update the name attribute
                    input.attr('name', `contacts[${index}][${fieldName}]`);
                });
            });
        });

        // Add new contact button
        $('#add-contact').click(function() {
            // Get the next index for the new contact
            const nextIndex = $('.contact-row').length;
            
            const contactRow = `
                <div class="contact-row">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Name *</label>
                                <input type="text" name="contacts[${nextIndex}][name]" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Position *</label>
                                <input type="text" name="contacts[${nextIndex}][position]" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="tel" name="contacts[${nextIndex}][phone_number]" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="contacts[${nextIndex}][email]" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#contacts-container').append(contactRow);
        });

        // Handle contact updates
        $('#projectEditForm').on('submit', function() {
            // Get all contact rows
            const contactRows = $('.contact-row');
            
            // Update contact indices to be sequential
            contactRows.each(function(index) {
                const contactRow = $(this);
                
                // Update all input names to use the correct index
                contactRow.find('input').each(function() {
                    const input = $(this);
                    const name = input.attr('name');
                    
                    // Skip if this is not a contacts input
                    if (!name.startsWith('contacts[')) return;
                    
                    // Get the field name (e.g., 'name', 'position', etc.)
                    const fieldName = name.split('[')[2].replace(']', '');
                    
                    // Update the name attribute
                    input.attr('name', `contacts[${index}][${fieldName}]`);
                });
            });
        });

        // Remove the remove-contact button since we only allow one contact
        $('.remove-contact').remove();
        // Set dates
        // Removed auto-setting of dates to allow user selection

        // Quick Add Client functionality
        $('#saveNewClient').click(function() {
            // Get form data
            const formData = {
                name: $('#new_client_name').val(),
                email: $('#new_client_email').val(),
                phone: $('#new_client_phone').val(),
                company_name: $('#new_client_company').val(),
                type: 'individual', // Default type
                _token: '{{ csrf_token() }}'
            };

            // Clear any existing validation errors
            $('.form-group').find('.invalid-feedback').remove();
            $('.form-control').removeClass('is-invalid');

            $.ajax({
                url: '{{ route('clients.store') }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Clear the form
                        $('#quickAddClient input').val('');
                        
                        // Refresh the select2 dropdown with all clients
                        $.ajax({
                            url: '{{ route('clients.index') }}',
                            method: 'GET',
                            success: function(clientsResponse) {
                                // Clear existing options
                                $('#client_id').empty().append('<option value="">Select a client</option>');
                                
                                // Add new options
                                clientsResponse.data.forEach(function(client) {
                                    $('#client_id').append(
                                        $('<option>', {
                                            value: client.id,
                                            text: client.name + (client.company_name ? ` (${client.company_name})` : '')
                                        })
                                    );
                                });
                                
                                // Select the newly created client
                                $('#client_id').val(response.client.id).trigger('change');
                            }
                        });

                        // Close the quick add form
                        $('#quickAddClient').collapse('hide');

                        // Show success message
                        toastr.success('Client created successfully!');
                    } else {
                        // Show error message
                        toastr.error(response.message || 'Failed to create client');
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // Display validation errors
                        $.each(xhr.responseJSON.errors, function(field, errors) {
                            const errorDiv = $(`#${field}`).closest('.form-group').find('.invalid-feedback');
                            if (!errorDiv.length) {
                                $(`#${field}`).closest('.form-group').append(
                                    $('<div class="invalid-feedback d-block">').text(errors[0])
                                );
                            }
                            $(`#${field}`).addClass('is-invalid');
                        });
                    } else {
                        // Show generic error
                        toastr.error('Failed to create client');
                    }
                }
            });
        });

        // Add client deletion functionality
        $('#client_id').change(function() {
            // Add delete button when a client is selected
            if ($(this).val()) {
                if (!$('.delete-client-btn').length) {
                    $(this).closest('.input-group').append(
                        '<div class="input-group-append">' +
                        '    <button type="button" class="btn btn-outline-danger delete-client-btn" title="Delete Client">' +
                        '        <i class="fas fa-trash"></i>' +
                        '    </button>' +
                        '</div>'
                    );
                }
            } else {
                // Remove delete button when no client is selected
                $('.delete-client-btn').remove();
            }
        });

        // Handle client deletion
        $(document).on('click', '.delete-client-btn', function() {
            const clientId = $('#client_id').val();
            
            if (confirm('Are you sure you want to delete this client?')) {
                $.ajax({
                    url: '{{ route('clients.destroy', ['client' => '__client_id__']) }}'.replace('__client_id__', clientId),
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Clear the client selection
                            $('#client_id').val('').trigger('change');
                            // Clear the quick add form
                            $('#quickAddClient input').val('');
                            // Show success message
                            toastr.success('Client deleted successfully');
                        } else {
                            toastr.error(response.message || 'Failed to delete client');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            toastr.error(xhr.responseJSON.message);
                        } else {
                            toastr.error('Failed to delete client');
                        }
                    }
                });
            }
        });

        // Clear validation errors when input changes
        $('#quickAddClient input').on('input', function() {
            $(this).removeClass('is-invalid');
            $(this).closest('.form-group').find('.invalid-feedback').remove();
        });

        // Initialize select2 for client dropdown
        $('#client_id').select2({
            placeholder: 'Select a client',
            allowClear: true
        });

        // Handle client selection using event delegation
        $(document).on('click', '.select-client-btn', function() {
            const clientId = $(this).data('id');
            const clientName = $(this).data('name');

            $('#selected_client_id').val(clientId);
            $('#client-name').text(clientName);
            
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