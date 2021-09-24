@php
    $navs = [
        [
            'label'         =>  'الكراء',
            'icon'          =>  '<i class="far fa-calendar-alt"></i>',
            'style'         =>  'text-gray-50 font-bold text-center',
            'background'    =>  'bg-green-500',
            'route'         =>  route("produit.list")
        ],
        [
            'label'         =>  'البيع',
            'icon'          =>  '<i class="fas fa-shopping-bag"></i>',
            'style'         =>  'text-gray-50 font-bold text-center',
            'background'    =>  'bg-green-500',
            'route'         =>  'route("article.list")'
        ],
        [
            'label'         =>  'المداخيل',
            'icon'          =>  '<i class="fas fa-cash-register"></i>',
            'style'         =>  'text-gray-50 font-bold text-center',
            'background'    =>  'bg-yellow-500',
            'route'         =>  'route("article.list")'
        ],
        [
            'label'         =>  'الديون',
            'icon'          =>  '<i class="fas fa-funnel-dollar"></i>',
            'style'         =>  'text-gray-50 font-bold text-center',
            'background'    =>  'bg-red-500',
            'route'         =>  'route("article.list")'
        ],
        [
            'label'         =>  'المنتجات',
            'icon'          =>  '<i class="fas fa-tshirt"></i>',
            'style'         =>  'text-gray-50 font-bold text-center',
            'background'    =>  'bg-blue-500',
            'route'         =>  route("produit.list")
        ],
        [
            'label'         =>  'التقارير',
            'icon'          =>  '<i class="fas fa-chart-line"></i>',
            'style'         =>  'text-gray-50 font-bold text-center',
            'background'    =>  'bg-yellow-900',
            'route'         =>  'route("article.list")'
        ],
        [
            'label'         =>  'المستخدمين',
            'icon'          =>  '<i class="fas fa-user-friends"></i>',
            'style'         =>  'text-gray-50 font-bold text-center',
            'background'    =>  'bg-blue-500',
            'route'         =>  'route("article.list")'
        ],
        [
            'label'         =>  'خصائص',
            'icon'          =>  '<i class="fas fa-wrench"></i>',
            'style'         =>  'text-gray-50 font-bold text-center',
            'background'    =>  'bg-gray-500',
            'route'         =>  'route("article.list")'
        ]
    ];
@endphp

<div class="grid grid-cols-4 gap-4">
    @foreach ($navs as $n)

        <a href={{$n["route"]}} class="{{$n["background"]}} bg-opacity-50 rounded-lg py-4 cursor-pointer hover:border-4 hover:bg-opacity-60">
            <div class="{{$n["style"]}} text-4xl mb-4">
                {!!$n["icon"]!!}
            </div>
            <div class="{{$n["style"]}} text-2xl">
                {{ $n["label"] }}
            </div>
        </a>

    @endforeach
</div>
