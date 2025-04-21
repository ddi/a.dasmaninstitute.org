<div>

    <h3 class=" text-150 text-primary-d2">
        <i class="far fa-edit text-dark-l3 mr-1"></i>
        Patients
    </h3>

    <div class="card-body pb-0">
        <form wire:keydown="search" wire:submit.prevent="search" class="mt-lg-3">
            <div class="form-group row">
                <div class="mb-1 mb-sm-0 col-sm-3 col-form-label text-sm-right pr-0">
                    <label for="id-form-field-2" class="mb-0 mt-1">
                        Search Patients
                    </label>
                </div>

                <div class="col-sm-9 input-floating-label text-blue-d2 brc-blue-m1">
                    <input type="text" placeholder="Name, Civil ID, or File ID"
                        class="form-control form-control-lg brc-on-focus brc-primary-m1 col-sm-8 col-md-6 shadow-none"
                        id="id-form-field-2" wire:model="query" autocomplete="off" />
                    <span class="floating-label text-grey-m3">
                        Name, Civil ID, or File ID
                    </span>
                </div>
            </div>
        </form>
    </div>
    @if ($patients != null)
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="mt-4 mt-lg-0 card dcard h-auto overflow-hidden shadow border-t-0">
                    <div class="card-body p-0 table-responsive-xl">
                        <table class="table text-dark-m1 brc-black-tp10 mb-1">
                            <thead>
                                <tr class="bgc-white text-secondary-d3 text-95">
                                    <th class="py-3 pl-35">Name</th>
                                    <th>Civil ID</th>
                                    <th>File ID</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($patients as $patient)
                                    <tr class="bgc-h-orange-l4">
                                        <td class="pl-35">
                                            <a href='#' class='text-secondary-d2 text-95 text-600'>
                                                {{ $patient->name }}
                                            </a>
                                        </td>
                                        <td class="text-dark-m3">
                                            {{ $patient->civil_id }}
                                        </td>
                                        <td class="text-dark-m3">
                                            {{ $patient->file_id }}
                                        </td>

                                        <td class="text-right pr-35">
                                            <x-link-button href="{{ route('patient.consent-form', $patient) }}"
                                                text="Consent Form" type="primary" icon="file-pdf" />
                                            <x-link-button href="{{ route('patients.view', $patient) }}"
                                                text="Create Invoice" type="primary" />
                                            <x-link-button href="{{ route('patients.view', $patient) }}"
                                                text="View Patient" type="success" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No data found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div><!-- /.card-body -->
                </div>

            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row mt-3">
            <div class="col-lg-12">
                {{ $patients->links() }}
            </div>
        </div>
    @endif

</div>
