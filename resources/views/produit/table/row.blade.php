<tr class="hover:bg-gray-50 hover:bg-opacity-50">
    <td class="px-4 py-4 whitespace-nowrap">
      <div class="flex items-center">
        <div class="flex-shrink-0 h-10 w-10">
          <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60" alt="">
        </div>
        <div class="ml-4">
          <div class="text-xl font-medium text-gray-900">
            {{ $p->code }}
          </div>
          <div class="text-xs text-gray-500">
            {{ $p->barcode }}
          </div>
          <div class="text-xs text-gray-500">
            {{ $p->barcode_2 }}
          </div>
        </div>
      </div>
    </td>
    <td class="px-4 py-4 whitespace-nowrap">
      <div class="text-sm text-gray-900">
            @if ($p->category)
                {{  $p->category->produit_category }}
            @else
                --
            @endif
        </div>
      <div class="text-sm text-gray-500">
            @if ($p->sous_category)
                {{  $p->sous_category->produit_category }}
            @endif
      </div>
    </td>
    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
        @foreach ($p->magasins as $magasin)
            @if ($magasin->magasin)
                {{  $magasin->magasin->magasin_name }}
            @else
                --
            @endif
        @endforeach
    </td>
    <td class="px-4 py-4 whitespace-nowrap">
      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
        {{  $p->status->produit_status }}
      </span>
    </td>
    <td class="px-4 py-4 whitespace-nowrap text-right text-green-600 text-xs font-bold text-gray-500 bg-green-50 bg-opacity-50">
        {{ $p->prix_location }} DH
    </td>
    <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
      <a href="{{route('produit.edit', $p)}}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
    </td>
  </tr>
