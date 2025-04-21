<x-layout-hub>
    <div class="row mb-2">
        <div class="col-lg-12">
            <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary radius-2px px-25 py-1">
                Add New User
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="mt-4 mt-lg-0 card dcard h-auto overflow-hidden shadow border-t-0">
                <div class="card-body p-0 table-responsive-xl">
                    <table class="table text-dark-m1 brc-black-tp10 mb-1">
                        <thead>
                            <tr class="bgc-white text-secondary-d3 text-95">
                                <th>Username</th>
                                <th>Roles</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $item)
                                <tr class="bgc-h-orange-l4">
                                    <td>
                                        <a href='#' class='text-secondary-d2 text-95 text-600'>
                                            {{ $item['username'] }}
                                        </a>
                                    </td>
                                    <td>
                                        @foreach ($item['roles'] as $role)
                                            <span class="badge badge-primary">{{ $role }}</span>
                                        @endforeach
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('users.edit', $item['id']) }}"
                                            class="btn btn-sm btn-primary shadow-sm radius-2px px-25 py-1">
                                            Manage
                                        </a>
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
</x-layout-hub>
