<x-layout-hub>
    <div class="row mb-2">
        <div class="col-lg-12">
            <a href="{{ route('hublinks.create') }}" class="btn btn-sm btn-primary radius-2px px-25 py-1">
                Create New Link
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
                                <th class="py-3 pl-35">Name</th>
                                <th>Description</th>
                                <th>URL</th>
                                <th>Order</th>
                                <th>Icon</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hubLinks as $item)
                                <tr class="bgc-h-orange-l4">
                                    <td class="pl-35">
                                        <a href='#' class='text-secondary-d2 text-95 text-600'>
                                            {{ $item->title }}
                                        </a>
                                    </td>
                                    <td class="text-dark-m3">
                                        {{ $item['description'] }}
                                    </td>
                                    <td class="text-dark-m3">
                                        {{ $item['url'] }}
                                    </td>
                                    <td class="text-dark-m3">
                                        {{ $item['order'] }}
                                    </td>
                                    <td class='text-dark-l1 text-95'>
                                        @if ($item['icon'] != null)
                                            <img src="{{ URL::asset('/uploads/hubicons/' . $item['icon']) }}"
                                                height="30" />
                                        @endif
                                    </td>
                                    <td class="text-right pr-35">
                                        <x-link-button href="{{ route('hublinks.edit', $item) }}" text="Edit"
                                            type="primary" />
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
