<div class="modal fade" id="clientModal" tabindex="-1" role="dialog" aria-labelledby="clientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select or Create Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <!-- Search Box -->
                <div class="form-group mb-3">
                    <input type="text" class="form-control" id="client-search" placeholder="Search clients by name, company, or phone...">
                </div>

                <h5>Select Existing Client</h5>
                <!-- Scrollable Client List -->
                <div class="client-list-container" style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 20px;">
                    <ul id="client-list" class="list-group mb-4">
                        @foreach($clients as $client)
                            <li class="list-group-item d-flex justify-content-between align-items-center client-item" 
                                data-search="{{ strtolower($client->name.' '.$client->company_name.' '.$client->phone) }}">
                                <div class="client-info">
                                    <strong>{{ $client->name }}</strong>
                                    @if($client->company_name)
                                        <small class="text-muted d-block">{{ $client->company_name }}</small>
                                    @endif
                                    @if($client->phone)
                                        <small class="text-muted d-block">{{ $client->phone }}</small>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-sm btn-primary select-client-btn" 
                                        data-id="{{ $client->id }}" 
                                        data-name="{{ $client->name }}"
                                        data-email="{{ $client->email }}"
                                        data-phone="{{ $client->phone }}"
                                        data-company="{{ $client->company_name }}"
                                        data-address="{{ $client->address }}"
                                        data-tax="{{ $client->tax_number }}"
                                        data-registration="{{ $client->commercial_registration_number }}"
                                        data-type="{{ $client->type }}">
                                    Select
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <hr>

                <h5>Create New Client</h5>
                <form id="create-client-form">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" name="name" placeholder="Client Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="email" class="form-control" name="email" placeholder="Email">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" name="phone" placeholder="Phone">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" name="company_name" placeholder="Company Name">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" name="address" placeholder="Address">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" name="tax_number" placeholder="Tax Number">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" name="commercial_registration_number" placeholder="Commercial Registration No.">
                        </div>
                        <div class="form-group col-md-6">
                            <select name="type" class="form-control" required>
                                <option value="individual">Individual</option>
                                <option value="company">Company</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Save New Client</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.client-list-container::-webkit-scrollbar {
    width: 8px;
}
.client-list-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}
.client-list-container::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}
.client-list-container::-webkit-scrollbar-thumb:hover {
    background: #555;
}
.client-item {
    transition: all 0.3s ease;
}
.hidden-client {
    display: none !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get elements
    const searchInput = document.getElementById('client-search');
    const clientItems = document.querySelectorAll('#client-list .client-item');
    
    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            
            clientItems.forEach(item => {
                const searchText = item.getAttribute('data-search');
                if (searchText.includes(searchTerm)) {
                    item.classList.remove('hidden-client');
                } else {
                    item.classList.add('hidden-client');
                }
            });
        });
    }

    // Auto-fill form when selecting client
    document.querySelectorAll('.select-client-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = document.getElementById('create-client-form');
            if (form) {
                form.querySelector('[name="name"]').value = this.dataset.name || '';
                form.querySelector('[name="email"]').value = this.dataset.email || '';
                form.querySelector('[name="phone"]').value = this.dataset.phone || '';
                form.querySelector('[name="company_name"]').value = this.dataset.company || '';
                form.querySelector('[name="address"]').value = this.dataset.address || '';
                form.querySelector('[name="tax_number"]').value = this.dataset.tax || '';
                form.querySelector('[name="commercial_registration_number"]').value = this.dataset.registration || '';
                form.querySelector('[name="type"]').value = this.dataset.type || 'individual';
            }
        });
    });
});
</script>