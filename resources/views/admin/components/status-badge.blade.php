@php
$map = [
    'pending' => 'bg-[#f8ecd6] text-[#a4732d]',
    'confirmed' => 'bg-[#e6eee4] text-[#5f715f]',
    'processing' => 'bg-[#e9ebe6] text-[#62695e]',
    'shipped' => 'bg-[#ece8df] text-[#73695d]',
    'delivered' => 'bg-[#e1f2df] text-[#4e9b55]',
    'cancelled' => 'bg-[#fbe3e2] text-[#c76b68]',
    'paid' => 'bg-[#e1f2df] text-[#4e9b55]',
    'success' => 'bg-[#e1f2df] text-[#4e9b55]',
    'unpaid' => 'bg-[#ece8e1] text-[#6f675f]',
    'initiated' => 'bg-[#e6eee4] text-[#5f715f]',
    'failed' => 'bg-[#fbe3e2] text-[#c76b68]',
    'refunded' => 'bg-[#f8ecd6] text-[#a4732d]',
    'active' => 'bg-[#e1f2df] text-[#4e9b55]',
    'inactive' => 'bg-[#ece8e1] text-[#6f675f]',
];
$className = $map[$value] ?? 'bg-[#ece8e1] text-[#6f675f]';
@endphp
<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $className }}">{{ ucfirst((string) $value) }}</span>
