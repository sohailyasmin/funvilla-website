<!-- Notifications Dropdown area -->
<div class="relative md:block hidden">
    <button
      class="lg:h-[32px] lg:w-[32px] lg:bg-slate-50 lg:dark:bg-slate-900 dark:text-white text-slate-900 cursor-pointer
        rounded-full text-[20px] flex flex-col items-center justify-center notificationDropdownContainer"
      type="button"
      data-bs-toggle="dropdown"
      aria-expanded="true">
      <iconify-icon class="animate-tada text-slate-800 dark:text-white text-xl" icon="heroicons-outline:bell">

      </iconify-icon>
      <span class="absolute -right-1 lg:top-0 -top-[6px] h-4 w-4 bg-red-500 text-[8px] font-semibold flex flex-col items-center
          justify-center rounded-full text-white z-[99]" id="notification-counter">
        {{$count}}</span>
    </button>
    <!-- Notifications Dropdown -->
    <div class="dropdown hidden dropdown-menu z-10 bg-white divide-y divide-slate-100 dark:divide-slate-900 shadow w-[335px] dark:bg-slate-800 border dark:border-slate-900 !top-[18px] rounded-md lrt:origin-top-right rtl:origin-top-left"
         id="custom-notification-dropdown-menu">

    {{--    <div class="dropdown-menu z-10 bg-white divide-y divide-slate-100 dark:divide-slate-900 shadow w-[335px] dark:bg-slate-800 border dark:border-slate-900 !top-[18px] rounded-md lrt:origin-top-right rtl:origin-top-left">--}}
      <div class="flex items-center justify-between py-4 px-4">
        <h3 class="text-sm font-Inter font-medium text-slate-700 dark:text-white">Notifications</h3>
        <a class="text-xs font-Inter font-normal underline text-slate-500 dark:text-white" href="{{route('notifications.index')}}">See All</a>
      </div>
      <div class="divide-y divide-slate-100 dark:divide-slate-900" role="none">
<!--        <div class="bg-slate-100 dark:bg-slate-700 dark:bg-opacity-70 text-slate-800 block w-full px-4 py-2 text-sm relative">
          <div class="flex ltr:text-left rtl:text-right">
            <div class="flex-none ltr:mr-3 rtl:ml-3">
              <div class="h-8 w-8 bg-white rounded-full">
                <img
                  src="/images/all-img/user.png"
                  alt="user"
                  class="border-white block w-full h-full object-cover rounded-full border">
              </div>
            </div>
            <div class="flex-1">
              <a
                href="#"
                class="text-slate-600 dark:text-slate-300 text-sm font-medium mb-1 before:w-full before:h-full before:absolute
                  before:top-0 before:left-0">
                Your order is placed</a>
              <div class="text-slate-500 dark:text-slate-200 text-xs leading-4">Amet minim mollit non deser unt ullamco est sit
                aliqua.</div>
              <div class="text-slate-400 dark:text-slate-400 text-xs mt-1">
                3 min ago
              </div>
            </div>
          </div>
        </div>-->
          <div id="notification-list">
              @foreach($notifications as $notification)
                  <div class="notification" data-notification-id="{{ $notification->id }}">
                      <!-- Notification content here -->
                      <div class="notification-details" style="display: none;">
                          <div style="display: none">{{ $notification->read_at }}</div>
                          <h2>{{ json_decode($notification->data)->title }}</h2>
                          <p>{{ \Illuminate\Support\Str::limit(json_decode($notification->data)->message, 100) }}</p>
                      </div>
                      <div class="text-slate-600 dark:text-slate-300 block w-full px-4 py-2 text-sm">
                          <div class="flex ltr:text-left rtl:text-right relative">
                              <div class="flex-none ltr:mr-3 rtl:ml-3">
                                  <div class="h-8 w-8 bg-white rounded-full">
                                      <img
                                              src="/images/all-img/user2.png"
                                              alt="user"
                                              class="border-transparent block w-full h-full object-cover rounded-full border">
                                  </div>
                              </div>
                              <div class="flex-1">
                                  <a
                                          href="#"
                                          class="text-slate-600 dark:text-slate-300 text-sm font-medium mb-1 before:w-full before:h-full before:absolute
                  before:top-0 before:left-0">
                                      {{json_decode($notification->data)->title}}
                                  </a>
                                  <div class="text-slate-600 dark:text-slate-300 text-xs leading-4">{{\Illuminate\Support\Str::limit(json_decode($notification->data)->message, 100)}}</div>
                                  {{\Illuminate\Support\Carbon::parse($notification->created_at)->diffForHumans()}}
                              </div>
                              <div class="flex-0 notification-status" style="display: {{$notification->read_at !== null? 'none' : ''}}">
                                  <span class="h-[10px] w-[10px] bg-danger-500 border border-white dark:border-slate-400 rounded-full inline-block"></span>
                              </div>
                          </div>

                      </div>
                  </div>
              @endforeach
              <!-- Notifications will be added here dynamically -->
          </div>
      </div>
    </div>
</div>
@push('scripts')
  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script>
      var pusherKey = '{{ config('broadcasting.connections.pusher.key') }}';
      var pusherCluster = '{{ config('broadcasting.connections.pusher.options.cluster') }}';
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = false;

    var pusher = new Pusher(pusherKey, {
      cluster: pusherCluster
    });

    var channel = pusher.subscribe('admin-notifications');
    channel.bind('admin-notifications-event', function(data) {
      var senderId = {{auth()->id()}};
      if(senderId !== data['sender_id']){
        sweetAlertNotification(data['title'], data['message']);
          var notificationItem = createNotificationItem(data);
          console.log(data)
          var notificationList = document.getElementById('notification-list');

          // Insert the new notification as the first child
          notificationList.insertBefore(notificationItem, notificationList.firstChild);
          updateNotificationCounter('new')
      }
    });

    function createNotificationItem(data) {
        var notificationItem = document.createElement('div');
        notificationItem.classList.add('text-slate-600', 'dark:text-slate-300', 'block', 'w-full', 'px-4', 'py-2', 'text-sm');

        // Create the content of the notification item using data
        // You can customize this part to display the notification as you want

        var innerHTML = `
                <div class="flex ltr:text-left rtl:text-right relative">
                    <div class="flex-none ltr:mr-3 rtl:ml-3">
                        <div class="h-8 w-8 bg-white rounded-full">
                            <img src="/images/all-img/user2.png" alt="user" class="border-transparent block w-full h-full object-cover rounded-full border">
                        </div>
                    </div>
                    <div class="flex-1">
                        <a href="#" class="text-slate-600 dark:text-slate-300 text-sm font-medium mb-1 before:w-full before:h-full before:absolute before:top-0 before:left-0">
                            ${data.title}
                        </a>
                        <div class="text-slate-600 dark:text-slate-300 text-xs leading-4">${data.message}</div>
                        ${data.created_at}
                    </div>
                </div>
                <div class="flex-0">
                    <span class="h-[10px] w-[10px] bg-danger-500 border border-white dark:border-slate-400 rounded-full inline-block"></span>
                </div>
            `;

        notificationItem.innerHTML = innerHTML;

        return notificationItem;
    }

    function updateNotificationCounter(status) {
        var notificationCounter = document.getElementById('notification-counter');
        var currentCount = parseInt(notificationCounter.textContent);
        if(status === 'new'){
            notificationCounter.textContent = currentCount + 1;
        }
        else{
            notificationCounter.textContent = currentCount - 1;
        }

    }

    function sweetAlertNotification(title, message) {
      Swal.fire({
        position: 'top-end',
        icon: 'info',
        title: title,
        text: message,
        showConfirmButton: false,
        timer: 4000
      })
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.notification').forEach(function(notificationElement) {
            notificationElement.addEventListener('click', function(event) {
                const notificationId = event.currentTarget.getAttribute('data-notification-id');
                const notificationDetails = event.currentTarget.querySelector('.notification-details');

                const isRead = notificationDetails.querySelector('div').textContent;
                const title = notificationDetails.querySelector('h2').textContent;
                const message = notificationDetails.querySelector('p').textContent;
                openNotification(title, message);

                if(isRead == null || isRead == '')
                {
                    updateNotificationIsRead(notificationId);
                    const notificationStatusElement = event.currentTarget.querySelector('.notification-status');
                    notificationStatusElement.style.display = 'none';
                    updateNotificationCounter('');
                }

            });
        });
    });

    async function updateNotificationIsRead(notificationId) {
        const url = '/update-notifications';
        fetch(`/update-notifications/${notificationId}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Ensure to include the CSRF token
                'Content-Type': 'application/json',
            },
        })
            .then(response => {
                if (response.ok) {

                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }


    function openNotification(title, message){
        Swal.fire({
            title: title,
            text: message,
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            },
            showCloseButton: true,
        })

    }
  </script>
@endpush
