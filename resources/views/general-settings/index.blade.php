<x-app-layout>
    <div class="space-y-8">
        <div>
          <x-breadcrumb :page-title="$pageTitle" :breadcrumb-items="$breadcrumbItems" />
        </div>

        <div class=" space-y-5">
            <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6">
                <div class="card">
                    <div class="card-body p-6">
                        <div class="space-y-6">
                            <div class="flex space-x-3 items-center rtl:space-x-reverse">
                                <div class="flex-none h-8 w-8 rounded-full bg-slate-800 dark:bg-slate-700 text-slate-300 flex flex-col items-center
                                        justify-center text-lg">
                                    <iconify-icon icon="heroicons:building-office-2"></iconify-icon>
                                </div>
                                <div class="flex-1 text-base text-slate-900 dark:text-white font-medium">
                                    General Settings
                                </div>
                            </div>
                            <div class="text-slate-600 dark:text-slate-300 text-sm">
                                Set up your company profile, add your company logo, and more
                            </div>
                            <a href="{{ route('general-settings.edit') }}"
                                class="inline-flex items-center space-x-3 rtl:space-x-reverse text-sm capitalize font-medium text-slate-600
                                    dark:text-slate-300">
                                <span>Change Settings</span>
                                <iconify-icon icon="heroicons:arrow-right"></iconify-icon>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body p-6">
                        <div class="space-y-6">
                            <div class="flex space-x-3 items-center rtl:space-x-reverse">
                                <div class="flex-none h-8 w-8 rounded-full bg-slate-800 dark:bg-slate-700 text-slate-300 flex flex-col items-center
                                        justify-center text-lg">
                                    <iconify-icon icon="heroicons:user-circle"></iconify-icon>
                                </div>
                                <div class="flex-1 text-base text-slate-900 dark:text-white font-medium">
                                    Employee
                                </div>
                            </div>
                            <div class="text-slate-600 dark:text-slate-300 text-sm">
                                Manage system user(Add, edit delete users).
                            </div>
                            <a href="{{ route('users.index') }}"
                                class="inline-flex items-center space-x-3 rtl:space-x-reverse text-sm capitalize font-medium text-slate-600
                                    dark:text-slate-300">
                                <span>Manage employees</span>
                                <iconify-icon icon="heroicons:arrow-right"></iconify-icon>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body p-6">
                        <div class="space-y-6">
                            <div class="flex space-x-3 items-center rtl:space-x-reverse">
                                <div class="flex-none h-8 w-8 rounded-full bg-slate-800 dark:bg-slate-700 text-slate-300 flex flex-col items-center
                                        justify-center text-lg">
                                    <iconify-icon icon="heroicons:lock-closed"></iconify-icon>
                                </div>
                                <div class="flex-1 text-base text-slate-900 dark:text-white font-medium">
                                    Role
                                </div>
                            </div>
                            <div class="text-slate-600 dark:text-slate-300 text-sm">
                                Manage Role (Add, Edit, Delete role)
                            </div>
                            <a href="{{ route('roles.index') }}"
                                class="inline-flex items-center space-x-3 rtl:space-x-reverse text-sm capitalize font-medium text-slate-600
                                    dark:text-slate-300">
                                <span>Chnage Settings</span>
                                <iconify-icon icon="heroicons:arrow-right"></iconify-icon>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- <div class="card">
                    <div class="card-body p-6">
                        <div class="space-y-6">
                            <div class="flex space-x-3 rtl:space-x-reverse items-center">
                                <div class="flex-none h-8 w-8 rounded-full bg-slate-800 text-white flex flex-col items-center justify-center text-lg">
                                    <iconify-icon icon="heroicons:user"></iconify-icon>
                                </div>
                                <div class="flex-1 text-base text-slate-900 dark:text-white font-medium">
                                    Profile Settings
                                </div>
                            </div>
                            <div class="text-slate-600 dark:text-slate-300 text-sm">
                                Set up your profile, add your profile photo, and more
                            </div>
                            <a
                                href="{{ route('profiles.index') }}"
                                class="inline-flex items-center space-x-3 rtl:space-x-reverse text-sm capitalize font-medium text-slate-600
                                    dark:text-slate-300">
                                <span>Chnage Settings</span>
                                <iconify-icon icon="heroicons:arrow-right"></iconify-icon>
                            </a>
                        </div>
                    </div>
                </div> --}}
                <div class="card">
                    <div class="card-body p-6">
                        <div class="space-y-6">
                            <div class="flex space-x-3 rtl:space-x-reverse items-center">
                                <div class="flex-none h-8 w-8 rounded-full bg-slate-800 text-white flex flex-col items-center justify-center text-lg">
                                    <iconify-icon icon="heroicons:user"></iconify-icon>
                                </div>
                                <div class="flex-1 text-base text-slate-900 dark:text-white font-medium">
                                    Customer
                                </div>
                            </div>
                            <div class="text-slate-600 dark:text-slate-300 text-sm">
                                Manage system customers(Add, edit and delete customers).
                            </div>
                            <a
                                href="{{ route('customers.index') }}"
                                class="inline-flex items-center space-x-3 rtl:space-x-reverse text-sm capitalize font-medium text-slate-600
                                    dark:text-slate-300">
                                <span>Change Settings</span>
                                <iconify-icon icon="heroicons:arrow-right"></iconify-icon>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body p-6">
                        <div class="space-y-6">
                            <div class="flex space-x-3 rtl:space-x-reverse items-center">
                                <div class="flex-none h-8 w-8 rounded-full bg-slate-800 text-white flex flex-col items-center justify-center text-lg">
                                    <iconify-icon icon="iconoir:page-edit"></iconify-icon>
                                </div>
                                <div class="flex-1 text-base text-slate-900 dark:text-white font-medium">
                                    Terms And Condition
                                </div>
                            </div>
                            <div class="text-slate-600 dark:text-slate-300 text-sm">
                                Manage system terms and conditions(Add, edit and delete terms and conditions).
                            </div>
                            <a
                                href="{{ route('terms-condition.index') }}"
                                class="inline-flex items-center space-x-3 rtl:space-x-reverse text-sm capitalize font-medium text-slate-600
                                    dark:text-slate-300">
                                <span>Change Settings</span>
                                <iconify-icon icon="heroicons:arrow-right"></iconify-icon>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- only super admin can see this --}}
                @if (auth()->user()->hasRole('super-admin'))
                    
                <div class="card">
                    <div class="card-body p-6">
                        <div class="space-y-6">
                            <div class="flex space-x-3 rtl:space-x-reverse items-center">
                                <div class="flex-none h-8 w-8 rounded-full bg-slate-800 text-white flex flex-col items-center justify-center text-lg">
                                    <iconify-icon icon="heroicons-solid:map-pin"></iconify-icon>
                                </div>
                                <div class="flex-1 text-base text-slate-900 dark:text-white font-medium">
                                    Location
                                </div>
                            </div>
                            <div class="text-slate-600 dark:text-slate-300 text-sm">
                                Manage system locations(Add, edit and delete location).
                            </div>
                            <a
                                href="{{ route('locations.index') }}"
                                class="inline-flex items-center space-x-3 rtl:space-x-reverse text-sm capitalize font-medium text-slate-600
                                    dark:text-slate-300">
                                <span>Change Settings</span>
                                <iconify-icon icon="heroicons:arrow-right"></iconify-icon>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body p-6">
                        <div class="space-y-6">
                            <div class="flex space-x-3 rtl:space-x-reverse items-center">
                                <div class="flex-none h-8 w-8 rounded-full bg-slate-800 text-white flex flex-col items-center justify-center text-lg">
                                    <iconify-icon icon="carbon:notification-filled"></iconify-icon>
                                </div>
                                <div class="flex-1 text-base text-slate-900 dark:text-white font-medium">
                                    Notifications
                                </div>
                            </div>
                            <div class="text-slate-600 dark:text-slate-300 text-sm">
                                Manage Notifications.
                            </div>
                            <a
                                href="{{ route('notifications.index') }}"
                                class="inline-flex items-center space-x-3 rtl:space-x-reverse text-sm capitalize font-medium text-slate-600
                                    dark:text-slate-300">
                                <span>Send Notification</span>
                                <iconify-icon icon="heroicons:arrow-right"></iconify-icon>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                <div class="card">
                    <div class="card-body p-6">
                        <div class="space-y-6">
                            <div class="flex space-x-3 rtl:space-x-reverse items-center">
                                <div class="flex-none h-8 w-8 rounded-full bg-slate-800 text-white flex flex-col items-center justify-center text-lg">
                                    <iconify-icon icon="iconamoon:category"></iconify-icon>
                                </div>
                                <div class="flex-1 text-base text-slate-900 dark:text-white font-medium">
                                    Category
                                </div>
                            </div>
                            <div class="text-slate-600 dark:text-slate-300 text-sm">
                                Manage system categories(Add, edit and delete category).
                            </div>
                            <a
                                href="{{ route('categories.index') }}"
                                class="inline-flex items-center space-x-3 rtl:space-x-reverse text-sm capitalize font-medium text-slate-600
                                    dark:text-slate-300">
                                <span>Change Settings</span>
                                <iconify-icon icon="heroicons:arrow-right"></iconify-icon>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body p-6">
                        <div class="space-y-6">
                            <div class="flex space-x-3 rtl:space-x-reverse items-center">
                                <div class="flex-none h-8 w-8 rounded-full bg-slate-800 text-white flex flex-col items-center justify-center text-lg">
                                    <iconify-icon icon="typcn:ticket"></iconify-icon>
                                </div>
                                <div class="flex-1 text-base text-slate-900 dark:text-white font-medium">
                                    Ticket
                                </div>
                            </div>
                            <div class="text-slate-600 dark:text-slate-300 text-sm">
                                Manage system tickets(Add, edit and delete ticket).
                            </div>
                            <a
                                href="{{ route('tickets.index') }}"
                                class="inline-flex items-center space-x-3 rtl:space-x-reverse text-sm capitalize font-medium text-slate-600
                                    dark:text-slate-300">
                                <span>Change Settings</span>
                                <iconify-icon icon="heroicons:arrow-right"></iconify-icon>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
