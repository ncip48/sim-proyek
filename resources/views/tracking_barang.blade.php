<div>
    <div>
        <table class="w-full ring-1 ring-gray-950/5 dark:ring-white/10 rounded-xl bg-white dark:bg-gray-900">
            <thead class="bg-gray-50 dark:bg-white/5">
                <tr class="">
                    <th class="text-left py-4 ps-3">Name</th>
                    <th class="text-left">Qty</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $product)
                    <tr class="">
                        <td class="text-sm ps-3 gap-y-1 px-3 py-4">
                            {{ $product->item->name }}
                        </td>
                        <td class="text-sm gap-y-1 px-3 py-4">
                            {{ $product->qty }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">
                            <x-filament-tables::empty-state heading="No Items" icon="heroicon-o-x-mark" />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
