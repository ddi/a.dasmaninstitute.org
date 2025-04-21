<x-layout-hub>
    <div class="row mt-3">
        <div class="col-12">
            <div class="row px-3 px-lg-4">
                <div class="col-12">
                    <div class="row  ">
                        @foreach ($hubLinks as $item)
                            <div class="col-12 col-xl-3 px-0 mb-3">
                                <div class="ccard h-100 pt-2 pb-25 px-25 d-flex mx-2 overflow-hidden">
                                    <!-- the colored circles on bottom right -->
                                    <div class="position-bl	mb-n5 ml-n5 radius-round bgc-blue-l3 opacity-3"
                                        style="width: 5.25rem; height: 5.25rem;"></div>
                                    <div class="position-bl	mb-n5 ml-n5 radius-round bgc-blue-l2 opacity-5"
                                        style="width: 4.75rem; height: 4.75rem;"></div>
                                    <div class="position-bl	mb-n5 ml-n5 radius-round bgc-blue-l1 opacity-5"
                                        style="width: 4.25rem; height: 4.25rem;"></div>
                                    <div class="flex-grow-1 pl-20 pos-rel d-flex flex-column">
                                        <div class="text-secondary-d4">
                                            <a href="{{ $item['url'] }}" target="_blank" class="text-150 font-bold">
                                                {{ $item['title'] }}
                                            </a>
                                        </div>
                                        <div class="text-secondary-d2 text-90 letter-spacing snap-end">
                                            {{ $item['description'] }}
                                        </div>
                                    </div>
                                    <img src="{{ URL::asset('/uploads/hubicons/' . $item['icon']) }}" height="70" />
                                </div><!-- /.ccard -->
                            </div><!-- /.col -->
                        @endforeach

                    </div>
                </div>
            </div><!-- /.row -->
        </div>
    </div>
</x-layout-hub>
