@props(['classType' => ''])
<li class="nav-item">
    <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-{{ $classType }}"></i>
        <p>
            {{ $title }}
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @foreach ($links as $link)
            <li class="nav-item">
                <a href="{{ $link['url'] }}" class="nav-link">
                    <i></i>
                    <p>{{ $link['label'] }}</p>
                </a>
            </li>
        @endforeach
    </ul>
</li>
