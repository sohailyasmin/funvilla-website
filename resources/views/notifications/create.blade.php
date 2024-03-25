<x-app-layout>
    <div>
        {{--Breadcrumb start--}}
        <div class="mb-6">
            {{--BreadCrumb--}}
            <x-breadcrumb :breadcrumb-items="$breadcrumbItems" :page-title="$pageTitle" />
        </div>
        {{--Breadcrumb end--}}

        {{--Create user form start--}}
        <form method="POST" action="{{ route('notifications.store') }}" class="max-w-none mx-auto xl:w-full lg:max-w-none px-2 lg:px-10 xl:px-12">

            @csrf
            <div class="bg-white dark:bg-slate-800 rounded-md p-5 pb-6">

                <div class="grid sm:grid-cols-1 gap-x-8 gap-y-4">

                    {{--Name input end--}}
                    <div class="input-area">
                        <label class="form-label" for="data">
                            <span>{{ __('Title') }}</span>
                            <span class="text-red-600"> * </span>
                        </label>
                        <input class="form-control" type="text" name="title" placeholder="{{__('Enter Title')}}" required>
                    </div>
                    <div class="input-area">
                        <label class="form-label" for="data">
                            <span>{{ __('Notification Text') }}</span>
                            <span class="text-red-600"> * </span>
                        </label>
                        <textarea class="form-control" name="message" rows="4" cols="50" placeholder="{{ __('Enter text.....') }}" required></textarea>
                    </div>



                </div>
                <button type="submit" class="btn inline-flex justify-center btn-dark mt-4 w-full">
                    {{ __('Save') }}
                </button>
            </div>

        </form>
        {{--Create user form end--}}
    </div>
</x-app-layout>
