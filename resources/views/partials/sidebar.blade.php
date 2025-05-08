<aside class="h-full bg-white border-r border-r-gray-200 shadow-lg w-[280px] flex flex-col justify-between">
    <div>
        <div class="border-b border-b-gray-300 h-[80px] px-4 flex items-center">
            <h1 class="font-medium text-xl tracking-wide">Point of Sale</h1>
        </div>

        @php
            $sidebarMenuItems = [];
        @endphp

        <div class="px-4 pt-4">
            <x-sidebar-item />
        </div>
    </div>

    <div class="">
        <button>Keluar</button>
    </div>
</aside>
