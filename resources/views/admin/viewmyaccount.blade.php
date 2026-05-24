@extends('layouts/contentNavbarLayout')

@section('title', 'User Profile')

@section('content')

<div class="container-xxl mt-5 d-flex justify-content-center">

  <div class="profile-card-ultimate">

    <!-- HEADER -->
    <div class="profile-cover">

      <div class="avatar-ultimate">
        <i class="bx bx-user"></i>
        <span class="status-dot"></span>
      </div>

      <h2>{{ $admin->user->name }}</h2>
      <p>{{ $admin->email }}</p>

    </div>

    <!-- BODY -->
    <div class="profile-body">

      <!-- TYPE -->
      <div class="info-box">
        <span>{{ __('fieldsName.account-type') }}</span>
        <strong>{{ $admin->user->type ?? '-' }}</strong>
      </div>

      <!-- ROLE -->
      <div class="info-box">
        <span>{{ __('fieldsName.roles') }}</span>
        <div class="roles-wrapper">
          @foreach($admin->user->roles as $role)
          <span class="role-chip">{{ $role->name }}</span>
          @endforeach
        </div>
      </div>

      <!-- ACTION -->
      <div class="text-center mt-4">
        <a href="{{ route('edit.myaccount') }}" class="btn btn-edit-ultimate">
          ✏ {{ __('fieldsName.editprofile') }}
        </a>
      </div>

    </div>

  </div>

</div>

<style>
/* MAIN CARD */
.profile-card-ultimate {
  width: 520px;
  border-radius: 25px;
  overflow: hidden;
  background: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(15px);
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
  transition: 0.4s;
}

.profile-card-ultimate:hover {
  transform: translateY(-8px) scale(1.01);
}

/* COVER */
.profile-cover {
  background: linear-gradient(135deg, #5f61e6, #00c6ff);
  text-align: center;
  padding: 50px 20px 70px;
  color: white;
  position: relative;
}

/* AVATAR */
.avatar-ultimate {
  width: 110px;
  height: 110px;
  background: white;
  border-radius: 50%;
  margin: auto;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
}

.avatar-ultimate i {
  font-size: 55px;
  color: #5f61e6;
}

/* STATUS DOT */
.status-dot {
  width: 16px;
  height: 16px;
  background: #28c76f;
  border-radius: 50%;
  position: absolute;
  bottom: 8px;
  right: 8px;
  border: 2px solid white;
}

/* BODY */
.profile-body {
  padding: 30px;
}

/* INFO BOX */
.info-box {
  background: #f8f9ff;
  border-radius: 15px;
  padding: 15px 20px;
  margin-bottom: 15px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* ROLES */
.roles-wrapper {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
}

.role-chip {
  background: linear-gradient(45deg, #ff9a9e, #fad0c4);
  padding: 6px 12px;
  border-radius: 20px;
  font-size: 12px;
  color: #333;
  font-weight: 500;
}

/* BUTTON */
.btn-edit-ultimate {
  background: linear-gradient(135deg, #696cff, #5f61e6);
  color: white;
  padding: 10px 25px;
  border-radius: 20px;
  text-decoration: none;
  transition: 0.3s;
}

.btn-edit-ultimate:hover {
  transform: scale(1.05);
  color: white;
}
</style>

@endsection
