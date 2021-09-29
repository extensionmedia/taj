<tbody class="bg-white bg-opacity-90 divide-y divide-gray-300">
    @foreach ($statuses as $p)
        @include('settings.pages.produit_status.table.row')
    @endforeach
</tbody>
