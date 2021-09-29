<tbody class="bg-white bg-opacity-90 divide-y divide-gray-300">
    @foreach ($marques as $p)
        @include('settings.pages.produit_marque.table.row')
    @endforeach
</tbody>
