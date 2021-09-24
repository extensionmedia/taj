<tbody class="bg-white bg-opacity-90 divide-y divide-gray-300">
    @foreach ($produits as $p)
        @include('produit.table.row')
    @endforeach
</tbody>
