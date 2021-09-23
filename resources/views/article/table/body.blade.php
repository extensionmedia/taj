<tbody class="bg-white divide-y divide-gray-200">
    @for ($i = 0; $i < 20; $i++)
        @include('article.table.row')
    @endfor
</tbody>
