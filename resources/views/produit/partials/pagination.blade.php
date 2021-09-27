<div class="flex items-center py-2 justify-between">
    <div class="count text-gray-100">
        Total : @if($produits) {{ $produits->count() }} @endif
    </div>
    <div class="">
        <select name="pp" id="pp" class="py-1 px-2 border rounded">
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>
</div>