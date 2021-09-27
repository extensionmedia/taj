<tr class="hover:bg-gray-50 hover:bg-opacity-50">
    <td class="px-4 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-700">
            {{  $p->produit_category }}
        </div>
    </td>
    <td class="px-4 py-4 whitespace-nowrap">
      <div class="text-sm text-gray-700">
          {{  $p->produits->count() }}
      </div>
    </td>
    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
            Activé
        </span>
    </td>
    <td class="px-4 py-4 whitespace-nowrap">
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
            par default
        </span>
    </td>
    <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
      <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
    </td>
  </tr>
