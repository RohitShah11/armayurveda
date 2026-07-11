@php
  $node = $item['node'];
  $owner = $item['owner'];
  $isEmpty = $item['type'] === 'empty';
  $isAdmin = $item['type'] === 'admin';
  $cardClass = $isEmpty ? 'empty' : ($isAdmin ? 'admin' : '');
  $iconClass = $isEmpty ? 'empty' : ($isAdmin ? 'admin' : '');
  $initial = $isEmpty ? '+' : ($isAdmin ? 'A' : strtoupper(substr($item['label'], 0, 1)));
@endphp

<ul>
  <li>
    @if($isEmpty)
      <div class="pool-node-card {{ $cardClass }}">
        <span class="node-icon {{ $iconClass }}">{{ $initial }}</span>
        <span class="node-name">{{ $item['label'] }}</span>
        <span class="node-meta">{{ $item['sub_label'] }}</span>
      </div>
    @else
      <a href="{{ route('admin.zenith-pool.tree', ['node' => $node->id]) }}" class="pool-node-card {{ $cardClass }}">
        <span class="node-icon {{ $iconClass }}">{{ $initial }}</span>
        <span class="node-name">{{ $item['label'] }}</span>
        <span class="node-meta">#{{ $node->id }} | {{ $item['sub_label'] }}</span>
        <span class="node-levels">
          @forelse($item['completed_levels'] as $level)
            <span class="level-chip">L{{ $level }}</span>
          @empty
            <span class="node-meta">No payout</span>
          @endforelse
        </span>
      </a>
    @endif

    @if(! empty($item['children']))
      <ul>
        @foreach($item['children'] as $child)
          @include('admin.zenith-pool.partials.tree-node-branch', ['item' => $child])
        @endforeach
      </ul>
    @endif
  </li>
</ul>
