<tbody class="bg-white bg-opacity-90 divide-y divide-gray-300">
    @foreach ($colors as $p)
        @include('settings.pages.produit_color.table.row')
    @endforeach
</tbody>
