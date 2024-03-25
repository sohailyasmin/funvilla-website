<div class="z-[9] sticky top-0" id="app_header">
    <div class="app-header z-[999] bg-white dark:bg-slate-800 shadow-sm dark:shadow-slate-700">
        <div class="flex justify-between items-center h-full">
            <div class="basis-1/2 flex items-center md:space-x-4 space-x-4 rtl:space-x-reverse">
                <div class="xl:hidden inline-block">
                    <x-application-logo class="mobile-logo" />
                </div>
                <button class="smallDeviceMenuController  open-sdiebar-controller hidden xl:hidden md:inline-block">
                    <iconify-icon class="leading-none bg-transparent relative text-xl top-[2px] text-slate-900 dark:text-white" icon="heroicons-outline:menu-alt-3"></iconify-icon>
                </button>
                <button class="sidebarOpenButton text-xl text-slate-900 dark:text-white !ml-0">
                    <iconify-icon icon="ph:arrow-right-bold"></iconify-icon>
                </button>
                <x-header-search />
            </div>
            <!-- end vertcial -->

            <div class="items-center space-x-4 rtl:space-x-reverse horizental-box">
                <x-application-logo />
                <button class="smallDeviceMenuController  open-sdiebar-controller  hidden xl:hidden md:inline-block">
                    <iconify-icon
                        class="leading-none bg-transparent relative text-xl top-[2px] text-slate-900 dark:text-white"
                        icon="heroicons-outline:menu-alt-3"></iconify-icon>
                </button>
                <x-header-search />
            </div>
            <!-- end horizontal -->

            <!-- start horizontal nav -->
            <x-topbar-menu />
            <!-- end horizontal nav -->

            <div class="nav-tools flex items-center lg:space-x-5 space-x-3 rtl:space-x-reverse leading-0">
{{--                <x-nav-lang-dropdown />--}}
{{--                <x-dark-light />--}}
{{--                <x-gray-scale />--}}
{{--                <x-nav-message-dropdown />--}}
                <x-nav-notification-dropdown />
                <x-nav-user-dropdown />
                <button class="smallDeviceMenuController md:hidden block leading-0">
                    <iconify-icon class="cursor-pointer text-slate-900 dark:text-white text-2xl" icon="heroicons-outline:menu-alt-3"></iconify-icon>
                </button>
                <!-- end mobile menu -->
            </div>
            <!-- end nav tools -->
        </div>
    </div>
</div>

<!-- BEGIN: Modal -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto inset-0 bg-slate-900/40  backdrop-filter backdrop-blur-sm backdrop-brightness-10" id="custWavierModal" tabindex="-1" aria-labelledby="custWavierModalLabel" aria-hidden="true">
    <div class="modal-dialog relative w-auto pointer-events-none max-w-screen-sm">
        <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white dark:bg-slate-900 bg-clip-padding rounded-md outline-none text-current">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Customer Waiver Snapshots
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" 
                        data-bs-toggle="modal" data-bs-target="#custWavierModal">
                        <iconify-icon icon="mdi:close"></iconify-icon>
                    </button>
                </div>
                <div id="custWavierModalContent"></div>
            </div>
        </div>
    </div>
</div>
<!-- END: Modal -->
