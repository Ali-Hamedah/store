<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell fa-lg""></i>
        @if ($newCount)
        <span class="badge badge-warning navbar-badge" style="font-size: 10px;">{{ $newCount }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"  style="width: 260px">
        <span class="dropdown-header">{{ $newCount }} {{ __('main.notifications') }}</span>
        <div class="dropdown-divider"></div>
        @foreach($notifications as $notification)
        <form action="{{ route('dashboard.markAsRead', $notification->id) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="dropdown-item text-wrap @if ($notification->unread()) text-bold @endif">
                <i class="{{ $notification->data['icon'] }} mr-2"></i> {{ $notification->data['body'] }}
            </button>
    </form>
        <div class="dropdown-divider"></div>
        @endforeach
        <a href="{{ route('dashboard.ReadAll') }}" class="dropdown-item dropdown-footer">   <span class="dropdown-header">{{ __('main.view_all') }}</span>   </a>
    </div>
</li>

