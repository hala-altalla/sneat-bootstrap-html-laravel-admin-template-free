@php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
@endphp

<!--  Brand demo (display only for navbar-full and hide on below xl) -->
@if(isset($navbarFull))
<div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
  <a href="{{ url('/') }}" class="app-brand-link gap-2">
    <span class="app-brand-logo demo">@include('_partials.macros')</span>
    <span class="app-brand-text demo menu-text fw-bold text-heading">{{ config('variables.templateName') }}</span>
  </a>
</div>
@endif

<!-- Layout menu toggle (for small screens) -->
@if(!isset($navbarHideToggle))
<div
  class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 {{ isset($contentNavbar) ? ' d-xl-none ' : '' }}">
  <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
    <i class="icon-base bx bx-menu icon-md"></i>
  </a>
</div>
@endif

<!-- Right navbar -->
<div class="navbar-nav-right d-flex align-items-center w-100 justify-content-end gap-3" id="navbar-collapse">

  <!-- 🌐 Language Switcher -->
  <div class="d-flex gap-1">
    <a href="{{ route('lang.switch','en') }}" class="btn btn-sm btn-outline-primary">EN</a>
    <a href="{{ route('lang.switch','ar') }}" class="btn btn-sm btn-outline-primary">AR</a>
  </div>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    let dir = '{{ session("dir", "ltr") }}';
    document.documentElement.setAttribute('dir', dir);

    // optional: تغيير الـ text-align للعناصر
    if (dir === 'rtl') {
      document.body.classList.add('text-end');
    } else {
      document.body.classList.remove('text-end');
    }
  });
  </script>
  <!-- 🔔 Notifications -->
  <div class="dropdown">

    <a class="nav-link position-relative" href="#" data-bs-toggle="dropdown">

      <i class="bx bx-bell fs-4"></i>

      <!-- 🔴 unread count -->
      <!-- <span class="badge bg-danger position-absolute top-0 start-100 translate-middle" id="notif-count">0</span> -->
      <span class="badge bg-danger position-absolute top-0 end-0 translate-middle " style="font-size:10px;"
        id="notif-count">0</span>
    </a>

    <ul class="dropdown-menu dropdown-menu-end" id="notif-list">

      <li class="dropdown-header d-flex justify-content-between">
        <span>Notifications</span>
      </li>

      <!-- dynamic content will be here -->

    </ul>
  </div>
  <!-- 💬 Messages -->
  <!-- <div class="dropdown">
    <a class="nav-link position-relative" href="#" data-bs-toggle="dropdown">
      <i class="bx bx-message-square-dots fs-4"></i>
      <span class="badge bg-success badge-dot position-absolute top-0 start-100 translate-middle"></span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
      <li class="dropdown-header">Messages</li>
      <li><a class="dropdown-item" href="#">You have new message</a></li>
      <li><a class="dropdown-item" href="#">Support replied</a></li>
    </ul>
  </div> -->

  <!-- 👤 User Icon (fixed icon, not image) -->
  <div class="dropdown dropdown-user">
    <a class="nav-link dropdown-toggle hide-arrow p-0" href="#" data-bs-toggle="dropdown">
      <i class="bx bx-user-circle fs-3"></i>
    </a>

    <ul class="dropdown-menu dropdown-menu-end">
      <li>
        <div class="px-3 py-2">
          <strong>{{ Auth::user()->name ?? 'Admin' }}</strong><br>
          <small class="text-muted">{{ Auth::user()->email ?? '' }}</small>
        </div>
      </li>

      <li>
        <hr class="dropdown-divider">
      </li>

      <li>
        <a class="dropdown-item" href="{{ route('view.myaccount') }}">
          <i class="bx bx-user me-2"></i> {{ __('fieldsName.profile') }}
        </a>
      </li>



      <li>
        <hr class="dropdown-divider">
      </li>


    </ul>
  </div>

</div>

<style>
.badge-dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
}

.navbar-nav-right .btn {
  min-width: 40px;
  padding: 0.25rem 0.5rem;
}

.navbar- nav-right .nav-link {
  position: relative;
  transition: transform 0.2s;
}

.navbar-nav-right .nav-link:hover {
  transform: translateY(-2px);
}
</style>
<!-- <script>
function loadNotifications() {

  fetch('/admin/notifications')
    .then(res => res.json())
    .then(data => {

      document.getElementById('notif-count').innerText = data.unread_count;

      let list = document.getElementById('notif-list');

      list.innerHTML = `
                <li class="dropdown-header">Notifications</li>
            `;

      data.notifications.forEach(n => {

        list.innerHTML += `
                    <li>
                        <a class="dropdown-item"
                           href="#"
                           onclick="markAsRead('${n.id}', '${n.data.type}', '${n.data.reference_id}')">

                            <strong>${n.data.title}</strong><br>
                            <small>${n.data.message}</small>

                        </a>
                    </li>
                `;
      });

    });
}


// 🔔 عند فتح الجرس (FIXED 100%)
document.querySelector('[data-bs-toggle="dropdown"]').addEventListener('click', function() {

  fetch('/admin/notifications/read-all', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      }
    })
    .then(() => {

      // 🔥 نجيب البيانات الجديدة بعد التحديث
      return fetch('/admin/notifications');

    })
    .then(res => res.json())
    .then(data => {

      // 🔴 تحديث الرقم من السيرفر (مو من JS)
      document.getElementById('notif-count').innerText = data.unread_count;

      // 🔥 إعادة تحميل القائمة
      let list = document.getElementById('notif-list');

      list.innerHTML = `<li class="dropdown-header">Notifications</li>`;

      data.notifications.forEach(n => {

        list.innerHTML += `
                <li>
                    <a class="dropdown-item"
                       href="#"
                       onclick="markAsRead('${n.id}', '${n.data.type}', '${n.data.reference_id}')">

                        <strong>${n.data.title}</strong><br>
                        <small>${n.data.message}</small>

                    </a>
                </li>
            `;
      });

    });

});


// ✔ mark single notification
function markAsRead(id, type, refId) {

  fetch('/admin/notifications/read/' + id, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      }
    })
    .then(() => loadNotifications());

}
// 🔥 أول تحميل
loadNotifications();
</script> -->


<!-- <script>
document.addEventListener("DOMContentLoaded", function() {

  const notifCount = document.getElementById('notif-count');
  const notifList = document.getElementById('notif-list');
  const dropdown = document.querySelector('[data-bs-toggle="dropdown"]');

  // =====================
  // LOAD NOTIFICATIONS
  // =====================
  function loadNotifications() {

    if (!notifCount || !notifList) return;

    fetch('/admin/notifications')
      .then(res => res.json())
      .then(data => {

        notifCount.innerText = data.unread_count;

        notifList.innerHTML = `
          <li class="dropdown-header">Notifications</li>
        `;

        data.notifications.forEach(n => {

          notifList.innerHTML += `
            <li>
              <a class="dropdown-item"
                 href="#"
                 onclick="markAsRead('${n.id}', '${n.data.type}', '${n.data.reference_id}')">

                <strong>${n.data.title ?? ''}</strong><br>
                <small>${n.data.message ?? ''}</small>

              </a>
            </li>
          `;
        });

      })
      .catch(err => console.log('Notification load error:', err));
  }

  // =====================
  // MARK AS READ + REDIRECT
  // =====================
  window.markAsRead = function(id, type, refId) {

    fetch('/admin/notifications/read/' + id, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      })
      .then(() => {

        if (type === 'service')
          window.location.href = `/service/${refId}`;
        else if (type === 'report') {
          window.location.href = `/reports?highlight=${refId}`;
        } else if (type === 'business') {
          window.location.href = `/viewaccount/${refId}`;
        } else {
          window.location.href = '/admin';
        }

      })
      .catch(err => console.log('Mark as read error:', err));
  };

  // =====================
  // OPEN DROPDOWN ACTION
  // =====================
  if (dropdown) {

    dropdown.addEventListener('click', function() {

      fetch('/admin/notifications/read-all', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          }
        })
        .then(() => loadNotifications())
        .catch(err => console.log(err));

    });

  }

  // =====================
  // INITIAL LOAD
  // =====================
  loadNotifications();

});
</script>
 -->
<style>
#notif-list {
  max-height: 300px;
  overflow-y: auto;
}
</style>
<script>
document.addEventListener("DOMContentLoaded", function() {

  const notifCount = document.getElementById('notif-count');
  const notifList = document.getElementById('notif-list');
  const dropdown = document.querySelector('[data-bs-toggle="dropdown"]');

  // =====================
  // LOAD NOTIFICATIONS
  // =====================
  function loadNotifications() {

    if (!notifCount || !notifList) return;

    fetch('/admin/notifications')
      .then(res => res.json())
      .then(data => {

        notifCount.innerText = data.unread_count ?? 0;

        notifList.innerHTML = `
          <li class="dropdown-header d-flex justify-content-between">
            <span>Notifications</span>
          </li>
        `;
        //  items
        if (data.notifications && data.notifications.length > 0) {

          data.notifications.forEach(n => {


            notifList.innerHTML += `
              <li>
                <a class="dropdown-item"
                   href="#"
                   onclick="markAsRead('${n.id}', '${n.data.type}', '${n.data.reference_id}')">

                  <strong>${n.data.title ?? ''}</strong><br>
                  <small>${n.data.message ?? ''}</small>

                </a>
              </li>
            `;
          });

        } else {
          notifList.innerHTML += `
            <li class="text-center text-muted p-2">
              No notifications
            </li>
          `;
        }

      })
      .catch(err => console.log('Notification load error:', err));
  }

  // =====================
  // MARK AS READ + REDIRECT
  // =====================
  window.markAsRead = function(id, type, refId) {

    fetch('/admin/notifications/read/' + id, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      })
      .then(() => {

        if (type === 'service') {
          window.location.href = `/service/${refId}`;

        } else if (type === 'report') {
          window.location.href = `/reports?highlight=${refId}`;

        } else if (type === 'business') {
          window.location.href = `/viewaccount/${refId}`;

        } else {
          window.location.href = '/admin';
        }

      })
      .catch(err => console.log('Mark as read error:', err));

  };

  // =====================
  // OPEN DROPDOWN ACTION
  // =====================
  if (dropdown) {

    dropdown.addEventListener('click', function() {

      fetch('/admin/notifications/read-all', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          }
        })
        .then(() => loadNotifications())
        .catch(err => console.log(err));

    });

  }

  // =====================
  // INITIAL LOAD
  // =====================
  loadNotifications();

});
</script>