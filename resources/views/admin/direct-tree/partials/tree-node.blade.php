@php
  $user = $item['user'];
  $statusClass = $item['has_purchased'] ? 'purchased' : 'not-purchased';
  $initial = strtoupper(substr($item['label'], 0, 1));
@endphp

<ul>
  <li>
    <a href="{{ route('admin.direct-tree.tree', ['member' => $user->id]) }}" class="direct-node-card {{ $statusClass }}">
      <span class="node-icon {{ $statusClass }}">{{ $initial }}</span>
      <span class="node-name">{{ $item['label'] }}</span>
      <span class="node-meta">{{ $item['sub_label'] }}</span>
    </a>

    @if(! empty($item['children']))
      <ul>
        @foreach($item['children'] as $child)
          @include('admin.direct-tree.partials.tree-node-branch', ['item' => $child])
        @endforeach
      </ul>
    @endif
  </li>
</ul>
