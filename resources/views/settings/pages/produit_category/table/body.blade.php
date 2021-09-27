<tbody class="bg-white bg-opacity-90 divide-y divide-gray-300">
    @foreach ($categories as $p)
        @include('settings.pages.produit_category.table.row')
    @endforeach
</tbody>
