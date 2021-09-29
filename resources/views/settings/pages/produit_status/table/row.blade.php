<tr class="hover:bg-gray-50 hover:bg-opacity-50">
    <td class="px-4 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-700">
            {{  Str::upper($p->produit_status) }}
        </div>
    </td>
    <td class="px-4 py-4 whitespace-nowrap">
      <div class="text-lg text-blue-700 text-center">
          {{  $p->produits->count() }}
      </div>
    </td>
    <td class="px-4 py-4 text-center whitespace-nowrap text-sm text-gray-500">
        @if ($p->status)
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                Activé
            </span>
        @else
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                Désactivé
            </span>
        @endif

    </td>
    <td class="px-4 py-4 text-center whitespace-nowrap">
        @if ($p->is_default)
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                par default
            </span>
        @endif
    </td>
    <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
      <a href="{{route('produit_status.edit', ['produitStatus'=>$p])}}" class="edit text-gray-600 hover:text-xl hover:text-indigo-900"><i class="far fa-edit"></i></a>
    </td>
  </tr>
