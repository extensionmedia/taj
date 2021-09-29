<tbody class="bg-white bg-opacity-90 divide-y divide-gray-300">
    @foreach ($types as $p)
        @include('settings.pages.produit_type.table.row')
    @endforeach
</tbody>
