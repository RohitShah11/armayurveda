@php
  $node = $item['node'];
  $isAdmin = $item['type'] === 'admin';
  $cardClass = $isAdmin ? 'admin' : '';
  $iconClass = $isAdmin ? 'admin' : '';
  $initial = $isAdmin ? 'A' : strtoupper(substr($item['label'], 0, 1));
@endphp

<ul>
  <li>
    <a href="{{ route('admin.direct-tree.tree', ['node' => $node->id]) }}" class="direct-node-card {{ $cardClass }}">
      <span class="node-icon {{ $iconClass }}">{{ $initial }}</span>
      <span class="node-name">{{ $item['label'] }}</span>
      <span class="node-meta">#{{ $node->id }} | {{ $item['sub_label'] }}</span>
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
