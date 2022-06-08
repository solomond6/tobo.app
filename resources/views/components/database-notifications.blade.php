<div>
    <!-- Let all your things have their places; let each part of your business have its time. - Benjamin Franklin -->
    @auth
<div class="btn-group">
  <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fa fa-bell text-white" aria-hidden="true"></i>
  </a>
  <div class="dropdown-menu dropdown-menu-right">
    <!-- Dropdown header -->
    <h6 class="dropdown-header">
      You have <strong class="text-primary">{{auth()->user()->unreadNotifications->count()}}</strong> notifications.
        @if (auth()->user()->unreadNotifications->count())
          <a class="text-primary" href="{{ route('databasenotifications.markasread') }}">Mark All as Read</a>
        @endif
    </h6>
    <!-- List group -->
    <div class="list-group list-group-flush">
      @foreach (auth()->user()->notifications as $notification)
      <a href="#" class="list-group-item">
            <div class="d-flex justify-content-between align-items-center">
              <div class="text-right text-muted">
                <small>
                  @if (is_null($notification->read_at))
                    <i class="fa fa-check text-primary" aria-hidden="true"></i>
                  @else
                    <i class="fa fa-check text-danger" aria-hidden="true"></i>
                  @endif
                </small>
                <small>{{$notification->created_at}} ago</small>
              </div>
            </div>
            <p class="text-sm mb-0">{{$notification->data['data']}}</p>
      </a>
      @endforeach
    </div>
    <!-- View all -->
    <!-- <div class="dropdown-divider"></div>
    <a href="#!" class="dropdown-item text-center text-primary">View all</a> -->
  </div>
</div>
@endauth
</div>